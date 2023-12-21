
<?php
include("../../bd.php");

if(isset($_GET["txtID"])){
    $txtID = (isset($_GET["txtID"]))?$_GET["txtID"]:"";

    $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombrePuesto = $registro["nombre_puesto"];
}


if($_POST){

//recolectamos los datos
$txtID = (isset($_POST["txtID"])?$_POST["txtID"]:"");
$nombrepuesto = (isset($_POST["nombrePuesto"])?$_POST["nombrePuesto"]:"");
//insercion de los datos
$sentencia = $conexion->prepare("UPDATE tbl_puestos SET nombre_puesto=:nombrePuesto WHERE id=:id");

$sentencia->bindParam(":nombrePuesto",$nombrepuesto);
$sentencia->bindParam(":id",$txtID);
$sentencia->execute();
$mensaje = 'Registro actualizado';
header("location:index.php?mensaje=".$mensaje);
}


?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        <h5>Datos puesto</h5>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="txtID" class="form-label">ID:</label>
              <input type="text" value = "<?php echo $txtID;?>"
                class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">

            </div>

            <div class="mb-3">
              <label for="nombrePuesto" class="form-label">Nombre del puesto</label>
              <input type="text" value = "<?php echo $nombrePuesto;?>"
                class="form-control" name="nombrePuesto" id="nombrePuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>      
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>

<?php include("../../templates/footer.php") ?>