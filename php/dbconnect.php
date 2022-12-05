<?php

function parse_db_credentials() {
    $db_params = parse_ini_file('./dbcredentials.ini');
    define('DB_SERVER', $db_params['server']);
    define('DB_USERNAME', $db_params['username']);
    define('DB_PASSWORD', $db_params['password']);
    define('DB_NAME', $db_params['dbname']);
    define('DB_PORT', $db_params['port']);
}

function ensure_tables_exist($conn) {
    $pokemon_table_query = 'CREATE TABLE IF NOT EXISTS pokemon LIKE pokemon_original';
    $populate_table_query = 'INSERT IGNORE INTO pokemon SELECT * FROM pokemon_original';
    if ($stmt = mysqli_prepare($conn, $pokemon_table_query)) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    if ($stmt = mysqli_prepare($conn, $populate_table_query)) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function ensure_db_exists() {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, port:DB_PORT);
    $sql = 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME . ';';
    $conn->query($sql);
}

function db_connect() {
    parse_db_credentials();
    ensure_db_exists();

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
    ensure_tables_exist($conn);

    // flag false connection
    if ($conn == false) { die("ERROR: Could not connect. " . mysqli_connect_error()); }

    return $conn;
}

?>