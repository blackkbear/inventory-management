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

    <link rel="stylesheet" href="styleHomepage.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/jpg" href="../img/logoFavicon.jpg">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>Página Principal - DentoSalud</title>
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
                <div class="tituloAlertasProductos"><i class="fa-solid fa-triangle-exclamation"
                        style="color: #dc3545;"></i>
                    Alertas sobre Productos - Notificaciones
                </div>

                <div class="funcionAgregar">

                    <div class="disclaimer">
                        <i class="fa-regular fa-circle-question" style="color: #9d9c9c;"></i>
                        <p>Se alertará cuando un producto tiene una cantidad menor a 5, o si ha llegado a 0,
                            con el fin de monitorear y tomar acciones.
                        </p>
                    </div>


                </div>

                <div class="containerTable">
                    <table>
                        <thead>
                            <tr>
                                <th>Descripción de Alerta</th>
                                <th>Nombre de Producto</th>
                                <th>Categoría</th>
                                <th>Cantidad Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* se llama funcion de leer alertas en tabla*/
                            require (__DIR__ . "/../controller/rdAlertsProducts/readAlertsProducts.php");
                            ?>

                        </tbody>

                    </table>
                </div>

                <!--validaciones de error o de exito de SQL-->
                <?php

                //validacion de error cuando se crea categoria porque nombre ya existe
                if (isset($_SESSION['addCategoryNameError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['addCategoryNameError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addCategoryNameError']);
                }


                // validacion cuando se edita bien categoria
                if (isset($_SESSION['solvedAlertsProductsSuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['solvedAlertsProductsSuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['solvedAlertsProductsSuccess']);
                }



                ?>

            </div>

            <!--<form class="row" action="../controller/rdAlertsProducts/deleteAlertsProducts.php" method="POST">

                <div class="modal fade" id="modalDeleteAlertsProducts" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="examplemodalDeleteAlertsProducts"
                    aria-hidden="true">

                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="examplemodalDeleteAlertsProducts">
                                    <i style="color: #dc3545;"></i>Confirmar
                                    para
                                    eliminar la alerta
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">-->
            <!-- Confirmar eliminar producto inventario -->

            <!--<div class="formDeleteInventory">
                                    <input type="hidden" name="idAlerta" id="idAlerta_delete">
                                </div>

                                <div class="formDeleteInventory" style="text-align: center">
                                    <h6>¿Está seguro que desea eliminar esta alerta?</h6>
                                </div>

                                <div class="modal-footer"
                                    style="display: flex; justify-content: center; margin-bottom: -15px;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No,
                                        cancelar</button>
                                    <button type="submit" class="btn btn-success"
                                        name="btnConfirmDeleteAlertsProducts">Sí,
                                        confirmar
                                    </button>-->
            <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success-->

            <!--</div>

                            </div>
                        </div>
                    </div>

            </form>-->

            <!--script para eliminar alerta-->



        </div>

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

        <!--################################################################################################################################################-->
        <!--<script>
        $(document).ready(function() {
            //es clase de btn de eliminar en readinventory
            $('.btnDeleteAlertsProducts').on('click', function() {
                $('#modalDeleteAlertsProducts').modal('show');

                // Obtiene data del ID para eliminar
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text().trim();
                }).get();
                console.log(data);
                $('#idAlerta_delete').val(data[0]);
                //idProducto_delete debe matchear con input de form delete
            });
        });
        </script>-->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>


</body>


</html>