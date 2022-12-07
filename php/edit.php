<?php
// error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';
$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = [
        'name' => $_POST["name"],
        'type1' => $_POST["type1"],
        'type2' => $_POST["type2"],
        'hp' => $_POST["hp"],
        'attack' => $_POST["attack"],
        'defense' => $_POST["defense"],
        'spatk' => $_POST["spatk"],
        'spdef' => $_POST["spdef"],
        'speed' => $_POST["speed"],
        'generation' => $_POST["generation"],
        'legendary' => $_POST["legendary"]
    ];

    $populated_fields = [];

    // get all populated fields
    foreach ($fields as $key => $value) {
        if ($value != '') {
            array_push($populated_fields, $key);
        }
    }

    // ensure an edit is actually being made
    if(empty($populated_fields)) {
        echo json_encode('No values were edited!');
        die();
    }

    $sql = 'UPDATE pokemon SET';

    foreach ($populated_fields as $field) {
        $sql .= ' ' . $field . '="' . $fields[$field] . '",';
    }
    $sql = rtrim($sql, ',');
    $sql .= ' WHERE number=' . $_POST['number'];

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_execute($stmt);
        echo json_encode('Successfully edited stats!');
    }
    mysqli_stmt_close($stmt);
}

?>