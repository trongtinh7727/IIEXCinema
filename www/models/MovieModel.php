<?php
class MovieModel
{
    public $db;
    public function getAll()
    {
        $sql = "Select * From MOVIE";
        $stmt = $this->db->prepare($sql)->execute();
        return $stmt;
    }
    public function getMovie($ID)
    {
        $sql = "Select * From MOVIE Where ID = '{$ID}'";
        $stmt = $this->db->prepare($sql)->execute();
        return $stmt;
    }
    public function getMoviebyDate()
    {   $now =  date("Y-m-d");
        $sql = "Select * From MOVIE Where DATE = '{$now}'";
        $stmt = $this->db->prepare($sql)->execute();
        return $stmt;
    }
    public function getMoviebyCatory($catory)
    {
        $sql = "Select * From MOVIE Where CATEGORY = '{$catory}'";
        $stmt = $this->db->prepare($sql)->execute();
        return $stmt;
    }
    public function FunctionName($rate)
    {
        $sql = "Select * From MOVIE Where RATE = '{$rate}'";
        $stmt = $this->db->prepare($sql)->execute();
        return $stmt;
    }
}
?>