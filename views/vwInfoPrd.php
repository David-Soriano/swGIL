<div class="container-fluid d-flex justify-content-center align-items-center flex-column">
    <?PHP 
    include "views/vwPrdPart.php";
    // echo urlPrd("views/vwPrdPart.php", "index.php?pg=9", "index.php?pg=1015");
    insertText("Algunos Productos Similares") ?>
    <?PHP require_once ("vwCarPrd.php")?>
    <?PHP require_once ("vwDesPrd.php")?>
</div>
<script src="../JS/script.js"></script>