<?php
class Task{
    protected $conn;
    protected $table_name = "tasks";

    public function __construct($db){
        $this->conn = $db;
    }
    public function getAll(){
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY taskID ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function  insertTask($name){
        $query = "INSERT INTO " . $this->table_name . " (taskID, name, status) VALUES(NULL,:name,0)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
        
    }
    public function updateStatusTask($taskID){
        $query = "UPDATE " . $this->table_name . " SET status = 1 WHERE taskID = :taskID ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':taskID', $taskID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
    public function deleteTaskByID($taskID){
        $query = "DELETE FROM tasks WHERE taskID = :taskID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':taskID', $taskID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
?>