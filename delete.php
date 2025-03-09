<?php
include_once("main.php");

if(!empty($_GET["id"])){
    $query="delete from client where idclient=:id";
    $objstmt=$pdo->prepare($query);
    $objstmt->execute(["id"=>$_GET["id"]]);
    $objstmt->closeCursor();
    header("Location:clients.php");
    
}


if(!empty($_GET["idarticle"])){
    $query="delete from article where idarticle=:id";
    $objstmt=$pdo->prepare($query);
    $objstmt->execute(["id"=>$_GET["idarticle"]]);
    $objstmt->closeCursor();
    header("Location:articles.php");
    
}

?>