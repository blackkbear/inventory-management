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

    <link rel="stylesheet" href="styleUsersHomepage.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/jpg" href="../img/logoFavicon.jpg">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <title>Gestionar Usuarios - DentoSalud</title>
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
                    Gestionar Usuarios
                </div>

                <div class="funcionAgregar">

                    <div class="disclaimerHeader">
                        <i class="fa-regular fa-circle-question" style="color: #9d9c9c;"></i>
                        <p>Sólo los usuarios Admin pueden agregar, editar o eliminar los usuarios
                        </p>
                    </div>

                    <div>
                        <!-- btnAgregarUsuario al hacer click se abre modal pop up para agregar uno-->
                        <button class="btnAgregarUsuario" data-bs-toggle="modal" data-bs-target="#modalCreateUser"
                            <?php echo $loggedUser['rolUsuario'] == 'Regular' ? 'disabled' : ''; ?>>Agregar
                            Usuario</button>
                    </div>

                </div>

                <div class="containerTable">
                    <table>
                        <thead>
                            <tr>
                                <th>Id de Empleado</th>
                                <th>Nombre Completo</th>
                                <th>Cédula</th>
                                <th>Nombre de Usuario</th>
                                <th>Contraseña</th>
                                <th>Rol</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* se llama funcion de leer users en tabla*/
                            require (__DIR__ . "/../controller/crudUsers/readUsers.php");
                            ?>




                        </tbody>
                    </table>
                </div>


            </div>

            <!--validaciones de error o de exito de SQL-->
            <div class="customAlerts">
                <?php
                //validacion de ERROR cuando se crea usuario porque nombre usuario ya existe
                if (isset ($_SESSION['addUsernameError'])) {
                    ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong>
                    <?php echo $_SESSION['addUsernameError']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php

                    unset($_SESSION['addUsernameError']);
                }
                //validacion de ERROR cuando se EDITA usuario porque cedula ya existe
                if (isset ($_SESSION['editUserCedulaError'])) {
                    ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong>
                    <?php echo $_SESSION['editUserCedulaError']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php

                    unset($_SESSION['editUserCedulaError']);
                }

                //validacion de ERROR cuando se crea usuario porque cedula ya existe
                if (isset ($_SESSION['addUserCedulaError'])) {
                    ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong>
                    <?php echo $_SESSION['addUserCedulaError']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php

                    unset($_SESSION['addUserCedulaError']);
                }

                // validacion EXITO cuando se edita bien usuario
                if (isset ($_SESSION['editUserSuccess'])) {
                    ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Genial!</strong>
                    <?php echo $_SESSION['editUserSuccess']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php

                    unset($_SESSION['editUserSuccess']);
                }

                //validacion EXITO cuando se crea bien usuario
                if (isset ($_SESSION['addUserSuccess'])) {
                    ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Genial!</strong>
                    <?php echo $_SESSION['addUserSuccess']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php

                    unset($_SESSION['addUserSuccess']);
                }

                //validacion EXITO de cuando se elimina bien usuario
                if (isset ($_SESSION['deleteUserSuccess'])) {
                    ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Genial!</strong>
                    <?php echo $_SESSION['deleteUserSuccess']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php

                    unset($_SESSION['deleteUserSuccess']);
                }

                //validacion de ERROR cuando se quiere eliminar usuario 1 ya que es el root
                if (isset ($_SESSION['deleteUserError'])) {
                    ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong>
                    <?php echo $_SESSION['deleteUserError']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php

                    unset($_SESSION['deleteUserError']);
                }

                ?>
            </div>

            <!--######################################################################################################################################################-->
            <!--script para eliminar categoria-->
            <script>
            $(document).ready(function() {
                //class btndeleteuser se agarra de btn delete en read users
                $('.btnDeleteUser').on('click', function() {
                    $('#modalDeleteUser').modal('show');

                    // Obtiene data del ID para eliminar
                    $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function() {
                        return $(this).text().trim();
                    }).get();
                    console.log(data);
                    $('#idEmpleado_delete').val(data[0]);
                    //idEmpleado_delete debe matchear con input de form delete
                });
            });
            </script>
            <!--######################################################################################################################################################-->
        </div>

        <!--######################################################################################################################################################-->
        <!-- Modal popup de agregar usuario -->
        <form class="row g-3 needs-validation" action="../controller/crudUsers/createUsers.php" method="POST"
            novalidate>
            <div class="modal fade" id="modalCreateUser" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="examplemodalCreateUser" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Agrega un nuevo usuario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form para agregar un usuario -->
                            <div class="formAddUsers">
                                <label for="">Nombre Completo</label>
                                <input type="text" name="nombreCompleto" placeholder="Ingrese el nombre"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    El nombre completo es requerido
                                </div>

                            </div>
                            <div class="formAddUsers">
                                <label for="">Cédula</label>
                                <input type="text" name="cedula" placeholder="Ingrese la cédula" class="form-control"
                                    style="width: 95%;" required>
                                <div class="invalid-feedback">
                                    La cédula es requerida
                                </div>

                            </div>

                            <div class="formAddUsers">
                                <label for="">Nombre de Usuario</label>
                                <input type="text" id="nombreUsuario_add" name="nombreUsuario"
                                    placeholder="Ingrese el nombre de usuario" class="form-control" style="width: 95%;"
                                    required>

                                <div class="invalid-feedback">
                                    El nombre de usuario es requerido
                                </div>
                            </div>

                            <div class="formAddUsers">
                                <label for="">Contraseña</label>
                                <input type="password" name="contrasena" placeholder="Ingrese la contraseña"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    La contraseña es requerida
                                </div>
                            </div>
                            <div class="formAddUsers">
                                <label for="">Rol de Usuario</label>
                                <select name="rolUsuario" class="form-control custom-select" style="width: 95%;"
                                    required>
                                    <option value="" disabled selected>Seleccionar rol...</option>
                                    <option value="admin">Admin</option>
                                    <option value="regular">Regular</option>
                                </select>
                                <div class="invalid-feedback">
                                    Debe seleccionar una opción
                                </div>
                            </div>
                            <div class="disclaimer">
                                <i class="fa-regular fa-circle-question" style="color: #9d9c9c;"></i>
                                <p>El nombre de usuario y cédula deben de ser únicos. Además, el nombre completo no
                                    puede ser el mismo que el nombre de usuario.</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" name="btnAddUser" value="Crear Usuario"
                                onclick="submitForm(event)">
                            <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success, y el name de btn se usa para postear info en crear-->

                        </div>

                    </div>
                </div>
            </div>

        </form>
        <!--######################################################################################################################################################-->
        <!-- Modal para EDITAR USUARIO ../controller/crudUsers/updateUsers.php -->
        <form class="row g-3 needs-validation" action="../controller/crudUsers/updateUsers.php" method="POST"
            novalidate>
            <div class="modal fade" id="modalEditUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="examplemodalEditUser" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar este usuario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form para editar usuario -->

                            <div class="formUpdUsers">
                                <input type="hidden" name="idEmpleado" id="idEmpleado" placeholder="ID de Empleado"
                                    class="form-control" style="width: 95%;" required>
                            </div>


                            <div class="formUpdUsers">
                                <label for="">Nombre Completo</label>
                                <input type="text" name="nombreCompleto" id="nombreCompleto_edit"
                                    placeholder="Ingrese su nombre" class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    El nombre completo es requerido
                                </div>

                            </div>

                            <div class="formUpdUsers">
                                <label for="">Cédula</label>
                                <input type="text" name="cedula" id="cedula" placeholder="Cédula" class="form-control"
                                    style="width: 95%;" required>
                                <div class="invalid-feedback">
                                    La cédula es requerida
                                </div>

                            </div>

                            <div class="formUpdUsers">

                                <input type="hidden" id="nombreUsuario" name="nombreUsuario" id="nombreUsuario"
                                    placeholder="Nombre de Usuario" class="form-control" style="width: 95%;" required>
                                <div class="invalid-feedback">
                                    El nombre de usuario es requerido
                                </div>

                            </div>

                            <div class="formUpdUsers">
                                <label for="">Contraseña</label>
                                <input type="text" name="contrasena" id="contrasena" placeholder="Ingrese la contraseña"
                                    class="form-control" style="width: 95%;" required>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    La contraseña es requerida
                                </div>
                            </div>
                            <div class="formUpdUsers">
                                <label for="">Rol de Usuario</label>
                                <select name="rolUsuario" id="rolUsuario" class="form-control custom-select"
                                    style="width: 95%;" required>
                                    <option value="" disabled selected>Seleccionar rol...</option>
                                    <option value="admin">Admin</option>
                                    <option value="regular">Regular
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    Debe seleccionar una opción
                                </div>
                            </div>

                            <div class="disclaimerUpdUser">
                                <i class="fa-regular fa-circle-question"
                                    style="color: #9d9c9c; margin-bottom: 20px;"></i>
                                <p>La cédula debe de ser única</p>
                            </div>

                            <div class="modal-footer" style="margin-bottom: -15px;">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <input type="submit" class="btn btn-primary" name="btnSaveUser" value="Guardar cambios"
                                    onclick="submitForm(event)">
                                <!--si quiero cambiar el boton a success verde, debo poner btn btn-primary success, y el name de btn se usa para postear info en update-->

                            </div>

                        </div>
                    </div>
                </div>

        </form>
        <!--###########################################################################################################################################################################################################################################################################################-->
        <!-- Funcion para hacer toggle listaCompras -->
        <script type="text/javascript">
        $(document).ready(function() {
            $('.btnShowPedidos').click(function() {
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
        <!-- SCRIPT PARA FETCHEAR INFO DE USUARIOS EN MODAL EDITAR-->
        <script>
        $(document).ready(function() {
            //class btnedituser se agarra de btn editar en read users
            $('.btnEditUser').on('click', function() {
                $('#modalEditUser').modal('show');

                // Obtiene data y pobla los fields del form editar
                var $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text().trim();
                }).get();
                console.log(data);
                $('#idEmpleado').val(data[0]);
                $('#nombreCompleto_edit').val(data[1]);
                $('#cedula').val(data[2]);
                $('#nombreUsuario').val(data[3]);
                var password = $(this).data('password');
                $('#contrasena').val(password);
                $('#rolUsuario').val(data[5]);

                // Selecciona la opcion disponible en el dropdown
                var roleValue = data[5].trim(); // Quita whitespace cuando tira dato
                $('#rolUsuario option').each(function() {
                    if ($(this).text().trim() === roleValue) {
                        $(this).prop('selected', true);
                    }
                });

            });
        });
        </script>
    </div>
    <!--################################################################################################################################################-->
    <form class="row" action="../controller/crudUsers/deleteUsers.php" method="POST">

        <div class="modal fade" id="modalDeleteUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="examplemodalDeleteUser" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #f2dede;">
                        <h1 class="modal-title fs-5" id="examplemodalDeleteUser" style="color: #943942;"><i
                                class="fa-solid fa-triangle-exclamation" style="color: #dc3545;"></i>Confirmar para
                            eliminar usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Confirmar eliminar usuario -->

                        <div class="formDeleteUsers">
                            <input type="hidden" name="idEmpleado_delete" id="idEmpleado_delete">
                        </div>

                        <div class="formDeleteUsers"
                            style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-circle-exclamation fa-5x"
                                style="color: #dc3545; margin-right: 50px; margin-bottom: 10px;"></i>
                        </div>

                        <div class="formDeleteUsers" style="text-align: center">
                            <p>¿Está seguro que desea eliminar el usuario? Esta acción no podrá revertirse</p>
                        </div>

                        <div class="modal-footer" style="display: flex; justify-content: center; margin-bottom: -15px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No,
                                cancelar</button>
                            <button type="submit" class="btn btn-success" name="btnConfirmDeleteUser">Sí, confirmar
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