<?php
require_once "Response.php";


class DatabaseAction
{
    private mysqli $conn;
    private bool $databaseAccess;
    public function __construct()
    {
        $connect = new Database("root", "", "tibor_paragh", "localhost");
        if($connect->tryConnect()){
           $this->conn = $connect->getConnection();
           $this->databaseAccess = true;
        } else {
            $this->databaseAccess = false;
        }
        
    }
    public function Update($sql): Response
    {
        return $this->UpdateAndDeleteAndInsertExecute($sql);
    }

    public function Insert($sql): Response
    {
        return $this->UpdateAndDeleteAndInsertExecute($sql);
    }

    public function Delete($sql): Response
    {
        return $this->UpdateAndDeleteAndInsertExecute($sql);
    }

    public function Select($sql): Response
    {
        return $this->SelectExecute($sql);
    }

    private function UpdateAndDeleteAndInsertExecute(string $sql): Response
    {
        if(!$this->databaseAccess) return null;
        if ($this->conn->query($sql) === TRUE)  return new Response(True, "", 200);
        return new Response(False, "", 500);
    }
    private function SelectExecute(string $sql): Response
    {
        if(!$this->databaseAccess) return null;
       
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return new Response("Error preparing statemenet","", 500);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $this->conn->close();
        return new Response($data, json_encode($data), 200);
    }
}
