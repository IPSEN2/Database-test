<?php

ini_set('memory_limit','4096M');

const TOTAL_RUNS = 6;
const RESULTS_FILE_NAME = __DIR__ . '/results_select.txt';

// connect to mysql database
$connMariadb = mysqli_connect("localhost", "root", "toor", "test_data");
$connMysql = mysqli_connect("localhost", "root", "toor", "test_data", 3307);
$connPostgres = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=toor");
$connSqlite = new SQLite3(__DIR__ . '/test.sqlite3');

for ($i=0; $i < TOTAL_RUNS; $i++) { 
    // test mariadb time to fetch 500000 rows
    $start = microtime(true);
    $result = mysqli_query($connMariadb, "SELECT * FROM answers");
    while ($row = mysqli_fetch_assoc($result)) {
        // do nothing
    }
    $end = microtime(true);
    echo "Mariadb: " . ($end - $start) . " seconds" . PHP_EOL;
    file_put_contents(RESULTS_FILE_NAME, "Mariadb: " . ($end - $start) . PHP_EOL, FILE_APPEND);

    // test mysql time to fetch 500000 rows
    $start = microtime(true);
    $result = mysqli_query($connMysql, "SELECT * FROM answers");
    while ($row = mysqli_fetch_assoc($result)) {
        // do nothing
    }
    $end = microtime(true);
    echo "Mysql: " . ($end - $start) . " seconds" . PHP_EOL;
    file_put_contents(RESULTS_FILE_NAME, "Mysql: " . ($end - $start) . PHP_EOL, FILE_APPEND);

    // test postgres time to fetch 500000 rows
    $start = microtime(true);
    $result = pg_query($connPostgres, "SELECT * FROM answers");
    while ($row = pg_fetch_assoc($result)) {
        // do nothing
    }
    $end = microtime(true);
    echo "Postgres: " . ($end - $start) . " seconds" . PHP_EOL;
    file_put_contents(RESULTS_FILE_NAME, "Postgres: " . ($end - $start) . PHP_EOL, FILE_APPEND);

    // test sqlite time to fetch 500000 rows
    $start = microtime(true);
    $result = $connSqlite->query("SELECT * FROM answers");
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // do nothing
    }
    $end = microtime(true);
    echo "Sqlite: " . ($end - $start) . " seconds" . PHP_EOL;
    file_put_contents(RESULTS_FILE_NAME, "Sqlite: " . ($end - $start) . PHP_EOL, FILE_APPEND);
}