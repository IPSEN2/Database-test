<?php

const TOTAL_RUNS = 6;
const RESULTS_FILE_NAME = __DIR__ . '/results_export.txt';
const MYSQL_PATH = "C:\/ProgramData/MySQL/MySQL Server 8.0/Uploads/";

// connect to databases
$connMariadb = mysqli_connect("localhost", "root", "toor", "test_data");
$connMysql = mysqli_connect("localhost", "root", "toor", "test_data", 3307);
$connPostgres = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=toor");
$connSqlite = new SQLite3(__DIR__ . '/test.sqlite3');

unlink(RESULTS_FILE_NAME);

for ($i=0; $i < TOTAL_RUNS; $i++) { 
    // test mariadb time to export 500000 rows
    $start = microtime(true);
    $result = mysqli_query($connMariadb, "SELECT * FROM answers INTO OUTFILE '" .time() . ".csv' FIELDS ENCLOSED BY '\"' TERMINATED BY ',' ESCAPED BY '\"' LINES TERMINATED BY '\\n';");
    $end = microtime(true);
    echo "Mariadb: " . ($end - $start) . " seconds" . PHP_EOL;
    file_put_contents(RESULTS_FILE_NAME, "Mariadb: " . ($end - $start) . PHP_EOL, FILE_APPEND);

    // test mysql time to export 500000 rows
    $start = microtime(true);
    $result = mysqli_query($connMysql, "SELECT * FROM answers INTO OUTFILE '" . MYSQL_PATH . time() . ".csv' FIELDS ENCLOSED BY '\"' TERMINATED BY ',' ESCAPED BY '\"' LINES TERMINATED BY '\n';");
    $end = microtime(true);
    echo "Mysql: " . ($end - $start) . " seconds" . PHP_EOL;
    file_put_contents(RESULTS_FILE_NAME, "Mysql: " . ($end - $start) . PHP_EOL, FILE_APPEND);

    // test postgres time to export 500000 rows
    $start = microtime(true);
    $result = pg_query($connPostgres, "COPY answers TO '" . __DIR__ . "/" .time() . ".csv' DELIMITER ',' CSV HEADER;");
    $end = microtime(true);
    echo "Postgres: " . ($end - $start) . " seconds" . PHP_EOL;
    file_put_contents(RESULTS_FILE_NAME, "Postgres: " . ($end - $start) . PHP_EOL, FILE_APPEND);
}