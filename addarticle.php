<?php
ob_start(); // Commencer la mise en mémoire tampon de sortie
include_once("header.php");
include_once("main.php");

if (!empty($_POST["inputdesc"]) && !empty($_POST["inputpu"])) {
    $query = "INSERT INTO article(description, prix_unitaire) VALUES (:description, :pu)";
    $pdostmt = $pdo->prepare($query);
    // Utilisez les mêmes noms de paramètres dans le tableau passé à execute()
    $pdostmt->execute([
        ":description" => $_POST["inputdesc"],
        ":pu" => $_POST["inputpu"]
    ]);
    $pdostmt->closeCursor();
    header("Location:articles.php");
    exit(); // S'assurer qu'aucun autre code n'est exécuté après la redirection
}

ob_end_flush(); // Vider et désactiver la mise en mémoire tampon de sortie
?>

<h1 class="mt-5">Ajouters un articles</h1>

<form class="row g-3" method="POST">
    <div class="col-md-6">
        <label for="inputdesc">Description</label>
        <textarea class="form-control" placeholder="mettre la description" id="inputdesc" name="inputdesc" required></textarea>
    </div>
    <div class="col-md-6">
        <label for="inputpu" class="form-label">prix_unitaire</label>
        <input type="text" class="form-control" id="inputpu" name="inputpu" required>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>

</div>
</main>

<?php
include_once("footer.php");
?>
