<?php
include './dbconnect.php';

$conn = db_connect();
$sql = 'DROP TABLE pokemon';

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

?>