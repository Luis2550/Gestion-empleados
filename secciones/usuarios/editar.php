<?php include("../../templates/header.php"); ?>

<?php include("../../bd.php"); ?>

<?php
    if(isset($_GET["txtID"])){
        $txtID = (isset($_GET["txtID"]))?$_GET["txtID"]:"";

        $sentencia = $conexion->prepare("SELECT * FROM tbl_usuario WHERE id = :id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();

        $registro = $sentencia->fetch(PDO::FETCH_LAZY);
        $usuario = $registro["usuario"];
        $contrasenia = $registro["contrasenia"];
        $correo = $registro["correo"];

    }

    if($_POST){

      $txtID = (isset($_POST["txtID"])?$_POST["txtID"]:"");
      $nombreUsuario = (isset($_POST["nombreUsuario"])?$_POST["nombreUsuario"]:"");
      $contrasenia = (isset($_POST["contrasenia"])?$_POST["contrasenia"]:"");
      $correo = (isset($_POST["correo"])?$_POST["correo"]:"");

      $sentencia = $conexion->prepare("UPDATE tbl_usuario SET 
      usuario=:nombreUsuario, 
      contrasenia=:contrasenia, 
      correo=:correo WHERE id=:txtID");

      $sentencia->bindParam(":txtID",$txtID);
      $sentencia->bindParam(":nombreUsuario",$nombreUsuario);
      $sentencia->bindParam(":contrasenia",$contrasenia);
      $sentencia->bindParam(":correo",$correo);

      $sentencia->execute();

      $mensaje = 'Registro actualizado';
      header("location:index.php?mensaje=".$mensaje);
    }
?>



<br>

<div class="card">
    <div class="card-header">
        <h5>Datos Usuario</h5>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="txtID" class="form-label">ID</label>
              <input type="text" value="<?php echo $txtID?>" readonly
                class="form-control" name="txtID" id="txtID" aria-describedby="helpId" placeholder="">
            </div>

            <div class="mb-3">
              <label for="nombreUsuario" class="form-label">Nombre del usuario:</label>
              <input type="text" value = "<?php echo $usuario?>"
                class="form-control" name="nombreUsuario" id="nombreUsuario" aria-describedby="helpId" placeholder="Nombre del usuario">
            </div>

            <div class="mb-3">
              <label for="contrasenia" class="form-label">Contraseña:</label>
              <input type="password" value = "<?php echo $contrasenia?>" 
                class="form-control" name="contrasenia" id="contrasenia" aria-describedby="helpId" placeholder="Contraseña"> 
            </div>

            <div class="mb-3">
              <label for="correo" class="form-label">Correo:</label>
              <input type="email" value = "<?php echo $correo?>"
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