<?php

class TicketModel
{
    public $db;

    public function getAll()
    {
        $sql = 'SELECT * FROM ticket';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }

        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return json_encode(array('status' => true, 'data' => $data));
    }

    public function add($ID, $SCH_ID, $BOO_ID, $SEAT_ID, $price)
    {
        $sql = 'INSERT INTO ticket(ID, SCH_ID, BOO_ID, SEAT_ID, price) VALUE(?,?,?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($ID, $SCH_ID, $BOO_ID, $SEAT_ID, $price));

            return json_encode(array('status' => true, 'data' => 'Thêm ticket thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
}
