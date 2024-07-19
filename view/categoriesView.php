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

    <link rel="stylesheet" href="styleCategoriesHomepage.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/jpg" href="../img/logoFavicon.jpg">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>Gestionar Categorías - DentoSalud</title>
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
                <div class="tituloGestionarCategorias">
                    Gestionar Categorías
                </div>

                <div class="funcionAgregar">


                    <!--aqui en p iria el filter by-->

                    <p></p>

                    <div>
                        <!-- btnAgregarCategoria al hacer click se abre modal pop up para agregar uno, se pone el databstarget id de modal que desea abrir-->
                        <button class="btnAgregarCategoria" data-bs-toggle="modal"
                            data-bs-target="#modalCreateCategory">Agregar
                            Categoría</button>

                    </div>

                </div>

                <div class="containerTable">
                    <table>
                        <thead>
                            <tr>
                                <th>Id de Categoría</th>
                                <th>Nombre de Categoría</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* se llama funcion de leer categorías en tabla*/
                            require (__DIR__ . "/../controller/crudCategories/readCategories.php");
                            ?>


                        </tbody>
                    </table>
                </div>

                <!--validaciones de error o de exito de SQL-->
                <?php

                //validacion de error cuando se edita categoria porque nombre ya existe
                if (isset($_SESSION['editCategoryNameError'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong>
                        <?php echo $_SESSION['editCategoryNameError']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['editCategoryNameError']);
                }

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
                if (isset($_SESSION['editCategorySuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['editCategorySuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['editCategorySuccess']);
                }
                //validacion cuando se crea bien categoria
                if (isset($_SESSION['addCategorySuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['addCategorySuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['addCategorySuccess']);
                }

                //validacion de cuando se elimina bien categoria
                if (isset($_SESSION['deleteCategorySuccess'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Genial!</strong>
                        <?php echo $_SESSION['deleteCategorySuccess']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php

                    unset($_SESSION['deleteCategorySuccess']);
                }


                ?>



            </div>
            <!--script para eliminar categoria-->
            <script>
                $(document).ready(function () {
                    //es clase de btn de eliminar en readcategories
                    $('.btnDeleteCategory').on('click', function () {
                        $('#modalDeleteCategory').modal('show');

                        // Obtiene data del ID para eliminar
                        $tr = $(this).closest('tr');
                        var data = $tr.children("td").map(function () {
                            return $(this).text().trim();
                        }).get();
                        console.log(data);
                        $('#idCategoria_delete').val(data[0]);
                        //idEmpleado_delete debe matchear con input de form delete
                    });
                });
            </script>

        </div>
        <!--######################################################################################################################################################-->
        <!-- Modal popup de agregar categoria -->
        <form class="row g-3 needs-validation" action="../controller/crudCategories/createCategories.php" method="POST"
            novalidate>
            <div class="modal fade" id="modalCreateCategory" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="examplemodalCreateCategory" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Agrega una nueva categoría</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form para agregar una categoria -->
                            <div class="formAddCategories">
                                <label for="">Nombre de Categoría</label>
                                <input type="text" name="nombreCategoria" placeholder="Ingrese el nombre"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    El nombre de categoría es requerido
                                </div>

                            </div>

                            <div class="disclaimer">
                                <i class="fa-regular fa-circle-question" style="color: #9d9c9c;"></i>
                                <p>El nombre de categoría debe de ser único</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" name="btnAddCategory" value="Crear Categoría"
                                onclick="submitForm(event)">
                            <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success-->

                        </div>

                    </div>
                </div>
            </div>

        </form>
        <!--######################################################################################################################################################-->
        <!-- Modal para EDITAR Categoría -->
        <form class="row g-3 needs-validation" action="../controller/crudCategories/updateCategories.php" method="POST"
            novalidate>
            <div class="modal fade" id="modalEditCategory" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="examplemodalEditCategory" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar esta categoría</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form para editar categoría -->

                            <div class="formUpdCategories">
                                <input type="hidden" name="idCategoria" id="idCategoria" placeholder="ID de Categoría"
                                    class="form-control" style="width: 95%;" required>
                            </div>


                            <div class="formUpdCategories">
                                <label for="">Nombre de Categoría</label>
                                <input type="text" name="nombreCategoria" id="nombreCategoria_edit"
                                    placeholder="Ingrese el nombre" class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    El nombre de la categoría es requerido
                                </div>

                            </div>

                            <div class="disclaimer">
                                <i class="fa-regular fa-circle-question"
                                    style="color: #9d9c9c; margin-bottom: 20px;"></i>
                                <p>El nombre de categoría debe de ser único</p>
                            </div>

                            <div class="modal-footer" style="margin-bottom: -15px;">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <input type="submit" class="btn btn-primary" name="btnSaveEditCategory"
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
        <!-- SCRIPT PARA FETCHEAR INFO DE CATEGORIAS EN MODAL EDITAR-->
        <script>
            $(document).ready(function () {
                //class btneditcat se agarra de btn editar en read categ
                $('.btnEditCategory').on('click', function () {
                    $('#modalEditCategory').modal('show'); //id de modal de editar categoria
                    // Obtiene data y pobla los fields del form editar
                    var $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function () {
                        return $(this).text().trim();
                    }).get();
                    console.log(data);
                    $('#idCategoria').val(data[0]);
                    $('#nombreCategoria_edit').val(data[1]);
                });
            });
        </script>
    </div>

    <!--################################################################################################################################################-->
    <!-- MODAL PARA ELIMINAR CATEGORIA-->
    <form class="row" action="../controller/crudCategories/deleteCategories.php" method="POST">

        <div class="modal fade" id="modalDeleteCategory" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="examplemodalDeleteCategory" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #f2dede;">
                        <h1 class="modal-title fs-5" id="examplemodalDeleteCategory" style="color: #943942;">
                            <i class="fa-solid fa-triangle-exclamation" style="color: #dc3545;"></i>Confirmar para
                            eliminar categoría
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Confirmar eliminar categoría -->

                        <div class="formDeleteCategories">
                            <input type="hidden" name="idCategoria_delete" id="idCategoria_delete">
                        </div>

                        <div class="formDeleteIconCategory"
                            style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-circle-exclamation fa-5x"
                                style="color: #dc3545; margin-right: 50px; margin-bottom: 10px;"></i>
                        </div>

                        <div class="formDeleteCategories" style="text-align: center">
                            <p>¿Está seguro que desea eliminar la categoría? Ya que se eliminarán los productos
                                asociados a esta categoría, y esta acción no podrá revertirse. Si no está seguro, puede
                                cancelar la acción</p>
                        </div>


                        <div class="modal-footer" style="display: flex; justify-content: center; margin-bottom: -15px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No,
                                cancelar</button>
                            <button type="submit" class="btn btn-success" name="btnConfirmDeleteCategory">Sí, confirmar
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