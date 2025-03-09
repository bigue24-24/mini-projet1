<?php
$article = true;
include_once("header.php");
include_once("main.php");

$count = 0;
$list = [];

// Récupérer les articles
$query = "SELECT * FROM article";
$query = "SELECT * FROM article WHERE actif = 1";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();
$articles = $pdostmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des articles existent
$hasArticles = !empty($articles);
?>

<h1 class="mt-5">Articles</h1>

<a href="addarticle.php" class="btn btn-primary" style="float:right;margin-bottom:20px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
        <path d="M1 14s-1 0-1-1 1-4 6-4 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
    </svg>
</a>

<table id="datatable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Prix Unitaire</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $Ligne): 
            $count++;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($Ligne["idarticle"]); ?></td>
            <td><?php echo htmlspecialchars($Ligne["description"]); ?></td>
            <td><?php echo htmlspecialchars($Ligne["prix_unitaire"]); ?> €</td>
            <td>
                <a href="modifarticle.php?id=<?php echo $Ligne["idarticle"]; ?>" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                    </svg>
                </a>
                <button type="button" class="btn btn-danger delete-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteModal<?php echo $count; ?>"
                    <?php if (!$hasArticles) echo "disabled"; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg>
                </button>
            </td>
        </tr>

        <!-- Modal de suppression -->
        <div class="modal fade" id="deleteModal<?php echo $count; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer cet article ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <a href="delete.php?idarticle=<?php echo htmlspecialchars($Ligne["idarticle"]); ?>" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </tbody>
</table>

<!-- Activer suppression après ajout -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let deleteButtons = document.querySelectorAll(".delete-btn");
        if (deleteButtons.length > 0) {
            deleteButtons.forEach(button => button.removeAttribute("disabled"));
        }
    });
</script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
include_once("footer.php");
?>
