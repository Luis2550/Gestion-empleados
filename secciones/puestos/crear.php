<?php

    include("../../bd.php");

    if($_POST){
    
    // muestra lo que se envia es decir muestra el valor del inpu que se envia a la base de datos
    //  print_r($_POST);
    //recolectamos los datos
    $nombrepuesto = (isset($_POST["nombrePuesto"])?$_POST["nombrePuesto"]:"");
    //insercion de los datos
    $sentencia = $conexion->prepare("INSERT INTO tbl_puestos(id,nombre_puesto)
        VALUES(null,:nombrePuesto)");

    $sentencia->bindParam(":nombrePuesto",$nombrepuesto);
    $sentencia->execute();

    $mensaje = 'Registro creado';
    header("location:index.php?mensaje=".$mensaje);

    }
?>

<?php include("../../templates/header.php"); ?>

<br>

<div class="card">
    <div class="card-header">
        <h5>Datos puesto</h5>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nombrePuesto" class="form-label">Nombre del puesto</label>
              <input type="text"
                class="form-control" name="nombrePuesto" id="nombrePuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>      
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>

<?php include("../../templates/footer.php") ?>