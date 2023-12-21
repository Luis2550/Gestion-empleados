<?php include("../../bd.php");?>

<?php
if($_POST){
  
  $primerNombre = (isset($_POST["primerNombre"])?$_POST["primerNombre"]:"");
  $segundoNombre = (isset($_POST["segundoNombre"])?$_POST["segundoNombre"]:"");
  $primerApellido = (isset($_POST["primerApellido"])?$_POST["primerApellido"]:"");
  $segundoApellido = (isset($_POST["segundoApellido"])?$_POST["segundoApellido"]:"");

  $foto = (isset($_FILES["foto"]["name"])?$_FILES["foto"]["name"]:"");
  $cv = (isset($_FILES["cv"]["name"])?$_FILES["cv"]["name"]:"");

  $idPuesto = (isset($_POST["idPuesto"])?$_POST["idPuesto"]:"");
  $fechaIngreso = (isset($_POST["fechaIngreso"])?$_POST["fechaIngreso"]:"");

  $sentencia = $conexion->prepare("INSERT INTO tbl_empleados (id,primer_nombre,segundo_nombre,primer_apellido,segundo_Apellido,foto,cv,id_puesto,fecha_ingreso) 
  VALUES(NULL,:primerNombre,:segundoNombre,:primerApellido,:segundoApellido,:foto,:cv,:idPuesto,:fechaIngreso)");

  $sentencia->bindParam(":primerNombre",$primerNombre);
  $sentencia->bindParam(":segundoNombre",$segundoNombre);
  $sentencia->bindParam(":primerApellido",$primerApellido);
  $sentencia->bindParam(":segundoApellido",$segundoApellido);


  $fecha_ = new DateTime();
  $nombreArchivoFoto = ($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]["name"]:"";
  $tmp_foto=$_FILES["foto"]["tmp_name"];

  if($tmp_foto!=''){
    move_uploaded_file($tmp_foto,"./".$nombreArchivoFoto);
  };

  $nombreArchivoCv = ($cv!='')?$fecha_->getTimestamp()."_".$_FILES["cv"]["name"]:"";
  $tmp_cv=$_FILES["cv"]["tmp_name"];

  if($tmp_cv!=''){
    move_uploaded_file($tmp_cv,"./".$nombreArchivoCv);
  };

  $sentencia->bindParam(":foto",$nombreArchivoFoto);
  $sentencia->bindParam(":cv",$nombreArchivoCv);


  $sentencia->bindParam(":idPuesto",$idPuesto);
  $sentencia->bindParam(":fechaIngreso",$fechaIngreso);

  $sentencia->execute();

  $mensaje = 'Registro creado';
  header("location:index.php?mensaje=".$mensaje);
}

//traer el nombre de los puestos
$sentencia = $conexion->prepare("SELECT * FROM tbl_puestos");
$sentencia->execute();

$tbl_registro_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include("../../templates/header.php"); ?>

<br>

<div class="card">
    <div class="card-header">
        <h5>Datos del Empleado</h5>
    </div>
    <div class="card-body">


    <form action="" method="post" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="primerNombre" class="form-label">Primer Nombre</label>
          <input type="text"
            class="form-control" name="primerNombre" id="primerNombre" aria-describedby="helpId" placeholder="Primer Nombre">
        </div>

        <div class="mb-3">
          <label for="segundoNombre" class="form-label">Segundo Nombre</label>
          <input type="text"
            class="form-control" name="segundoNombre" id="segundoNombre" aria-describedby="helpId" placeholder="Segundo Nombre">
        </div>

        <div class="mb-3">
          <label for="primerApellido" class="form-label">Primer Apellido</label>
          <input type="text"
            class="form-control" name="primerApellido" id="primerApellido" aria-describedby="helpId" placeholder="Primer Apellido">
        </div>

        <div class="mb-3">
          <label for="segundoApellido" class="form-label">Segundo Apellido</label>
          <input type="text"
            class="form-control" name="segundoApellido" id="segundoApellido" aria-describedby="helpId" placeholder="Segundo Apellido">
        </div>

        <div class="mb-3">
          <label for="" class="form-label">Foto</label>
          <input type="file" class="form-control" name="foto" id="foto" placeholder="Foto" aria-describedby="fileHelpId">

        </div>

        <div class="mb-3">
          <label for="cv" class="form-label">CV: (PDF)</label>
          <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">

        </div>

        <div class="mb-3">
            <label for="idPuesto" class="form-label">Puesto:</label>
            <select class="form-select form-select-sm" name="idPuesto" id="idPuesto">
              <?php foreach($tbl_registro_puestos as $registro){?>
                <option value="<?php echo $registro["id"]?>">
                <?php echo $registro["nombre_puesto"]?></option>
              <?php }?>
            </select>
        </div>

        <div class="mb-3">
          <label for="fechaIngreso" class="form-label">Fecha de Ingreso:</label>
          <input type="date" class="form-control" name="fechaIngreso" id="fechaIngreso" aria-describedby="emailHelpId" placeholder="Fecha de Ingreso">

        </div>    
        
        <button type="submit" class="btn btn-success">Agregar registro</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>

    </div>

    <div class="card-footer text-muted">
    </div>

</div>

<?php include("../../templates/footer.php") ?>