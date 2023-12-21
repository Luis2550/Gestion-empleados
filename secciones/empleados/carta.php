<?php include("../../bd.php");

if(isset($_GET["txtID"])){
    $txtID = (isset($_GET["txtID"]))?$_GET["txtID"]:"";

    $sentencia = $conexion->prepare("SELECT *,(SELECT nombre_puesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.id_puesto limit 1) as puesto FROM tbl_empleados WHERE id= :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $primerNombre = $registro["primer_nombre"];
    $segundoNombre = $registro["segundo_nombre"];
    $primerApellido = $registro["primer_apellido"];
    $segundoApellido = $registro["segundo_apellido"];

    $nombreCompleto = $primerNombre." ".$segundoNombre." ".$primerApellido." ".$segundoApellido;

    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idPuesto = $registro["id_puesto"];
    $nombrePuesto = $registro["puesto"];
    $fechaIngreso = $registro["fecha_ingreso"];

    $fechaInicio = new DateTime($fechaIngreso);
    $fechaFin =  new DateTime(date("Y-m-d"));
    $diferencia = date_diff($fechaInicio,$fechaFin);

}

ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta Recomendacion</title>
</head>
<body>
    
    <h1>Carta de Recomendaciön Laboral</h1>
    <br/><br/>
    Mérida Yucatan, México a <strong><?php echo date('d-M-Y');?></strong>
    <br/><br/>
    A quien pueda interesar:
    <br/><br/>
    Reciba un cordial y respetuoso saludo.
    <br/><br/>
    A través de estas lineas deseo hacer de su conocimiento que Sr(a) <strong><?php echo $nombreCompleto?></strong>,
    quien laboró en mi organizaciön durante <strong> <?php echo $diferencia->y;?> año(s) </strong>
    es un ciudadano con una conducta intachable. Ha demostrado ser un gran trabajador,
    comprometido, responsable y fiel cumplidor de sus tareas.
    Siempre ha manifestado preocupaciön por mejorar, capacitarse y actualizar sus conocimientos.
    <br/><br/>
    Durante estos arios se ha desempeñado como: <strong><?php echo $nombrePuesto?> </strong>

</body>
</html>

<?php
$HTML = ob_get_clean();
require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf=new Dompdf();

$opciones = $dompdf->getOptions();
$opciones->set(array("isRemoteEnabled"=>true));

$dompdf->setOptions($opciones);

$dompdf->loadHtml($HTML);
// Se configura el tamaño del papel del PDF como carta ('letter').   
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));

?>