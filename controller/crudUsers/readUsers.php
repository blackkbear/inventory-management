<?php

include (__DIR__ . "/../../model/connectiondb.php");

if (!isset ($_SESSION["nombreUsuario"])) {
    header("Location: ../../index.php");
    exit; /*previene mas ejecuciones de scripts*/
}


/* Si no hay usuario, nos mandara al login*/

/*Read Users */
$query = "SELECT * from usuarios";
$result = mysqli_query($connection, $query);
if (!$result) {
    die ("Connection failed" . mysqli_error($connection));
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
<tr>
    <td>
        <?php echo $row['idEmpleado'] ?>
    </td>
    <td>
        <?php echo $row['nombreCompleto'] ?>
    </td>
    <td>
        <?php echo $row['cedula'] ?>
    </td>
    <td>
        <?php echo $row['nombreUsuario'] ?>
    </td>
    <td class="hidetext">
        <?php echo str_repeat('*', strlen($row['contrasena'])); ?>
    </td>
    <td>
        <?php echo $row['rolUsuario'] ?>
    </td>
    <td>
        <!--con esto data password permite que se guarde contraseña real en edit-->
        <!--class btn se usa para fetchear data de usuario y mostrarla en editar modal-->
        <button class="btnEditUser" data-bs-toggle="modal" data-bs-target="#modalEditUser"
            data-password="<?php echo $row['contrasena']; ?>"
            <?php echo $loggedUser['rolUsuario'] == 'Regular' ? 'disabled' : ''; ?>>Editar</button>
        <button class="btnDeleteUser" data-bs-toggle="modal" data-bs-target="#modalDeleteUser"
            <?php echo $loggedUser['rolUsuario'] == 'Regular' ? 'disabled' : ''; ?>>Eliminar</button>
    </td>
</tr>
<?php
    }
}

/**<a href="usersView.php?idEmpleado=<?php echo $row['idEmpleado']; ?>" data-bs-toggle="modal"
data-bs-target="#modalEditUser">Editar</a> */


?>