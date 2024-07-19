<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();
//es para que no se puedan injectar SQL, ni se pueda accesar sin una sesion iniciada.
if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}

unset($_SESSION['addCategoryNameError']);
unset($_SESSION['addCategorySuccess']);

/**nombre de boton de agregar categoria en form es btnAddCategory */
if (isset ($_POST['btnAddCategory'])) {
    $nombreCategoria = $_POST['nombreCategoria'];
    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';

    $query = "SELECT * FROM categorias WHERE nombreCategoria = '$nombreCategoria'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // If category exists, display an error message
        $_SESSION['addCategoryNameError'] = $errorIcon . "El nombre de categoría ya existe, intente con otro nombre";
    } else {
        // Insert the category if it doesn't already exist
        $query = "INSERT INTO categorias (nombreCategoria) VALUES ('$nombreCategoria')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $_SESSION['addCategorySuccess'] = "Se ha agregado la categoría exitosamente " . $successIcon;
        } else {
            die ("Query falló " . mysqli_error($connection));
        }
    }
    header("Location: /programDental/view/categoriesView.php");
    exit();

}
?>