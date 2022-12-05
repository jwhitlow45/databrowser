<?php
// error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';
$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = [
        $_POST["name"],
        $_POST["type1"],
        $_POST["type2"],
        $_POST["hp"],
        $_POST["attack"],
        $_POST["defense"],
        $_POST["spatk"],
        $_POST["spdef"],
        $_POST["speed"],
        $_POST["generation"],
        $_POST["legendary"]
    ];

    for ($i = 0; $i < count($fields); $i++) {
        if ($i == 3) continue; // skip check on type 2 as it is not required
        if (empty($fields[$i]) && $fields[$i] != 0) {
            echo json_encode('All fields except type 2 are required!');
            die();
        }
    }

    $sql = '';

    if (empty($_POST['type2'])) {
        $sql = 'INSERT INTO pokemon (name, type1, type2, hp, attack, defense, spatk, spdef, speed, generation, legendary)
                VALUES (?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?);';
    } else {
        $sql = 'INSERT INTO pokemon (name, type1, type2, hp, attack, defense, spatk, spdef, speed, generation, legendary)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
    }


    if ($stmt = mysqli_prepare($conn, $sql)) {

        if (empty($_POST['type2'])) {
            mysqli_stmt_bind_param($stmt, "ssiiiiiiii",
                $_POST["name"],
                $_POST["type1"],
                $_POST["hp"],
                $_POST["attack"],
                $_POST["defense"],
                $_POST["spatk"],
                $_POST["spdef"],
                $_POST["speed"],
                $_POST["generation"],
                $_POST["legendary"]
            );
        } else {
            mysqli_stmt_bind_param($stmt, "sssiiiiiiii",
                $_POST["name"],
                $_POST["type1"],
                $_POST["type2"],
                $_POST["hp"],
                $_POST["attack"],
                $_POST["defense"],
                $_POST["spatk"],
                $_POST["spdef"],
                $_POST["speed"],
                $_POST["generation"],
                $_POST["legendary"]
            );
        }

        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    echo 'Successfully inserted data!';
}

?>