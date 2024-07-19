<?php
include (__DIR__ . "/controller/validateLogin.php");
include (__DIR__ . "/controller/validateSession.php");
/* <div class="logo">
            <img src="img/sinBgLogo.png" alt="DentoSaludLogo">
  </div> */

/**este index es para abrir el sistema siempre en el login */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="view/styleLogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <link rel="icon" type="image/jpg" href="../img/logoFavicon.jpg">
    <title>Iniciar Sesión - DentoSalud</title>
</head>

<body>
    <div class="container">
        <div class="titulo">
            <h1>DentoSalud Centro Médico & Dental</h1>
        </div>
        <div class="box form-box">
            <header>Ingreso de Usuarios</header>

            <?php if (isset($_SESSION['loginError'])): ?>
            <div class="loginError">
                <?php echo $_SESSION['loginError']; ?>
            </div>
            <?php unset($_SESSION['loginError']); ?>
            <?php endif; ?>

            <form class="row g-3 needs-validation" method="post" novalidate>

                <div class="field input">

                    <label for="nombreUsuario">Nombre de Usuario</label>
                    <input type="text" name="nombreUsuario" id="nombreUsuario" />

                </div>

                <div class="field input">
                    <label for="clave">Contraseña</label>
                    <input type="password" name="clave" id="clave" />

                </div>

                <div class="field">
                    <button type="submit" value="login">Iniciar Sesión</button>
                </div>

            </form>
            <div class="disclaimer">
                <h4>Si olvidaste la contraseña o no tienes una cuenta, contacte con el administrador del sistema.</h4>
            </div>
        </div>

    </div>

    <!--<p style="color: #a1bed12b; margin-left: 15px; font-size: 14px;">
                Creado por: Rachel Ariana Montero Branford
            </p>-->

</body>

</html>