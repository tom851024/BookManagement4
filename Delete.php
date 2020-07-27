<?php
require_once("class/database.php");

$del = new Database();
if (isset($_GET["id"]) && preg_match("/^[0-9]+$/", $_GET["id"])) {
    $del->delete($_GET["id"]);
    if (!is_null($_GET["order"]) && !empty($_GET["page"])) {
        header('Location: index.php?page='.$_GET["page"].'&order='.$_GET["order"]);
    }elseif(!empty($_GET["order"])) {
        header('Location: index.php?order='.$_GET["order"]);
    }elseif(!empty($_GET["page"])) {
        header('Location: index.php?page='.$_GET["page"]);
    }else {
        header('Location: index.php'); 
    }
}else {
    echo "沒有ID被讀入";
}



