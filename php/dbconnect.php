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
    $populate_table_query = 'INSERT IGNORE INTO pokemon SELECT * FROM pokemon_original WHERE NOT EXISTS (SELECT * FROM pokemon)';
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

function ensure_main_table_exists() {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

    $table_sql = 'CREATE TABLE IF NOT EXISTS pokemon_original (
        number INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(18) NOT NULL,
        type1 VARCHAR(8) NOT NULL,
        type2 VARCHAR(8),
        hp INT NOT NULL,
        attack INT NOT NULL,
        defense INT NOT NULL,
        spatk INT NOT NULL,
        spdef INT NOT NULL,
        speed INT NOT NULL,
        generation INT NOT NULL,
        legendary TINYINT NOT NULL
    );';

    if ($stmt = mysqli_prepare($conn, $table_sql)) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $check_empty_query = 'SELECT * FROM pokemon_original';
    $results = mysqli_query($conn, $check_empty_query);
    if (mysqli_num_rows($results) == 0) {
        $csv_path = '../data/pokemon_original.csv';
        $csv_file = fopen($csv_path, "r");
        while (($row = fgetcsv($csv_file)) !== FALSE) {
            $stmt = $conn->prepare(
                'INSERT INTO pokemon_original (
                    number, name, type1, type2, hp, attack, defense, spatk, spdef, speed, generation, legendary)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
                ');
            $stmt->bind_param("isssiiiiiiii", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11],);
            $stmt->execute();
        }
    }
}

function db_connect() {
    parse_db_credentials();
    ensure_db_exists();
    ensure_main_table_exists();

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
    ensure_tables_exist($conn);

    // flag false connection
    if ($conn == false) { die("ERROR: Could not connect. " . mysqli_connect_error()); }

    return $conn;
}

?>