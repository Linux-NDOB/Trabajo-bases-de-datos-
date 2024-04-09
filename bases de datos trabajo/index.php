<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

require ("Main.php");
$method = $_GET['method'];
$db = new Database();

if ($method == "create"){
    $table_name = $_GET['table_name'];
    $data = file_get_contents('php://input');
    $db->create($table_name, $data);
} else if ($method == "read") {
    $id = $_GET['id'];
    $table_name = $_GET['table_name'];
    $db->read($table_name, $id);
} else if ($method == "update") {
    $id = $_GET['id'];
    $table_name = $_GET['table_name'];
    $data = file_get_contents('php://input');
    $db->update($table_name, $id, $data);

} else if ($method == "delete") {
    $id = $_GET['id'];
    $table_name = $_GET['table_name'];
    $db->delete($table_name, $id);
} else if($method == "32"){
    $id = $_GET['id'];
    $db->point32($id);
} else if($method == "33"){
    $id = $_GET['id'];
    $db->point33($id);
}



