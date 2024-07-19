<?php
/*session es una variable super global que puede ser accedida por cualquier otra pagina.
se debe poner en cualquier otra pag que usara session
la idea es poner el user id en session, y revisar en cualquier pagina que este alli*/
session_start();
$_SESSION;
include (__DIR__ . "/../model/connectiondb.php");
include (__DIR__ . "/../controller/validateSession.php");

//si agrego archivos como logout se cierra sesion sin validar
$loggedUser = checkLogin($connection); //conexion con db, en cada pag que revise conexion login, se pone estas lineas.

// Start output buffering
ob_start();

// Initialize the list array if it's not set
if (!isset($_SESSION['productList'])) {
    $_SESSION['productList'] = [];
}

// Delete product from the list
if (isset($_GET['deleteProductId'])) {
    $productId = $_GET['deleteProductId'];

    foreach ($_SESSION['productList'] as $key => $product) {
        if ($product['idProducto'] == $productId) {
            unset($_SESSION['productList'][$key]);
            break;
        }
    }
    header('Location: productsListsView.php');
    exit(); // Make sure to exit after header redirect
}
//Agregar
if (isset($_GET['nombreProductoFiltro']) && isset($_GET['quantityProduct'])) {
    $productId = $_GET['nombreProductoFiltro'];
    $quantityProduct = $_GET['quantityProduct'];

    // Retrieve product details
    $queryProduct = "SELECT * FROM inventario WHERE idProducto = $productId";
    $result = mysqli_query($connection, $queryProduct);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        $queryCategory = "SELECT nombreCategoria FROM categorias WHERE idCategoria = {$product['idCategoria']}";
        $resultCategory = mysqli_query($connection, $queryCategory);
        $category = mysqli_fetch_assoc($resultCategory);

        $queryProduct = "SELECT nombreProducto FROM inventario WHERE idProducto = {$product['idProducto']}";
        $resultProduct = mysqli_query($connection, $queryProduct);
        $productAdded = mysqli_fetch_assoc($resultProduct);

        $detalle = [
            'idProducto' => $product['idProducto'],
            'productoDetallePedido' => $productAdded['nombreProducto'],
            'categoriaProductoPedido' => $category['nombreCategoria'],
            'cantidadProductoPedido' => $quantityProduct
        ];

        $_SESSION['productList'][] = $detalle;
    }
    header('Location: productsListsView.php');
    exit(); // Make sure to exit after header redirect
}

// Flush the output buffer
ob_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--bootstrap-->

    <meta charset="UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="styleProductsLists.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/jpg" href="../img/logoFavicon.jpg">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>Crear Lista de Compras - DentoSalud</title>
    <script src="https://kit.fontawesome.com/cf7c5789c0.js" crossorigin="anonymous"></script>

</head>

