<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();
//es para que no se puedan injectar SQL, ni se pueda accesar sin una sesion iniciada.
if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}

if (isset ($_POST['btnConfirmDeleteCategory'])) { //este nombre proviene del name del boton si,confirmar
    $idCategoria = $_POST['idCategoria_delete']; //este nombre proviene del name del input
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';

    $query = "DELETE FROM categorias WHERE idCategoria='$idCategoria'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $_SESSION['deleteCategorySuccess'] = "Se ha eliminado la categoría exitosamente " . $successIcon;
    } else {
        die ("Query falló " . mysqli_error($connection));
    }
    header("Location: /programDental/view/categoriesView.php");
    exit();
}
?>