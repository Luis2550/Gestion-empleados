<?php include("../../bd.php")?>

<?php 

    if(isset($_GET["txtID"])){
        $txtID = (isset($_GET["txtID"]))?$_GET["txtID"]:"";

        $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id= :id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();

        $registro = $sentencia->fetch(PDO::FETCH_LAZY);

        $primerNombre = $registro["primer_nombre"];
        $segundoNombre = $registro["segundo_nombre"];
        $primerApellido = $registro["primer_apellido"];
        $segundoApellido = $registro["segundo_apellido"];
        $foto = $registro["foto"];
        $cv = $registro["cv"];
        $idPuesto = $registro["id_puesto"];
        $fechaIngreso = $registro["fecha_ingreso"];
        

        $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos");
        $sentencia->execute();
        $tbl_registro_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    if($_POST){

        $txtID = (isset($_POST["txtID"]))?$_POST["txtID"]:"";
        $primerNombre = (isset($_POST["primerNombre"])?$_POST["primerNombre"]:"");
        $segundoNombre = (isset($_POST["segundoNombre"])?$_POST["segundoNombre"]:"");
        $primerApellido = (isset($_POST["primerApellido"])?$_POST["primerApellido"]:"");
        $segundoApellido = (isset($_POST["segundoApellido"])?$_POST["segundoApellido"]:"");
        $idPuesto = (isset($_POST["idPuesto"])?$_POST["idPuesto"]:"");
        $fechaIngreso = (isset($_POST["fechaIngreso"])?$_POST["fechaIngreso"]:"");

        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET 
        primer_nombre = :primerNombre,
        segundo_nombre = :segundoNombre,
        primer_apellido = :primerApellido,
        segundo_apellido = :segundoApellido,
        id_puesto = :idPuesto,
        fecha_ingreso = :fechaIngreso WHERE id = :txtID
        ");


        $sentencia->bindParam(":txtID",$txtID);
        $sentencia->bindParam(":primerNombre",$primerNombre);
        $sentencia->bindParam(":segundoNombre",$segundoNombre);
        $sentencia->bindParam(":primerApellido",$primerApellido);
        $sentencia->bindParam(":segundoApellido",$segundoApellido);
        $sentencia->bindParam(":idPuesto",$idPuesto);
        $sentencia->bindParam(":fechaIngreso",$fechaIngreso);

        $sentencia->execute();

        //actualizacion y reemplazo de fotos y cv

        $foto = (isset($_FILES["foto"]["name"])?$_FILES["foto"]["name"]:"");

        $fecha_ = new DateTime();
        $nombreArchivoFoto = ($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]["name"]:"";
        $tmp_foto=$_FILES["foto"]["tmp_name"];
      
        if($tmp_foto!=''){
          move_uploaded_file($tmp_foto,"./".$nombreArchivoFoto);

          //buscar el archivo a eliminar
          $sentencia =$conexion->prepare("SELECT foto FROM tbl_empleados WHERE id = :id");
          $sentencia->bindParam(":id",$txtID);
          $sentencia->execute();
          $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
  
          if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!=""){
              if(file_exists("./".$registro_recuperado["foto"])){
                  unlink("./".$registro_recuperado["foto"]);
              }
          }

          //----------------------------------

          $sentencia = $conexion->prepare("UPDATE tbl_empleados SET foto = :foto WHERE id=:id");
          $sentencia->bindParam(":foto",$nombreArchivoFoto);
          $sentencia->bindParam(":id",$txtID);
          $sentencia->execute();

        };


        $cv = (isset($_FILES["cv"]["name"])?$_FILES["cv"]["name"]:"");

        $nombreArchivoCv = ($cv!='')?$fecha_->getTimestamp()."_".$_FILES["cv"]["name"]:"";
        $tmp_cv=$_FILES["cv"]["tmp_name"];

        if($tmp_cv!=''){
          move_uploaded_file($tmp_cv,"./".$nombreArchivoCv);

        //buscar el archivo a eliminar
        $sentencia =$conexion->prepare("SELECT cv FROM tbl_empleados WHERE id = :id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!=""){
          if(file_exists("./".$registro_recuperado["cv"])){
              unlink("./".$registro_recuperado["cv"]);
          }
        }

          $sentencia = $conexion->prepare("UPDATE tbl_empleados SET cv = :cv WHERE id=:id");
          $sentencia->bindParam(":cv",$nombreArchivoCv);
          $sentencia->bindParam(":id",$txtID);
          $sentencia->execute();

        };

        $mensaje = 'Registro actualizado';
        header("location:index.php?mensaje=".$mensaje);
    };
