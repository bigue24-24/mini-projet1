<?php
ob_start(); // Commencer la mise en mémoire tampon de sortie
include_once("header.php");
include_once("main.php");

if (!empty($pdo) && !empty($_POST)) {
    // Correction de la requête SQL
    $query = "UPDATE article SET description=:desc, prix_unitaire=:pu WHERE idarticle=:id";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        "desc" => $_POST["inputdesc"],
        "pu" => $_POST["inputpu"],
        "id" => $_POST["myid"]
    ]);

    // Redirection après la modification
    header("Location: articles.php");
    exit();
}

// Vérifier si un ID est passé en GET
if (empty($_GET["id"])) { 
    echo "<p class='alert alert-danger'>Aucun article sélectionné.</p>"; 
    exit(); 
}

// Récupération des informations de l'article
$query = "SELECT * FROM article WHERE idarticle=:id";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute(["id" => $_GET["id"]]);
$row = $pdostmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "<p class='alert alert-danger'>Article non trouvé.</p>";
    exit();
}

ob_end_flush(); // Vider et désactiver la mise en mémoire tampon de sortie
?>

<h1 class="mt-5">Modifier un articles</h1>

<form class="row g-3" method="POST">
    <input type="hidden" name="myid" value="<?php echo htmlspecialchars($row["idarticle"]); ?>"/>

    <div class="col-md-6">
        <label for="inputdesc">Description</label>
        <textarea class="form-control" placeholder="mettre la description" id="inputdesc" name="inputdesc" required>
            <?php echo htmlspecialchars($row["description"]); ?>
        </textarea>
    </div>

    <div class="col-md-6">
        <label for="inputpu" class="form-label">PU</label>
        <input type="text" class="form-control" id="inputpu" name="inputpu" 
            value="<?php echo htmlspecialchars($row["prix_unitaire"]); ?>" required>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Modifier</button>
    </div>
</form>

</div>
</main>

<?php include_once("footer.php"); ?>
