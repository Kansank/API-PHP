<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once 'config/Database.php';
include_once 'Task.php';
$database = new Database();
$db = $database->dbConnect();
$task = new Task($db);

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $stmt = $task->getAll();

        $num = $stmt->rowCount();
        
        if($num>0){
            $tasks_arr=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $task_item = array(
                "taskID" => $taskID,
                "name" => $name,
                "status" => $status
                );
                array_push($tasks_arr, $task_item);
            }
            echo json_encode($tasks_arr);
            }else{
                echo json_encode(
                array("message" => "No tasks found.")
            );
            }     
    }else{
        http_response_code(405);
    }    