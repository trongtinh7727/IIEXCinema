<?php
class MovieModel
{
    public $db;
    public function getAll()
    {
        $sql = 'SELECT * FROM Movie';
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

    public function ongoing()
    {
        $sql = 'CALL `ongoing_movies`()';
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
    public function upcoming()
    {
        $sql = 'CALL `upcoming_movies`()';
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
    public function gettrailer()
    {
        $sql = 'CALL `get_trailers`()';
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

    public function add($TITLE, $GENRE, $DURATION, $RATING, $STORY, $POSTER)
    {
        $sql = 'INSERT INTO `movie` (`TITLE`, `GENRE`, `DURATION`, `RATING`, `STORY`, `POSTER`) VALUES(?,?,?,?,?,?)';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($TITLE, $GENRE, $DURATION, $RATING, $STORY, $POSTER));

            return json_encode(array('status' => true, 'data' => 'Thêm phim thành công'));
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function delete($id)
    {

        $sql = 'DELETE FROM Movie where id = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($id));

            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Xóa phim thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Mã phim không hợp lệ')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }

    public function update($NAME, $INFO, $DATE, $START, $END, $CATEGORY, $RATING, $IMAGE, $ID)
    {
        $sql = 'UPDATE `movie` SET `NAME` = ?, `INFO` = ?, `DATE` = ?,
                `START` = ?, `END` = ?, `CATEGORY` = ?, `RATING` = ? ,`IMAGE`= ? WHERE `movie`.`ID` = ?';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($NAME, $INFO, $DATE, $START, $END, $CATEGORY, $RATING, $IMAGE, $ID));
            $count = $stmt->rowCount();

            if ($count == 1) {
                echo json_encode(array('status' => true, 'data' => 'Cập nhật phim thành công'));
            } else {
                die(json_encode(array('status' => false, 'data' => 'Không có phim nào được cập nhật')));
            }
        } catch (PDOException $ex) {
            die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
    }
    public function getByID($ID)
    {
        $sql = "SELECT * FROM movie where ID = '$ID'";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $ex) {
            return(json_encode(array('status' => false, 'data' => $ex->getMessage())));
        }
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return json_encode(array('status' => true, 'data' => $data));
    }
}
