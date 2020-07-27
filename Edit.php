<?php
require_once("class/database.php");

$edit = new Database();
if (isset($_GET["order"]) && isset($_GET["page"])) {
    $postUrl = "Edit.php?order=" . $_GET["order"] . "&page=" . $_GET["page"];
    $homeUrl = "index.php?page=" . $_GET["page"] . "&order=" . $_GET["order"];
}elseif(isset($_GET["order"])) {
    $postUrl = "Edit.php?order=" . $_GET["order"];
    $homeUrl = "index.php?order=" . $_GET["order"];
}elseif(isset($_GET["page"])) {
    $postUrl = "Edit.php?page=" . $_GET["page"];
    $homeUrl = "index.php?page=" . $_GET["page"]; 
}else {
    $postUrl = "Edit.php";
    $homeUrl = "index.php";
}

if (isset($_POST["comp"]) && isset($_POST["book"]) && isset($_POST["aut"]) && isset($_POST["price"]) && isset($_POST["date"]) && $_POST["id"]) { //更新資料

    if (preg_match('/^(0|[1-9][0-9]*)$/', $_POST["price"])) {
        if (preg_match("/^[0-9]{4}-(0([1-9]{1})|(1[0-2]{1}))-(([0-2]([0-9]{1}))|(3[0|1]))$/", $_POST["date"])) {
            if (strpos($_POST["aut"],',') !== false || strpos($_POST["book"],',') !== false || strpos($_POST["comp"],',') !== false) { //資料中有逗號輸入
                header("Location: " . $postUrl . "&sign=1&id=" . $_POST["id"]);
            }else {
                $editArr = array(
                    "Comp"=>addslashes($_POST["comp"]), 
                    "Book"=>addslashes($_POST["book"]),
                    "Author"=>addslashes($_POST["aut"]), 
                    "Price"=>$_POST["price"], 
                    "Date"=>$_POST["date"]);

                $edit->update($editArr,  $_POST["id"]);
                header("Location: " . $homeUrl);
            }
        }else { //日期格式錯誤
           header("Location: " . $postUrl . "&date=1&id=" . $_POST["id"]);
            
        }
    }else { //價格格式錯誤
        header("Location: " . $postUrl . "&price=1&id=" . $_POST["id"]);
    }
}else {
    if(isset($_GET["id"]) && preg_match("/^[0-9]+$/", $_GET["id"])){
        $result = $edit->select($_GET["id"]);
 
        $res = $result->fetch_row();
        $isbn = $res[1];
        $comp = $res[2];
        $book = $res[3];
        $aut = $res[4];
        $price = $res[5];
        $date = $res[6];

        //將雙引號替換 編輯顯示才不會有問題
        $comp = str_replace("\"", "&quot;", $comp);
        $aut = str_replace("\"", "&quot;", $aut);
        $book = str_replace("\"", "&quot;", $book);

        include("xhtml/Edit.html");
    }else{
        echo "沒有ID讀入";
    }
    
    
}
