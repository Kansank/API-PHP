<?php 
    class Database{
        protected $host = 'localhost';
        protected $dbname = 'tasks';
        protected $user = 'root';
        protected $password = '';
        

        public function dbConnect(){
            try{
                $con = new PDO('mysql:host='.$this->host.'; dbname='.$this->dbname.';', $this->user, $this->password);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                return $con;
            } catch(PDOException $e){
                echo "Fail to connect database ". $e->getMessage();
            }
           
        }
        public function dbDisconnect($con){
            $con = null;
        }    
        
    }
?>