
<?php

//lectura de datos
include("../../bd.php");

// se utiliza para acceder a los datos enviados a través del método GET en una solicitud HTTP. 
//Los datos GET se pasan generalmente a través de la URL y se pueden usar para enviar información al servidor.

if(isset($_GET["txtID"])){
    $txtID = (isset($_GET["txtID"]))?$_GET["txtID"]:"";

    $sentencia = $conexion->prepare("DELETE FROM tbl_usuario WHERE id = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje = 'Registro eliminado';
    header("location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM `tbl_usuario`");
$sentencia->execute();
$lista_tbl_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

//lectura de datos
?>


<?php include("../../templates/header.php"); ?>

<br>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre de usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach($lista_tbl_usuarios as $registro){ ?>

                    <tr class="">
                        <td scope="row"><?php echo $registro["id"]?></td>
                        <td><?php echo $registro["usuario"]?></td>
                        <td><?php echo $registro["contrasenia"]?></td>
                        <td><?php echo $registro["correo"]?></td>
                        <td>
                            <a class="btn btn-primary" href="editar.php?txtID=<?php echo $registro["id"]?>" role="button">Editar</a>
                            <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro["id"];?>)" role="button">Eliminar</a>
                        </td>
                    </tr>

                    <?php }?>
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="card-footer text-muted">
    </div>
</div>

<?php include("../../templates/footer.php"); ?>
