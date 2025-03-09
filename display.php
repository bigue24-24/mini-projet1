<?php
include_once("config.php");

if (isset($_GET["idarticle"])) {
    $id = intval($_GET["idarticle"]);
    $query = "UPDATE article SET actif = 0 WHERE idarticle = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["id" => $id]);

    header("Location: articles.php");
    exit();
}
?>
