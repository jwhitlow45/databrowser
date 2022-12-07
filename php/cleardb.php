<?php
// error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';
$conn = db_connect();

$sql = 'DROP TABLE pokemon';

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// delete all user images when db is cleared
$files = glob('../data/user_images/*.png');
foreach($files as $file) {
    if (is_file($file)) {
        unlink($file); // delete file
    }
}

echo json_encode('Succesfully cleared database');

?>