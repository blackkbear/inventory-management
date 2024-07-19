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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--bootstrap-->

    <meta charset="UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="styleInventoryHomepage.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/jpg" href="../img/logoFavicon.jpg">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>Gestionar Inventario - DentoSalud</title>
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
                <div class="tituloGestionarInventario">
                    Gestionar Inventario
                </div>

                <div class="funcionAgregar">
                    <!--aqui en p iria el filter by-->
                    <form action="" method="GET">
                        <div class="filterMain">
                            <div class="filterDiv">
                                <div class="funcionAgregar" style="margin-right: 850px; ">
                                    <!-- <h6 style="margin-top: 15px; margin-right: 15px;">Filtrar por Categoría</h6>-->
                                    <select class="form-control custom-select" name="nombreCategoriaFiltro"
                                        id="nombreCategoriaFiltro" required style="color: #737678;">
                                        <option value="" disabled selected>Seleccionar categoría para filtrar...
                                        </option>
                                        <?php
                                        $query = "SELECT * FROM categorias";
                                        $result = mysqli_query($connection, $query);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['idCategoria'] . '">' . $row['nombreCategoria'] . '</option>';
                                            }
                                        } else {
                                            echo "Query falló al obtener categorías " . mysqli_error($connection);
                                        }
                                        ?>
                                    </select>

                                    <button type="submit" name="btnSubmitFilter" class="btnSubmitFilter"
                                        id="btnSubmitFilter">Buscar</button>

                                    <button type="button" class="btnLimpiar"
                                        onclick="window.location.href='inventoryView.php'">Limpiar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div>

                        <!-- btnAgregarCategoria al hacer click se abre modal pop up para agregar uno, se pone el databstarget id de modal que desea abrir-->
                        <button class="btnAgregarInventario" data-bs-toggle="modal"
                            data-bs-target="#modalCreateInventory">Agregar
                            Producto</button>

                    </div>

                </div>

                <div class="containerTable">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre de Producto</th>
                                <th>Cantidad</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* se llama funcion de leer categorías en tabla*/
                            require (__DIR__ . "/../controller/crudInventory/readInventory.php");
                            ?>


                        </tbody>
                    </table>
                </div>

                <!--validaciones de error o de exito de SQL-->
                <?php

                //validacion de ERROR cuando se crea producto porque cantidad no es numerico
                
                //validacion de ERROR cuando se crea inventario producto porque producto con ese nombre ya existe
                if (isset($_SESSION['addInventoryNameError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['addInventoryNameError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addInventoryNameError']);
                }

                if (isset($_SESSION['addInventoryCantidadError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['addInventoryCantidadError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addInventoryCantidadError']);
                }

                // validacion de ERROR cuando la cantidad es 0 cuando se intenta crear producto
                if (isset($_SESSION['addInventoryCantidad0Error'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['addInventoryCantidad0Error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addInventoryCantidad0Error']);
                }


                // validacion de EXITO cuando se crea bien producto
                if (isset($_SESSION['addInventorySuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['addInventorySuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addInventorySuccess']);
                }


                //validacion de ERROR cuando se EDITA inventario nommbre porque ya existe
                if (isset($_SESSION['editInventoryNameError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['editInventoryNameError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['editInventoryNameError']);
                }

                //validacion de ERROR cuando se EDITA inventario porque cantidad no es numerico
                if (isset($_SESSION['editInventoryCantidadError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['editInventoryCantidadError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['editInventoryCantidadError']);
                }

                // validacion de EXITO cuando se EDITA bien producto
                if (isset($_SESSION['editInventorySuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['editInventorySuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['editInventorySuccess']);
                }

                // validacion de EXITO cuando se ELIMINA bien producto
                if (isset($_SESSION['deleteInventorySuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['deleteInventorySuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['deleteInventorySuccess']);
                }

                // validacion de ERROR cuando no se filtran bien producto
                if (isset($_SESSION['filterInventoryError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['filterInventoryError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['filterInventoryError']);
                }
                /*********************************************************************SUMAR*********************************************************************************/
                //Validaciones de ERROR al SUMAR cantidad en producto
                if (isset($_SESSION['sumCInventoryCantidadError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['sumCInventoryCantidadError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['sumCInventoryCantidadError']);
                }

                // validacion de EXITO cuando se SUMA bien cantidad al producto
                if (isset($_SESSION['sumCInventoryCantidadSuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['sumCInventoryCantidadSuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['sumCInventoryCantidadSuccess']);
                }

                // validacion de ERROR cuando se actualiza mal la suma de la cantidad al producto
                if (isset($_SESSION['sumCInventoryCantidadUpdError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['sumCInventoryCantidadUpdError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['sumCInventoryCantidadUpdError']);
                }

                // validacion de ERROR cuando se trata de obtener la suma de la cantidad al producto
                if (isset($_SESSION['sumCInventoryCantidadObtError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['sumCInventoryCantidadObtError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['sumCInventoryCantidadObtError']);
                }

                // validacion de ERROR cuando la cantidad no se ha brindado para sumar al producto
                if (isset($_SESSION['sumCInventoryCantidadMissError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['sumCInventoryCantidadMissError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['sumCInventoryCantidadMissError']);
                }

                // validacion de ERROR cuando la solicitud para sumar no es valida
                if (isset($_SESSION['sumCInventoryCantidadInvalidError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['sumCInventoryCantidadInvalidError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['sumCInventoryCantidadInvalidError']);
                }


                /*********************************************************************RESTAR*******************************************************************************/
                //Validaciones de ERROR al RESTAR cantidad en producto
                if (isset($_SESSION['subCInventoryCantidadError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['subCInventoryCantidadError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['subCInventoryCantidadError']);
                }

                // validacion de EXITO cuando se RESTA bien cantidad al producto
                if (isset($_SESSION['subCInventoryCantidadSuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['subCInventoryCantidadSuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['subCInventoryCantidadSuccess']);
                }

                // validacion de ERROR cuando se actualiza mal la RESTA de la cantidad al producto
                if (isset($_SESSION['subCInventoryCantidadUpdError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['subCInventoryCantidadUpdError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['subCInventoryCantidadUpdError']);
                }

                // validacion de ERROR cuando se trata de obtener la RESTA de la cantidad al producto
                if (isset($_SESSION['subCInventoryCantidadObtError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['subCInventoryCantidadObtError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['subCInventoryCantidadObtError']);
                }

                // validacion de ERROR cuando la solicitud para RESTAR no es valida
                if (isset($_SESSION['subCInventoryCantidadInvalidError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['subCInventoryCantidadInvalidError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['subCInventoryCantidadInvalidError']);
                }


                // validacion de ERROR cuando la solicitud para RESTAR no es valida
                if (isset($_SESSION['subCInventoryInventoryIs0'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['subCInventoryInventoryIs0']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['subCInventoryInventoryIs0']);
                }

                ?>




            </div>


            <!--######################################################################################################################################################-->
            <!--script para eliminar producto-->

            <script>
                $(document).ready(function () {
                    //es clase de btn de eliminar en readinventory
                    $('.btnDeleteInventory').on('click', function () {
                        $('#modalDeleteInventory').modal('show');

                        // Obtiene data del ID para eliminar
                        $tr = $(this).closest('tr');
                        var data = $tr.children("td").map(function () {
                            return $(this).text().trim();
                        }).get();
                        console.log(data);
                        $('#idProducto_delete').val(data[0]);
                        //idProducto_delete debe matchear con input de form delete
                    });
                });
            </script>

        </div>
        <!--######################################################################################################################################################-->
        <!-- Modal popup de crear producto en inventario -->
        <form class="row g-3 needs-validation" action="../controller/crudInventory/createInventory.php" method="POST"
            novalidate>
            <div class="modal fade" id="modalCreateInventory" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="examplemodalCreateInventory" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Agrega un nuevo producto</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form para agregar un producto -->
                            <div class="formAddInventory">
                                <label for="">Nombre de Producto</label>
                                <input type="text" name="nombreProducto" placeholder="Ingrese el nombre"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    El nombre del producto es requerido
                                </div>
                            </div>

                            <div class="formAddInventory">
                                <label for="">Cantidad</label>
                                <input type="number" min="0" name="cantidad" placeholder="Ingrese la cantidad"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    La cantidad del producto es requerida
                                </div>
                            </div>

                            <div class="formAddInventory">
                                <label for="">Descripción</label>
                                <input type="text" name="descripcion" placeholder="Ingrese la descripción"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    La descripción del producto es requerida
                                </div>
                            </div>

                            <div class="formAddInventory">
                                <label for="">Categoría del Producto</label>
                                <!--el name se usa para referenciar en create inventory para fetchear info en sql y crear-->
                                <select name="idCategoria" id="nombreCategoriaCrear" class="form-control custom-select"
                                    style="width: 95%" required>
                                    <option value="" disabled selected>Seleccionar categoría...</option>
                                    <?php
                                    $query = "SELECT * FROM categorias";
                                    $result = mysqli_query($connection, $query);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['idCategoria'] . '">' . $row['nombreCategoria'] . '</option>';
                                        }
                                    } else {
                                        echo "Query falló al obtener categorías " . mysqli_error($connection);
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Debe seleccionar una opción
                                </div>
                            </div>

                            <div class="disclaimer">
                                <i class="fa-regular fa-circle-question" style="color: #9d9c9c;"></i>
                                <p>El nombre del producto debe de ser único, y la cantidad sólo permite números</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" name="btnAddInventory" value="Crear Producto"
                                onclick="submitForm(event)">
                            <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success-->

                        </div>

                    </div>
                </div>
            </div>

        </form>
        <!--######################################################################################################################################################-->
        <div class="info2">
            <!-- MODAL PARA SUMAR CANTIDAD AL PRODUCTO-->
            <form class="row g-3 needs-validation" action="../controller/crudInventory/sumCInventory.php" method="POST"
                novalidate>

                <div class="modal fade" id="modalSumCInventory" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="examplemodalSumCInventory" aria-hidden="true">

                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="examplemodalSumCInventory">Entrada de cantidad del
                                    producto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="margin-top: 0px; margin-bottom: 5px;">
                                <!-- SUMAR CANTIDAD AL PRODUCTO-->

                                <div class="formSumCInventory">
                                    <input type="hidden" name="idProducto" id="idProducto_sum"
                                        placeholder="ID de Producto" class="form-control" style="width: 95%;" required>
                                </div>

                                <div class="formSumCInventory">
                                    <label for="">Cantidad a agregar</label>
                                    <input type="number" min="0" name="sumarCantidad" id="sumarCantidad"
                                        class="form-control" placeholder="Ingrese el monto" style="width: 95%;"
                                        required>
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        La cantidad del producto es requerida
                                    </div>
                                </div>

                                <div class="disclaimer" style="margin-bottom: 10px; margin-top: 10px;">
                                    <i class="fa-regular fa-circle-question"
                                        style="color: #9d9c9c; margin-bottom: 5px;"></i>
                                    <p>El monto ingresado se suma a la cantidad actual, y sólo se aceptan números</p>
                                </div>

                                <div class="modal-footer" style="margin-bottom: -20px;">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" name="btnSumarCantidad">Sumar cantidad
                                    </button>
                                    <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success-->
                                </div>

                            </div>
                        </div>
                    </div>

            </form>

            <script>
                $(document).ready(function () {
                    //class btnSumProduct se agarra de btn sum en read inventory
                    $('.btnSumProduct').on('click', function () {
                        $('#modalSumCInventory').modal('show');

                        // Obtiene data y pobla los fields del form sum sumar productos
                        var $tr = $(this).closest('tr');
                        var data = $tr.children("td").map(function () {
                            return $(this).text().trim();
                        }).get();
                        console.log("Data:", data);

                        $('#idProducto_sum').val(data[0]);

                    });
                });
            </script>
        </div>
        <!--######################################################################################################################################################-->
        <div class="info3">
            <!-- MODAL PARA RESTAR CANTIDAD AL PRODUCTO-->
            <form class="row g-3 needs-validation" action="../controller/crudInventory/subCInventory.php" method="POST"
                novalidate>

                <div class="modal fade" id="modalSubCInventory" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="examplemodalSubCInventory" aria-hidden="true">

                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="examplemodalSubCInventory">Salida de cantidad del
                                    producto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="margin-top: 0px; margin-bottom: 5px;">
                                <!-- RESTAR CANTIDAD AL PRODUCTO-->

                                <div class="formSubCInventory">
                                    <input type="hidden" name="idProducto" id="idProducto_sub"
                                        placeholder="ID de Producto" class="form-control" style="width: 95%;" required>
                                </div>

                                <div class="formSubCInventory">
                                    <label for="">Cantidad a retirar</label>
                                    <input type="number" min="0" name="restarCantidad" id="restarCantidad"
                                        class="form-control" placeholder="Ingrese el monto" style="width: 95%;"
                                        required>

                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        La cantidad del producto es requerida
                                    </div>
                                </div>

                                <div class="disclaimer" style="margin-bottom: 10px; margin-top: 10px;">
                                    <i class="fa-regular fa-circle-question" style="color: #9d9c9c;"></i>
                                    <p>El monto ingresado se resta de la cantidad actual, y sólo se aceptan números</p>
                                </div>

                                <div class="modal-footer" style="margin-bottom: -20px;">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" name="btnRestarCantidad">Restar
                                        cantidad
                                    </button>
                                    <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success-->
                                </div>

                            </div>
                        </div>
                    </div>

            </form>
            <script>
                $(document).ready(function () {
                    //class btnSubProduct se agarra de btn sub en read inventory
                    $('.btnSubProduct').on('click', function () {
                        $('#modalSubCInventoryy').modal('show');

                        // Obtiene data y pobla los fields del form sub restar productos
                        var $tr = $(this).closest('tr');
                        var data = $tr.children("td").map(function () {
                            return $(this).text().trim();
                        }).get();
                        console.log("Data:", data);

                        $('#idProducto_sub').val(data[0]);

                    });
                });
            </script>

        </div>
        <!--######################################################################################################################################################-->
        <!-- Modal para EDITAR Inventario -->
        <form class="row g-3 needs-validation" action="../controller/crudInventory/updateInventory.php" method="POST"
            novalidate>
            <div class="modal fade" id="modalEditInventory" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="examplemodalEditInventory" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar este producto</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body" style="margin-top: -10px; margin-bottom: 5px;">
                            <!-- Form para editar categoría -->

                            <div class="formUpdInventory">
                                <input type="hidden" name="idProducto" id="idProducto" placeholder="ID de Producto"
                                    class="form-control" style="width: 95%;" required>
                            </div>


                            <div class="formUpdInventory">
                                <label for="">Nombre de Producto</label>
                                <input type="text" name="nombreProducto" id="nombreProducto_edit"
                                    placeholder="Ingrese el nombre" class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    El nombre del producto es requerido
                                </div>
                            </div>

                            <div class="formUpdInventory">
                                <label for="">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" placeholder="Ingrese la cantidad"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    La cantidad del producto es requerida
                                </div>
                            </div>

                            <div class="formUpdInventory">
                                <label for="">Descripción</label>
                                <input type="text" name="descripcion" id="descripcion"
                                    placeholder="Ingrese la descripción" class="form-control" style="width: 95%;"
                                    required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    La descripción del producto es requerida
                                </div>
                            </div>

                            <div class="formUpdInventory">
                                <label for="">Categoría del Producto</label>
                                <select name="idCategoria" id="nombreCategoria" class="form-control custom-select"
                                    style="width: 95%" required>
                                    <option value="" disabled selected>Seleccionar categoría...</option>
                                    <?php
                                    $query = "SELECT * FROM categorias";
                                    $result = mysqli_query($connection, $query);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['idCategoria'] . '">' . $row['nombreCategoria'] . '</option>';
                                        }
                                    } else {
                                        echo "Query falló al obtener categorías " . mysqli_error($connection);
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Debe seleccionar una opción
                                </div>
                            </div>

                            <div class="disclaimer">
                                <i class="fa-regular fa-circle-question"
                                    style="color: #9d9c9c; margin-bottom: 20px;"></i>
                                <p>El nombre del producto debe de ser único, y la cantidad, numeral</p>
                            </div>


                            <div class="modal-footer" style="margin-bottom: -20px;">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <input type="submit" class="btn btn-primary" name="btnSaveEditInventory"
                                    value="Guardar cambios" onclick="submitForm(event)">
                                <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success-->

                            </div>

                        </div>
                    </div>
                </div>

        </form>
        <!--###########################################################################################################################################################################################################################################################################################-->
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
        <!-- SCRIPT PARA FETCHEAR INFO DE INVENTARIO EN MODAL EDITAR-->
        <script>
            $(document).ready(function () {
                //class btneditinventory se agarra de btn editar en read inventory
                $('.btnEditInventory').on('click', function () {
                    $('#modalEditInventory').modal('show');

                    // Obtiene data y pobla los fields del form editar
                    var $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function () {
                        return $(this).text().trim();
                    }).get();
                    console.log("Data:", data);

                    $('#idProducto').val(data[0]);
                    $('#nombreProducto_edit').val(data[1]);
                    $('#cantidad').val(data[2]);
                    $('#descripcion').val(data[3]);
                    //se usa name del select en form modal edit
                    //$('#idCategoria').val(data[4]);

                    // Selecciona la opcion disponible en el dropdown, //se usa ID del select en form modal edit
                    var categoryValue = data[4].trim(); // Quita whitespace cuando tira dato
                    $('#nombreCategoria option').each(function () {
                        if ($(this).text().trim() === categoryValue) {
                            $(this).prop('selected', true);
                        }
                    });

                });
            });
        </script>




    </div>

    <!--################################################################################################################################################-->
    <!-- MODAL PARA ELIMINAR PRODUCTO INVENTARIO-->
    <form class="row" action="../controller/crudInventory/deleteInventory.php" method="POST">

        <div class="modal fade" id="modalDeleteInventory" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="examplemodalDeleteInventory" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #f2dede;">
                        <h1 class="modal-title fs-5" id="examplemodalDeleteInventory" style="color: #943942;">
                            <i class="fa-solid fa-triangle-exclamation" style="color: #dc3545;"></i>Confirmar para
                            eliminar el producto
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Confirmar eliminar producto inventario -->

                        <div class="formDeleteInventory">
                            <input type="hidden" name="idProducto_delete" id="idProducto_delete">
                        </div>

                        <div class="formDeleteIconInventory"
                            style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-circle-exclamation fa-5x"
                                style="color: #dc3545; margin-right: 50px; margin-bottom: 10px;"></i>
                        </div>

                        <div class="formDeleteInventory" style="text-align: center">
                            <p>¿Está seguro que desea eliminar el producto? Esta acción no podrá revertirse. Si no está
                                seguro, puede
                                cancelar la acción</p>
                        </div>


                        <div class="modal-footer" style="display: flex; justify-content: center; margin-bottom: -15px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No,
                                cancelar</button>
                            <button type="submit" class="btn btn-success" name="btnConfirmDeleteInventory">Sí, confirmar
                            </button>
                            <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success-->

                        </div>

                    </div>
                </div>
            </div>

    </form>




    <!--################################################################################################################################################-->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>



</html>