<?php

if(isset($_GET["page"]) && isset($_GET["order"])){
    $addUrl = "Add.php?page=" . $_GET["page"] . "&order=" . $_GET["order"];
    $homeUrl = "index.php?page=" . $_GET["page"] . "&order=" . $_GET["order"];
}elseif(isset($_GET["page"])){
    $addUrl = "Add.php?page=" . $_GET["page"];
    $homeUrl = "index.php?page=" . $_GET["page"];
}elseif(isset($_GET["order"])){
    $addUrl = "Add.php?order=" . $_GET["order"];
    $homeUrl = "index.php?order=" . $_GET["order"];
}else{
    $addUrl = "Add.php";
    $homeUrl = "index.php";
}          

require_once("class/database.php");
include("xhtml/Add.html");


if (isset($_POST["Isbn"]) && isset($_POST["comp"]) && isset($_POST["book"]) && isset($_POST["aut"]) && isset($_POST["price"]) && isset($_POST["date"])) {
    if (preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{3}-[0-9]{1}$/', $_POST["Isbn"])) {
        if (preg_match('/^(0|[1-9][0-9]*)$/', $_POST["price"])) {
            if (preg_match("/^[0-9]{4}-(0([1-9]{1})|(1[0-2]{1}))-(([0-2]([0-9]{1}))|(3[0|1]))$/", $_POST["date"])) {

                if (strpos($_POST["aut"],',') !== false || strpos($_POST["book"],',') !== false || strpos($_POST["comp"],',') !== false) {
                    header('Location: Add.php?sign=1');
                }else {
                    $dataArr = array(
                        "ISBN"=>$_POST["Isbn"], 
                        "Comp"=>addslashes($_POST["comp"]), 
                        "Book"=>addslashes($_POST["book"]), 
                        "Author"=>addslashes($_POST["aut"]),
                        "Price"=>$_POST["price"],
                        "Date"=>$_POST["date"]);

                    $insert = new Database();
                    $insert->add($dataArr);

                   header("Location: " . $homeUrl);
                }

            }else {
                 header('Location: Add.php?date=1');
            }

        }else {
            header('Location: Add.php?price=1');
        }
    }else {
        header('Location: Add.php?isbn=1');
    }


}
