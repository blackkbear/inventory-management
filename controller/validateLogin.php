<?php
include (__DIR__ . "/../model/connectiondb.php");

session_start();

//revisa si usuario dio click en iniciar sesion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //se envio algo, se posteo y se almacena data, se pone nombre variables, luego se pone nombre dependiendo de lo que se nombro en inputs.
  $username = $_POST['nombreUsuario'];
  $password = $_POST['clave'];

  // Validación de campos vacíos

  if (empty ($password) && empty ($username)) {
    $_SESSION['loginError'] = "La contraseña o el usuario están faltantes";
    header("Location: ./index.php");
    die;
  }
  if (empty ($username)) {
    $_SESSION['loginError'] = "El nombre de usuario es requerido";
    header("Location: ./index.php");
    die;
  }

  if (empty ($password)) {
    $_SESSION['loginError'] = "La contraseña es requerida";
    header("Location: ./index.php");
    die;
  }

  //se pueden crear mas validaciones, como username no puede ser numeros, y si es true, se entra al if.
  if (!is_numeric($username)) {
    if (!empty ($username) && !empty ($password)) {
      //se lee desde base de datos, se especifican columnas donde se quiere leer info introducida con post, y se limita a obtener 1 resultado
      $query = "SELECT * FROM usuarios WHERE nombreUsuario = '$username' limit 1";
      //se guarda resultado de consulta a db
      $result = mysqli_query($connection, $query);

      //se revisa si resultado fue exitoso
      if ($result && mysqli_num_rows($result) > 0) {
        //si funciono, se guarda en loggedUser
        $loggedUser = mysqli_fetch_assoc($result);

        if ($loggedUser['contrasena'] === $password) {
          $_SESSION['loggedin'] = true;
          $_SESSION['nombreUsuario'] = $username; // Aquí debes establecer el nombre de usuario
          $_SESSION['user'] = $loggedUser; // Aquí debes establecer el usuario completo

          header("Location: view/homepage.php");
          die;
        } else {
          $_SESSION['loginError'] = "El usuario o contraseña son incorrectos";
        }
      } else {
        $_SESSION['loginError'] = "El usuario o contraseña son incorrectos";
      }
    } else {
      $_SESSION['loginError'] = "El usuario o contraseña son incorrectos";
    }
  }
}
?>