<?php
    $client=true;
include_once("header.php");
include_once("main.php");

?>


    <h1 class="mt-5">Clients</h1>
    <?php
        $query="select * from client";
        $pdostm=$pdo->prepare( $query);
        $pdostm->execute();
        var_dump ($pdostm->fetchAll());

    ?>
    <table id="datatable" class="display">
    <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
        </tr>
       
    </tbody>
</table>
    </div>
</main>

<?php
    include_once("footer.php");
?>