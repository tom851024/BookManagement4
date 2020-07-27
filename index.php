<?php
require_once("class/database.php");


$db = new Database();


$r1 = $db->my_select();
$dataNum = mysqli_num_rows($r1); //獲取全部筆數
$per = 16; //每頁要顯示的筆數
$pages = ceil($dataNum/$per); //全部頁數
$pageBoo = 1;
if (!isset($_GET["page"])) {
    $page = 1;
}elseif(!preg_match("/^[0-9]*$/", $_GET["page"])) {
    $page = 1;
    //$pageBoo = 0;
}elseif( $_GET["page"] <= 0) {
    $page = 1;
}elseif($_GET["page"] > $pages) {
    $page = $pages;
}else {
     $page = $_GET["page"];
 }
$start = ($page-1) * $per; //每頁最開始資料

if (isset($_GET["order"])) { //排序
   if($_GET["order"] == ""){
    $result = $db->my_select($start, $per);
   }else {
       $orderArr = explode('-', $_GET["order"]);
       if(isset($orderArr[0]) && isset($orderArr[1])){
            $result = $db->my_select($start, $per, $orderArr[0], $orderArr[1]);
       }else{
            $result = $db->my_select($start, $per);
       }
           
   }

    $firstPageUrl = "index.php?page=1&order=" . $_GET["order"];
    $lastPageUrl = "index.php?page=" . ($page-1) . "&order=" . $_GET["order"];
    $nextPageUrl = "index.php?page=" . ($page+1) . "&order=" . $_GET["order"];
    $finalPageUrl = "index.php?page=" . $pages . "&order=" . $_GET["order"];
    $outputUrl = "Output.php?page=" . $page . "&order=" . $_GET["order"];

    
}else {
    $result = $db->my_select($start, $per);
    $firstPageUrl = "index.php?page=1";
    $lastPageUrl = "index.php?page=" . ($page-1);
    $nextPageUrl = "index.php?page=" . ($page+1);
    $finalPageUrl = "index.php?page=" . $pages;
    $outputUrl = "Output.php?page=" . $page;
}

if (isset($_GET["order"]) && isset($_GET["page"])) {
    $inUrl = "Add.php?order=" . $_GET["order"] . "&page=" . $_GET["page"];
}elseif(isset($_GET["page"])) {
    $inUrl = "Add.php?page=" . $_GET["page"];
}elseif(isset($_GET["order"])) {
    $inUrl = "Add.php?order=" . $_GET["order"];
}else {
    $inUrl = "Add.php";
}

include("xhtml/index.html");
