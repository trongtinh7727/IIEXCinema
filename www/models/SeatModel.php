<?php

class SeatModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getByTheater($theater_id)
    {
        $sql = "select * from seat where THE_ID = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($theater_id));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return json_encode(array('status' => true, 'data' => $data));
    }
}
