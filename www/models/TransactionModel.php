<?php

class TransactionModel
{
    public $db;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "CALL `get_transactions`()";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return json_encode(array('status' => true, 'data' => $data));
    }

    public function getByID($Booking_ID)
    {
        $sql = "CALL `get_transaction_by_id`(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($Booking_ID));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return json_encode(array('status' => true, 'data' => $data));
    }

    public function getRevenue($Month)
    {
        $sql = "CALL `get_revenue_of_month`(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($Month));
        } catch (PDOException $ex) {
            return (json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $labels = [];
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $labels[] = $row['order_date'];
            $data[] = $row['total_price'];
        }
        return json_encode(array('status' => true, 'data' => [$labels,$data]));
    }
}
