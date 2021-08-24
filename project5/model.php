<?php
    $model = new Model();
    $protection = isset($_POST["form_checkbox"]);
    $result = "";
    $id = $_POST['form_query'];
    if($protection){
        $result = $model->exec_protected($id);
    }
    else {
        $result = $model->exec_unprotected($id);
    }
    echo json_encode($result);

    class Model
    {
        private PDO $connetion;
        public function __construct()
        {
            try
            {
                $this->connection = new PDO('pgsql:host=localhost;port=5432;user=postgres;password=empty;dbname=task3_db');
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
        }

        public function exec_protected($data)
        {
            $sql_statement = "SELECT * FROM request WHERE id=:id";
            try
            {
                $query = $this->connection->prepare($sql_statement);
                $query->bindParam(":id", $data);
                $query->execute();
                return $query->fetchAll();
            }
            catch(Exception $e)
            {
                return ['error' => true];
            }
        }

        public function exec_unprotected($data)
        {
            $sql_statement = "SELECT * FROM request WHERE id=".$data;
            try
            {
                $query = $this->connection->prepare($sql_statement);
                $query->execute();
                return $query->fetchAll();
            }
            catch(Exception $e)
            {
                return ['error' => true];
            }
        }
    }
?>