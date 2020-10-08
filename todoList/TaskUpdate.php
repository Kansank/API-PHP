<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once 'config/Database.php';
include_once 'Task.php';
$database = new Database();
$db = $database->dbConnect();
$task = new Task($db);

   if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        
            if( $_POST["taskID"] && ($_POST["updateTask"] =="updateTask") ){

                $stmt = $task->updateStatusTask($_POST["taskID"]);
                echo json_encode(
                    array("message" => "Update Successfully."));
                 
            }
  
}else{
    http_response_code(405);
} 