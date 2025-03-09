<?php
// Démarre le tampon de sortie pour éviter l'erreur de redirection
ob_start();

$clients = true;
include_once("header.php");
include_once("main.php");

// Vérifier si PDO est défini
if (!isset($pdo)) {
    die("Erreur de connexion à la base de données.");
}

try {
    if (!empty($pdo) && !empty($_POST)) {
        // Préparer la requête de mise à jour des informations du client
        $query = "UPDATE client SET nom=:nom, ville=:ville, telephone=:telephone WHERE idclient=:id";
        $pdostmt = $pdo->prepare($query);
        $pdostmt->execute([
            "nom" => $_POST["inputnom"],
            "ville" => $_POST["inputville"],
            "telephone" => $_POST["inputtelephone"],
            "id" => $_POST["myid"]
        ]);

        // Rediriger après la mise à jour
        header("Location: clients.php");  // Redirection vers la page des clients
        exit(); // S'assurer que le script s'arrête après la redirection
    }
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}

// Vérifier si un ID est passé en GET
if (empty($_GET["id"])) {
    echo "<p class='alert alert-danger'>Aucun client sélectionné.</p>";
    exit();
}

// Récupération des informations du client
$query = "SELECT * FROM client WHERE idclient=:id";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute(["id" => $_GET["id"]]);

$row = $pdostmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "<p class='alert alert-danger'>Client non trouvé.</p>";
    exit();
}
?>

<h1 class="mt-5">ModifClient</h1>
<form class="row g-3" method="POST">
    <input type="hidden" name="myid" value="<?php echo htmlspecialchars($row["idclient"]) ?>">

    <div class="col-md-6">
        <label for="inputnom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="inputnom" name="inputnom" value="<?php echo htmlspecialchars($row["nom"]) ?>" required>
    </div>

    <div class="col-md-6">
        <label for="inputville" class="form-label">Ville</label>
        <input type="text" class="form-control" id="inputville" name="inputville" value="<?php echo htmlspecialchars($row["ville"]) ?>" required>
    </div>

    <div class="col-12">
        <label for="inputtelephone" class="form-label">Téléphone</label>
        <input type="tel" class="form-control" id="inputtelephone" name="inputtelephone" value="<?php echo htmlspecialchars($row["telephone"]) ?>" required>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Modifier</button>
    </div>
</form>

<?php
// Libérer les ressources
$pdostmt->closeCursor();
include_once("footer.php");

// Envoie la sortie tamponnée au navigateur à la fin du script
ob_end_flush();
if (!empty($pdo) && !empty($_POST)) {
    // Préparer la requête de mise à jour des informations du client
    $query = "UPDATE client SET nom=:nom, ville=:ville, telephone=:telephone WHERE idclient=:id";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        "nom" => $_POST["inputnom"],
        "ville" => $_POST["inputville"],
        "telephone" => $_POST["inputtelephone"],
        "id" => $_POST["myid"]
    ]);
}


?>
<?php
include_once("footer.php");
?>

