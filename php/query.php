<?php
include './dbconnect.php';

$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = 'SELECT * from pokemon';
    $pokemon_arr = array();
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_row($result)) {
            array_push($pokemon_arr, [
                'number' => $row[0],	
                'name' => $row[1],	
                'type1' => $row[2],	
                'type2' => $row[3],	
                'hp' => $row[4],	
                'attack' => $row[5],	
                'defense' => $row[6],	
                'spatk' => $row[7],	
                'spdef' => $row[8],	
                'speed' => $row[9],	
                'generation' => $row[10],	
                'legendary' => $row[11]
            ]);
        }
    }
    mysqli_stmt_close($stmt);
    echo json_encode($pokemon_arr);
}
?>