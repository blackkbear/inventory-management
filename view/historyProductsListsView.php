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

    <link rel="stylesheet" href="styleHistoryLists.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/jpg" href="../img/logoFavicon.jpg">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>Historial de Pedidos - DentoSalud</title>
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
                <div class="tituloGestionarUsuarios">
                    Historial de Pedidos
                </div>

                <div class="funcionAgregar">




                </div>

                <div class="containerTable">
                    <table>
                        <thead>
                            <tr>
                                <th># de Pedido</th>
                                <th>Nombre</th>
                                <th>Fecha del Pedido</th>
                                <th>Descripción de la Lista</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* se llama funcion de leer users en tabla*/
                            require (__DIR__ . "/../controller/crudProductsLists/readHistory.php");
                            ?>




                        </tbody>
                    </table>
                </div>


            </div>

            <!--validaciones de error o de exito de SQL-->
            <div class="customAlerts">
                <?php


                //validacion de ERROR porque no hay productos listos en tabla
                if (isset($_SESSION['readReadyError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['readReadyError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['readReadyError']);
                }

                // validacion EXITO 
                if (isset($_SESSION['deleteHistoryListSuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['deleteHistoryListSuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['deleteHistoryListSuccess']);
                }


                ?>
            </div>

            <!--######################################################################################################################################################-->
            <!--script para eliminar lista del historial para siempre-->
            <script>
                $(document).ready(function () {
                    //class btnDeleteHistoryList se agarra de btn delete en readReady
                    $('.btnDeleteHistoryList').on('click', function () {
                        $('#modalDeleteHistoryList').modal('show');

                        // Obtiene data del ID para eliminar
                        $tr = $(this).closest('tr');
                        var data = $tr.children("td").map(function () {
                            return $(this).text().trim();
                        }).get();
                        console.log(data);
                        $('#idPedidoHistory_delete').val(data[0]);
                        $('#estadoPedidoHistory_delete').val(data[4]);

                        //estos fields debe matchear con input de form deleteHistory
                    });
                });
            </script>
            <!--######################################################################################################################################################-->
        </div>

        <!--######################################################################################################################################################-->
        <!-- Modal para EDITAR ESTADO DE LISTA-->
        <form class="row g-3 needs-validation" action="../controller/crudProductsLists/updateStatusList.php"
            method="POST" novalidate>
            <div class="modal fade" id="modalEditStatus" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="examplemodalEditStatus" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #d6e6de;">
                            <h1 class="modal-title fs-5" id="examplemodalEditStatus" style="color: #547761;"><i
                                    class="fa-regular fa-square-check"
                                    style="color: #57b52c; margin-right: 5px;"></i></i>Confirmar para
                                completar pedido</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Confirmar eliminar usuario -->

                            <div class="formEditStatus">
                                <input type="hidden" name="idPedido" id="idPedido" placeholder="ID de Pedido"
                                    class="form-control" style="width: 95%;" required>
                            </div>

                            <div class="formEditStatus">
                                <input type="hidden" name="estadoPedido" id="estadoPedido" placeholder="ID de Pedido"
                                    class="form-control" style="width: 95%;" required>
                            </div>

                            <div class="formEditStatus"
                                style="display: flex; justify-content: center; align-items: center;">
                                <i class="fa-solid fa-circle-check fa-5x"
                                    style="color: #57b52c; margin-right: 50px; margin-bottom: 10px;"></i>
                            </div>

                            <div class="fformEditStatus" style="text-align: center">
                                <h6>¿Está seguro que desea completar este pedido? Esta acción no podrá revertirse, y el
                                    pedido pasará al historial de pedidos</h6>
                            </div>

                            <div class="modal-footer"
                                style="display: flex; justify-content: center; margin-bottom: -15px;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No,
                                    cancelar</button>
                                <button type="submit" class="btn btn-success" name="btnConfirmEditStatus">Sí, completar
                                </button>
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
        <!-- SCRIPT PARA FETCHEAR INFO DE IDPEDIDO EN MODAL EDITAR ESTADO-->
        <script>
            $(document).ready(function () {
                //class btnStatusList se agarra de btn editar estado en read products
                $('.btnStatusList').on('click', function () {
                    $('#modalEditStatus').modal('show');

                    // Obtiene data y pobla los fields del form editar
                    var $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function () {
                        return $(this).text().trim();
                    }).get();
                    console.log(data);
                    $('#idPedido').val(data[0]);
                    $('#estadoPedido').val(data[4]);

                });
            });
        </script>
    </div>
    <!--################################################################################################################################################-->
    <form class="row" action="../controller/crudProductsLists/deleteHistoryList.php" method="POST">
        <div class="modal fade" id="modalDeleteHistoryList" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="examplemodalDeleteHistoryList" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #f2dede;">
                        <h1 class="modal-title fs-5" id="examplemodalDeleteHistoryList" style="color: #943942;"><i
                                class="fa-solid fa-triangle-exclamation" style="color: #dc3545;"></i>Confirmar para
                            eliminar lista del historial</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="formDeleteHistoryList">
                            <input type="hidden" name="idPedido_delete" id="idPedidoHistory_delete"
                                placeholder="ID de Pedido" class="form-control" style="width: 95%;" required>
                        </div>
                        <div class="formDeleteHistoryList">
                            <input type="hidden" name="estadoPedido_delete" id="estadoPedidoHistory_delete"
                                placeholder="Estado de Pedido" class="form-control" style="width: 95%;" required>
                        </div>
                        <div class="formDeleteHistoryList"
                            style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-circle-exclamation fa-5x"
                                style="color: #dc3545; margin-right: 50px; margin-bottom: 10px;"></i>
                        </div>
                        <div class="formDeleteHistoryList" style="text-align: center">
                            <p>¿Está seguro que desea eliminar la lista del historial? Se eliminará para siempre, y
                                esta acción no podrá revertirse</p>
                        </div>
                        <div class="modal-footer" style="display: flex; justify-content: center; margin-bottom: -15px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No,
                                cancelar</button>
                            <button type="submit" class="btn btn-success" name="btnConfirmDeleteHistoryList">Sí,
                                confirmar
                            </button>
                        </div>
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