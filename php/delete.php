<?php
// error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';
$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = 'DELETE FROM pokemon WHERE number=?';
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $_POST['number']);
        mysqli_stmt_execute($stmt);
    } else {
        echo json_encode('Error deleting data!');
    }
    mysqli_stmt_close($stmt);
    echo json_encode('Successfully deleted data!');
}

?>