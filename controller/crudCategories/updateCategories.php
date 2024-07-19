<?php

include (__DIR__ . "/../../model/connectiondb.php");

session_start();
//es para que no se puedan injectar SQL, ni se pueda accesar sin una sesion iniciada.
if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}


/**nombre de boton guardarcambios es btneditCategory que postea en form modal edit category */
if (isset ($_POST['btnSaveEditCategory'])) {

    $idCategoria = $_POST['idCategoria'];
    $nombreCategoria = $_POST['nombreCategoria'];
    /* $editCategorySuccess = "";
     $addCategoryNameError = ""; */
    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';

    // Check if the new category name already exists
    $query = "SELECT * FROM categorias WHERE nombreCategoria = '$nombreCategoria' AND idCategoria != '$idCategoria'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // If category exists, display an error message
        $_SESSION['editCategoryNameError'] = $errorIcon . "El nombre de categoría ya existe, intente con otro nombre";
    } else {
        // Update the category if it doesn't already exist
        $queryUpdate = "UPDATE categorias SET nombreCategoria = '$nombreCategoria' WHERE idCategoria = '$idCategoria'";
        $resultUpdate = mysqli_query($connection, $queryUpdate);

        if ($resultUpdate) {
            $_SESSION['editCategorySuccess'] = "Se ha editado la categoría exitosamente " . $successIcon;
        } else {
            die ("Query falló " . mysqli_error($connection));
        }

    }
    header("Location: /programDental/view/categoriesView.php");
    exit();

}



?>