?>

<?php include("../../templates/header.php"); ?>

<br>

<div class="card">
    <div class="card-header">
        <h5>Datos del Empleado (Editar)</h5>
    </div>
    <div class="card-body">


    <form action="" method="post" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="txtID" class="form-label">ID</label>
          <input type="text" value="<?php echo $txtID?>" readonly
            class="form-control" name="txtID" id="txtID" aria-describedby="helpId" placeholder="">
        </div>

        <div class="mb-3">
          <label for="primerNombre" class="form-label">Primer Nombre</label>
          <input type="text" value="<?php echo $primerNombre?>"
            class="form-control" name="primerNombre" id="primerNombre" aria-describedby="helpId" placeholder="Primer Nombre">
        </div>

        <div class="mb-3">
          <label for="segundoNombre" class="form-label">Segundo Nombre</label>
          <input type="text" value="<?php echo $segundoNombre?>"
            class="form-control" name="segundoNombre" id="segundoNombre" aria-describedby="helpId" placeholder="Segundo Nombre">
        </div>

        <div class="mb-3">
          <label for="primerApellido" class="form-label">Primer Apellido</label>
          <input type="text" value="<?php echo $primerApellido?>"
            class="form-control" name="primerApellido" id="primerApellido" aria-describedby="helpId" placeholder="Primer Apellido">
        </div>

        <div class="mb-3">
          <label for="segundoApellido" class="form-label">Segundo Apellido</label>
          <input type="text" value="<?php echo $segundoApellido?>"
            class="form-control" name="segundoApellido" id="segundoApellido" aria-describedby="helpId" placeholder="Segundo Apellido">
        </div>
        <!-- imagen -->
        <div class="mb-3">
          <label for="" class="form-label">Foto</label>
          <br>
          <img width="50" 

          <?php 
          
          ?>
          
          src="<?php echo $foto;?>" class="img-fluid rounded" alt="">
          <input type="file" class="form-control" name="foto" id="foto" placeholder="Foto" aria-describedby="fileHelpId">

        </div>

        <div class="mb-3">
          <label for="cv" class="form-label">CV: (PDF)</label>
          <br>
          CV: <a href="<?php echo $cv?>"> <?php echo $cv?></a>
          <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">

        </div>

        <div class="mb-3">
            <label for="idPuesto" class="form-label">Puesto:</label>
            <select class="form-select form-select-sm" name="idPuesto" id="idPuesto">
              <?php foreach($tbl_registro_puestos as $registro){?>
                <option <?php echo($idPuesto == $registro["id"])?"selected":"";?> value="<?php echo $registro["id"]?>">
                <?php echo $registro["nombre_puesto"]?></option>
              <?php }?>
            </select>
        </div>

        <div class="mb-3">
          <label for="fechaIngreso" class="form-label">Fecha de Ingreso:</label>
          <input type="date" value="<?php echo $fechaIngreso?>"
          class="form-control" name="fechaIngreso" id="fechaIngreso" aria-describedby="emailHelpId" placeholder="Fecha de Ingreso">

        </div>    
        
        <button type="submit" class="btn btn-success">Actualizar registro</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>

    </div>

    <div class="card-footer text-muted">
    </div>

</div>

<?php include("../../templates/footer.php") ?>