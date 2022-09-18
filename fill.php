<?php

// connect to mysql database
$connMariadb = mysqli_connect("localhost", "root", "toor", "test_data");
$connMysql = mysqli_connect("localhost", "root", "toor", "test_data", 3307);
$connPostgres = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=toor");
$connSqlite = new SQLite3(__DIR__ . '/test.sqlite3');

// truncate tables
mysqli_query($connMariadb, "TRUNCATE TABLE answers");
mysqli_query($connMysql, "TRUNCATE TABLE answers");
pg_query($connPostgres, "TRUNCATE TABLE answers");
$connSqlite->exec("DELETE FROM answers");


// define dummy data
const DUMMY_DATA = [
    "client" => 1231231,
    "time" => 1663502436,
    "question" => 121245,
    "answer_score" => 1,
    "answer_text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris. Maecenas congue ligula ac quam viverra nec consectetur ante hendrerit. Donec et mollis dolor. Praesent et diam eget libero egestas mattis sit amet vitae augue. Nam tincidunt congue enim, ut porta lorem lacinia consectetur. Donec ut libero sed arcu vehicula ultricies a non tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut gravida lorem. Ut turpis felis, pulvinar a semper sed, adipiscing id dolor. Pellentesque auctor nisi id magna consequat sagittis. Curabitur dapibus enim sit amet elit pharetra tincidunt feugiat nisl imperdiet. Ut convallis libero in urna ultrices accumsan. Donec sed odio eros. Donec viverra mi quis quam pulvinar at malesuada arcu rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In rutrum accumsan ultricies. Mauris vitae nisi at sem facilisis semper ac in est.",
];
const DUMMY_DATA_COUNT = 500000;


// insert dummy data for mariadb and mysql
$sql = "INSERT INTO answers (client, question, answer_score, answer_text) VALUES ('" . DUMMY_DATA['client'] . "', '" . DUMMY_DATA['question'] . "', '" . DUMMY_DATA['answer_score'] . "', '" . DUMMY_DATA['answer_text'] . "')";
for ($i=0; $i < DUMMY_DATA_COUNT; $i++) { 
    echo "Inserting data for mariadb: " . $i . " of " . DUMMY_DATA_COUNT . " " . round($i / DUMMY_DATA_COUNT * 100, 2) . "%\r";
    mysqli_query($connMariadb, $sql);
}
for ($i=0; $i < DUMMY_DATA_COUNT; $i++) {
    echo "Inserting data for mysql: " . $i . " of " . DUMMY_DATA_COUNT . " " . round($i / DUMMY_DATA_COUNT * 100, 2) . "%\r";
    mysqli_query($connMysql, $sql);
}

// insert dummy data for postgres
for ($i=0; $i < DUMMY_DATA_COUNT; $i++) { 
    echo "Inserting data for postgres: " . $i . " of " . DUMMY_DATA_COUNT . " " . round($i / DUMMY_DATA_COUNT * 100, 2) . "%\r";
    pg_query($connPostgres, "INSERT INTO answers (client, time, question, answer_score, answer_text) VALUES ('" . DUMMY_DATA['client'] . "', '" . date("Y-m-d h:i:sa") . "', '" . DUMMY_DATA['question'] . "', '" . DUMMY_DATA['answer_score'] . "', '" . DUMMY_DATA['answer_text'] . "')");
}

// insert dummy data for sqlite
for ($i=0; $i < DUMMY_DATA_COUNT; $i++) { 
    echo "Inserting data for sqlite: " . $i . " of " . DUMMY_DATA_COUNT . " " . round($i / DUMMY_DATA_COUNT * 100, 2) . "%\r";
    $connSqlite->exec("INSERT INTO answers (client, time, question, answer_score, answer_text) VALUES ('" . DUMMY_DATA['client'] . "', '" . DUMMY_DATA['time'] . "', '" . DUMMY_DATA['question'] . "', '" . DUMMY_DATA['answer_score'] . "', '" . DUMMY_DATA['answer_text'] . "')");
}