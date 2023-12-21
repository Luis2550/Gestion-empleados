<?php

//insertar informacion

include("../../bd.php");

if($_POST){

   //recolectamos los datos
   $nombreUsuario = (isset($_POST["nombreUsuario"])?$_POST["nombreUsuario"]:"");
   $contrasenia = (isset($_POST["contrasenia"])?$_POST["contrasenia"]:"");
   $correo = (isset($_POST["correo"])?$_POST["correo"]:"");

  $sentencia = $conexion->prepare("INSERT INTO tbl_usuario(id,usuario,contrasenia,correo)
        VALUES(null, :nombreUsuario, :contrasenia, :correo)");

  $sentencia->bindParam(":nombreUsuario",$nombreUsuario);
  $sentencia->bindParam(":contrasenia",$contrasenia);
  $sentencia->bindParam(":correo",$correo);

  $sentencia->execute();

  $mensaje = 'Registro creado';
  header("location:index.php?mensaje=".$mensaje);
}

?>


<?php include("../../templates/header.php"); ?>

<br>

<div class="card">
    <div class="card-header">
        <h5>Datos Usuario</h5>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nombreUsuario" class="form-label">Nombre del usuario:</label>
              <input type="text"
                class="form-control" name="nombreUsuario" id="nombreUsuario" aria-describedby="helpId" placeholder="Nombre del usuario">
            </div>

            <div class="mb-3">
              <label for="contrasenia" class="form-label">Contraseña:</label>
              <input type="password"
                class="form-control" name="contrasenia" id="contrasenia" aria-describedby="helpId" placeholder="Contraseña">
            </div>

            <div class="mb-3">
              <label for="correo" class="form-label">Correo:</label>
              <input type="email"
                class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>      
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>

<?php include("../../templates/footer.php") ?>