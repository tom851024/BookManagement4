<?php
require_once("class/database.php");


//設定系統環境
set_time_limit(0);
ini_set('memory_limit', '256M');

//匯出陣列
$csv_arr = array();
$csv_arr[] = array('ISBN', '出版社', '書名', '作者', '定價', '發行日');


if (isset($_POST["outSelect"])) {
    $db = new Database();

    if ($_POST["outSelect"] == ""){
        if (isset($_GET["order"]) && isset($_GET["page"])) {
            header('Location: index.php?page=' . $_GET["page"].'&order='.$_GET["order"]);
        }elseif(isset($_GET["order"])) {
            header('Location: index.php?order=' . $_GET["order"]);
        }elseif(isset($_GET["page"])) {
            header('Location: index.php?page=' . $_GET["page"]);
        }else {
            header('Location: index.php'); 
        }
        exit;
    }elseif($_POST["outSelect"] == 0) { //匯出全部
        if (isset($_GET["order"])) {
            if ($_GET["order"] == ""){ //排序
                $result = $db->my_select();
            }else {
                $orderArr = explode('-', $_GET["order"]);
                $result = $db->my_select(0, 0, $orderArr[0], $orderArr[1]);
            }
           
        }else {
            $result = $db->my_select();
        }

    }elseif($_POST["outSelect"] == 1 && isset($_GET["page"])) { //匯出本頁項目
        $per = 16;
        $page = $_GET["page"];
        $start = ($page-1) * $per;
        if (isset($_GET["order"])) {
            if ($_GET["order"] == ""){ //排序
                $result = $db->my_select($start, $per);
            }else {
                $orderArr = explode('-', $_GET["order"]);
                $result = $db->my_select($start, $per, $orderArr[0], $orderArr[1]);
            }
            
        }else {
            $result = $db->my_select($start, $per);
        }

    }elseif($_POST["outSelect"] == 2 && isset($_POST["dataSub"])) { //匯出選取項目
        $arr = explode(",", $_POST["dataSub"][0]);
        $result = array();
        if (!empty($arr[0])) {
            for ($i = 0; $i < count($arr); $i++) {
                $select = $db->select($arr[$i]);
                $sel = $select->fetch_row();
                
                array_push($result, array(
                    "ISBN" => $sel[1],
                    "Comp" => $sel[2],
                    "Book" => $sel[3],
                    "Author" => $sel[4],
                    "Price" => $sel[5],
                    "Date" => $sel[6]
                ));
                
            }
        }
       
    }

    foreach ($result as $res) {
        array_push($csv_arr, array($res["ISBN"], $res["Comp"], $res["Book"], $res["Author"], $res["Price"], $res["Date"]));
    }
    
    date_default_timezone_set('Asia/Taipei'); //設定時區
    $filename = date("Y-m-d-H-i-s") . ".csv"; //檔案名稱
    header('Pragma: no-cache');
    header('Expires: 0');
    header('Content-Disposition: attachment;filename="' . $filename . '";');
    header('Content-Type: application/csv; charset=UTF-8');

    for ($i = 0; $i < count($csv_arr); $i++) {
        if ($i == 0) {
            echo "\xEF\xBB\xBF";
            //輸出避免Excel讀取時亂碼
        }
        echo join(',', $csv_arr[$i]) . PHP_EOL;
    }



}


exit;
