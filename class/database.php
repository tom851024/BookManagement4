<?php

class Database
{

    public $conn;

    function __construct()
    { //連線設定
        $serve = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "BookDb2";
    
        $conn = new Mysqli($serve, $username, $password, $dbname);
        if ($conn->connect_error) {
            die('connect error: ' . $conn->connect_error);
        }
        mysqli_query($conn,"SET CHARACTER SET UTF8");
        $this->conn = $conn;
    }



    public function my_select($start=0, $per=0, $order="", $sc="")
    { //拿取資料
        if (empty($start) && empty($per)) {
            if (empty($order) || empty($sc)) {
                $sqlSelect = "select * from BookList";
            }else {
                $sqlSelect = "select * from BookList order by " . $order . " " . $sc;
            }
        }else{
            if (empty($order) || empty($sc)) {
                $sqlSelect = "select * from BookList limit " . $start . ", " . $per;
            }else {
                $sqlSelect = "select * from BookList order by " . $order . " " . $sc . " limit " . $start . ", " . $per;
            }
        }
       
        $result = $this->conn->query($sqlSelect);
        return $result;
    }


    public function select($id)
    { //select出單筆資料
        $sqlSelect = "Select * from BookList where id='" . $id . "'";
        $result = $this->conn->query($sqlSelect);
        
        return $result;
    }


    public function comp_select($name)
    { //拿取出版社資料
        $sqlSelect = "Select * from Company where Name='" . $name . "'";
        $result = $this->conn->query($sqlSelect);

        return $result;
    }




    public function add($addArr)
    { //插入功能
        $key = implode(",", array_keys($addArr));
        foreach ($addArr as $k => $v) {
            $addArr[$k] = "'" . $v . "'";
        }
        $value = implode(",", $addArr);
        $sqlInsert = "Insert into BookList (". $key . ") values (". $value .")";
        $this->conn->query($sqlInsert);   
    }



    public function delete($id)
    { //刪除功能
        $sqlDel = "Delete from BookList where id='" . $id . "'";
        $this->conn->query($sqlDel);
    }


    public function update($editArr, $id)
    { //修改功能  
        $upArr = array();
        foreach ($editArr as $k => $v) {
            $str = $k . "='" . $v . "'";
            array_push($upArr, $str);
        }
        $up = implode(",", $upArr);
        $sqlUpdate = "Update BookList set " . $up . " where id='$id'";
        $this->conn->query($sqlUpdate);
    }



}
