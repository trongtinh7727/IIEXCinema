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

    public function add( $SCH_ID, $BOO_ID, $SEAT_ID, $price)
    {
        $sql = 'INSERT INTO ticket( SCH_ID, BOO_ID, SEAT_ID, price) VALUE(?,?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array( $SCH_ID, $BOO_ID, $SEAT_ID, $price));

            return json_encode(array('status' => true, 'data' => 'Thêm ticket thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($ID)
    {
        $sql = 'DELETE FROM ticket WHERE ID = ?';

        try{
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($ID));

            $count = $stmt->rowCount();
            if($count == 1){
                echo json_encode(array('status'=>true, 'data' => 'Xóa ticket thành công'));
            } else {
                die(json_encode(array('status'=>false, 'data'=> 'Mã không hợp lệ')));
            }
        } catch (PDOException $ex){
            die(json_encode(array('status'=>false, 'data'=>$ex -> getMessage())));
        }
    }

    public function update($ID, $SCH_ID, $BOO_ID, $SEAT_ID, $price)
    {
        $sql = 'UPDATE `ticket` SET `SCH_ID` = ?, `BOO_ID` = ?, `SEAT_ID` = ?, `price` = ? WHERE `ticket`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array( $SCH_ID, $BOO_ID, $SEAT_ID, $price,$ID));

            $count = $stmt->rowCount();
            if($count == 1){
                echo json_encode(array('status'=>true, 'data' => 'Cập nhật ticket thành công'));
            } else {
                die(json_encode(array('status'=>false, 'status'=>'Mã ticket không hợp lệ')));
            }
        } catch(PDOException $ex) {
            die(json_encode(array('status'=>false, 'data'=>$ex->getMessage())));
        }
    }
    public function getByID($ID)
    {
        $sql = "SELECT * FROM ticket where ID = '$ID'";
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
}