<body>

    <div class="wrapper">

        <!--###########################################################################################################################################################################################################################################################################################-->
        <div class="sidebarNav" id="sideParent">
            <nav class="titulo">
                <div class="favicon-container">
                    <a href="homepage.php"><img src="../img/logoFavicon.jpg" class="favicon">
                </div>
                <div class="tituloLogo">DentoSalud
                </div>
            </nav>


            <ul>

                <li><a href="homepage.php"><i class="fa-sharp fa-solid fa-house" style="color: #F2F3F4;"></i>Inicio</a>
                </li>
                <li><a href="usersView.php"><i class="fa-solid fa-users" style="color: #F2F3F4;"></i>Usuarios</a></li>
                <li><a href="inventoryView.php"><i class="fa-solid fa-boxes-stacked"
                            style="color: #F2F3F4;"></i>Inventario</a></li>
                <li><a href="categoriesView.php"><i class="fa-solid fa-layer-group"
                            style="color: #F2F3F4;"></i>Categorías</a></li>
                <li><a href="#" class="btnShowPedidos"><i class="fa-solid fa-cart-shopping" style="color: #F2F3F4;"></i>
                        Lista de Compras <span class="fas fa-angle-right" style="color: #F2F3F4;"></span></a></li>
                <ul class="showPedidos">
                    <li><a href="productsListsView.php"><i class="fa-solid fa-circle-plus"
                                style="color: #181818;"></i>Crear lista para un
                            pedido</a>
                    </li>
                    <li><a href="processProductsListsView.php"><i class="fa-solid fa-spinner"
                                style="color: #181818;"></i>Pedidos en
                            proceso</a>
                    </li>
                    <li><a href="historyProductsListsView.php"><i class="fa-solid fa-clock-rotate-left"
                                style="color: #181818;"></i>Historial
                            de
                            pedidos</a></li>
                </ul>

            </ul>
            <!--<p style="color: #a1bed12b; margin-left: 15px; font-size: 14px;">
                Creado por: Rachel Ariana Montero Branford
            </p>-->
        </div>
        <!--###########################################################################################################################################################################################################################################################################################-->
        <div class="mainHomepageContent">

            <div class="headerHomepage">
                <nav>
                    <div class="loggedUser">
                        <?php echo "Bienvenido, " . $loggedUser['nombreCompleto'] . "!"; ?>
                    </div>
                    <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"
                            style="color: #181818;"></i>Salir</a>
                </nav>
            </div>
            <!--######################################################################################################################################################-->
            <div class="info">
                <div class="tituloCrearLista">
                    Crear lista para un Pedido
                </div>

                <div class="funcionAgregar">


                    <div>
                        <!--FILTRO 1 POR CATEGORIA DE PRODUCTOS-->
                        <form action="" method="GET" class="filterMain">
                            <div class="filterDiv">
                                <div style="display: flex; ">

                                    <select class="form-control custom-select" name="nombreCategoriaFiltro"
                                        id="nombreCategoriaFiltro" required
                                        style="color: #737678; width: 35%; height: 35px;">
                                        <option value="" <?php if (!isset($_GET['nombreCategoriaFiltro']))
                                            echo 'selected'; ?>>
                                            Seleccionar categoría...</option>
                                        <?php
                                        $query = "SELECT * FROM categorias";
                                        $result = mysqli_query($connection, $query);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $selected = (isset($_GET['nombreCategoriaFiltro']) && $_GET['nombreCategoriaFiltro'] == $row['idCategoria']) ? 'selected' : '';
                                                echo '<option value="' . $row['idCategoria'] . '" ' . $selected . '>' . $row['nombreCategoria'] . '</option>';
                                            }
                                        } else {
                                            echo "Query falló al obtener categorías " . mysqli_error($connection);
                                        }
                                        ?>
                                    </select>

                                    <button type="submit" name="btnSubmitFilter" class="btnSubmitFilter"
                                        id="btnSubmitFilter">Buscar</button>
                                </div>
                            </div>
                        </form>
                        <!--FILTRO 2 POR PRODUCTOS-->
                        <form action="" method="GET" class="filterMain">
                            <div class="filterDiv">

                                <div style="display: flex; margin-bottom: -20px;">
                                    <select class="form-control custom-select" name="nombreProductoFiltro"
                                        id="nombreProductoFiltro" required
                                        style="color: #737678;  width: 86%; height: 35px;">
                                        <option value="" <?php if (!isset($_GET['nombreProductoFiltro']))
                                            echo 'selected'; ?>>
                                            Seleccionar producto...</option>
                                        <?php
                                        //indica que si esta el nombredecategoria, realice un query en donde el producto corresponda con la categoria elegida
                                        if (isset($_GET['nombreCategoriaFiltro'])) {
                                            $categoriaSeleccionada = $_GET['nombreCategoriaFiltro'];
                                            $query = "SELECT * FROM inventario WHERE idCategoria = $categoriaSeleccionada";
                                            $result = mysqli_query($connection, $query);
                                            $firstProductShown = false; // Variable para controlar si el primer producto ha sido mostrado
                                        
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $selectedProduct = '';
                                                    if (!$firstProductShown) {
                                                        $selectedProduct = 'selected';
                                                        $firstProductShown = true; // Establecer la variable a true después de mostrar el primer producto
                                                    }

                                                    echo '<option value="' . $row['idProducto'] . '" ' . $selectedProduct . '>' . $row['nombreProducto'] . '</option>';
                                                    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';
                                                    $_SESSION['filterCategoryCreateListsSuccess'] = "Se han encontrado productos con esta categoría " . $successIcon;
                                                }
                                            } else {
                                                $errorIcon = '<i class="fa-solid fa-circle-exclamation" style="color: #dc3545;"></i>';
                                                $_SESSION['filterCategoryCreateListsError'] = $errorIcon . "No se han encontrado productos con esta categoría ";
                                            }
                                        } else {
                                            echo "Query falló al obtener productos " . mysqli_error($connection);
                                        }
                                        ?>
                                    </select>

                                    <input type="number" min="1" name="quantityProduct" id="quantityProduct"
                                        placeholder="Cantidad"
                                        style="margin-left: 10px; width: 25%; height: 47px; outline: none; border: 1px solid #dfe2e6; border-radius: 6px; padding-left: 15px;"
                                        required>
                                    <button type="submit" name="btnAddProductList" class="btnSubmitFilter"
                                        id="btnAddProductList" style="width: 40%; height: 24px;">Agregar
                                        Producto</button>
                                    <!--<button type="button" class="btnLimpiar"
                                        onclick="window.location.href='productsListsView.php'"
                                        style="width:auto; height: 24px;">Limpiar</button>-->
                                </div>
                            </div>
                        </form>
                    </div>



                </div>

                <div class="containerTable">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Nombre de Producto</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($_SESSION['productList'] as $product) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $product['productoDetallePedido']; ?>
                                    </td>
                                    <td>
                                        <?php echo $product['categoriaProductoPedido']; ?>
                                    </td>
                                    <td>
                                        <?php echo $product['cantidadProductoPedido']; ?>
                                    </td>
                                    <td>
                                        <a href="?deleteProductId=<?php echo $product['idProducto']; ?>"
                                            class="btn btn-danger">Eliminar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!--BOTON PARA CREARLO A UNA LISTA-->
                <div class="createLists" style="">
                    <form action="../controller/crudProductsLists/createList.php" method="POST"
                        style="width: 60%; display: flex;">
                        <textarea name="descriptionListCreation" id="descriptionListCreation"
                            placeholder="Ingrese la descripción de la lista" class="form-control"
                            style="width: 90%; height: 85px; resize: vertical;" required></textarea>

                        <input type="hidden" name="productList" id="productList"
                            value='<?php echo json_encode($_SESSION['productList']); ?>'>

                        <button class="btnCrearLista" name="btnCrearLista" id="btnCrearLista"
                            style="width: 10%; height: 35px; margin-left: 23px; margin-top: 39px;">Crear Lista</button>
                    </form>
                </div>

                <!--validaciones de error o de exito de SQL-->
                <?php


                /************************************************************VALIDACIONES FILTROS***************************************************************************/
                //validacion de EXITO
                if (isset($_SESSION['filterCategoryCreateListsSuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['filterCategoryCreateListsSuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['filterCategoryCreateListsSuccess']);
                }

                //validacion de EXITO
                if (isset($_SESSION['addListSuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['addListSuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addListSuccess']);
                }


                //validacion de ERROR porque no se encontraron productos con el filtro de categoria seleccionado
                if (isset($_SESSION['filterCategoryCreateListsError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['filterCategoryCreateListsError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['filterCategoryCreateListsError']);
                }

                //validacion de ERROR 
                if (isset($_SESSION['addListError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['addListError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addListError']);
                }

                ?>

            </div>

            <!--######################################################################################################################################################-->
            <!--script para eliminar producto-->

            <script>

            </script>

        </div>
        <!--######################################################################################################################################################-->
        <!-- Modal popup de crear producto en inventario -->
        <form class="row g-3 needs-validation" action="" method="POST" novalidate>
            <div class="modal fade" id="" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="examplemodalCreateList" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Crear La Lista De Productos</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form para agregar una categoria -->
                            <div class="formCreateList">
                                <input type="hidden" name="idProducto_delete" id="idProducto_delete">
                            </div>
                            <div class="formCreateList"
                                style="display: flex; justify-content: center; align-items: center;">
                                <i style="color: #dc3545; margin-right: 50px; margin-bottom: 10px;"></i>
                            </div>
                            <div class="formCreateList">
                                <label for="">Descripción de la Lista</label>
                                <input type="text" name="descriptionListCreation" id="descriptionListCreation"
                                    placeholder="Ingrese la descripción" class="form-control"
                                    style="width: 95%; height: 85px;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    La descripción de es requerida
                                </div>
                            </div>
                            <div class="disclaimer"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" name="btnConfirmCreateList" value="Confirmar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--######################################################################################################################################################-->

        <!-- Funcion para hacer toggle listaCompras -->
        <script type="text/javascript">
            $(document).ready(function () {
                $('.btnShowPedidos').click(function () {
                    /*uso closest() para encontrar .sidebarNav más cercano y luego buscar dentro elemento .showPedidos */
                    $(this).closest('.sidebarNav').find('.showPedidos').slideToggle();
                    $(this).closest('.sidebarNav').find('span').toggleClass('rotate');
                });
            });
        </script>


        <!--######################################################################################################################################################-->
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (() => {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                const forms = document.querySelectorAll('.needs-validation')

                // Loop over them and prevent submission
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        </script>
        <!--############################################################################################################################################-->

        <!-- MODAL PARA ELIMINAR PRODUCTO INVENTARIO-->
        <form class="row" action="../controller/crudInventory/deleteInventory.php" method="POST">


        </form>

        <!--################################################################################################################################################-->



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
</body>



</html>