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
        if ($i == 2) continue; // skip check on type 2 as it is not required
        if (empty($fields[$i]) && $fields[$i] != 0) {
            echo json_encode('All fields except type 2 are required!');
            die();
        }
    }

    if (!file_exists($_FILES['pokemon-image']['tmp_name'])) {
        echo json_encode('An image must be provided!');
        die();
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

    // get desired file name of img from db (number of insertion)
    $sql = 'SELECT `number` FROM `pokemon` ORDER BY number DESC LIMIT 1';
    $filebasename;
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_row(mysqli_stmt_get_result($stmt));
        $filebasename = $row[0];
    }
    mysqli_stmt_close($stmt);

    $fileinfo = pathinfo($_FILES['pokemon-image']['name']); // file path info
    $fileext = $fileinfo['extension']; // file extension
    $filename = $filebasename . '.' . $fileext; // build file name
    $target = '../data/user_images/' . $filename; // final desired file path

    if (move_uploaded_file($_FILES['pokemon-image']['tmp_name'], $target)) {
        echo json_encode('Successfully inserted data!');
    };

}

?>