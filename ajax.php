<?php
session_start();
require_once('database.php');
$conexion = new mysql();
$Oper = (isset($_REQUEST['oper'])) && $_REQUEST['oper']!='' ? $_REQUEST['oper'] : '';
$departamento = (isset($_REQUEST['departamento'])) && $_REQUEST['departamento']!='' ? $_REQUEST['departamento'] : '';
$provincia = (isset($_REQUEST['provincia'])) && $_REQUEST['provincia']!='' ? $_REQUEST['provincia'] : '';
switch($Oper){
case 'cargarProvincia' : echo Cprovincia(); break;
case 'cargarDistrito' : echo Cdistrito(); break;
case 'doRegistrarCotizacion' : echo doRegistrarCotizacion(); break;
}
function Cprovincia(){
global $departamento;
global $conexion;
$query = "SELECT Descripcion,ProvinciaId FROM Provincia where RegionId = ".$departamento.";";
$rs = $conexion->query($query);
//print_r($rs);
//$html.='<select name="provincia" id="provincia" onchange="Distrito();">"';
$html= '<option value="1" selected="selected">Seleccione Provincia</option> ';
foreach($rs as $row){
$html.= '<option value="'.$row['ProvinciaId'].'">'.$row['Descripcion']."</option>\n";
}
//$html.="</select>";
return $html;
}
function Cdistrito(){
global $provincia;
global $conexion;
$query = "SELECT ComunaId,Descripcion FROM Comuna WHERE ProvinciaId = ".$provincia.";";
$rs = $conexion->query($query);
//print_r($rs);
//$html.="<select name='distrito' id='distrito'>";
$html = '<option value="1" selected="selected">Seleccione Distrito</option>';
foreach($rs as $row){
$html.= '<option value="'.$row['ComunaId']."\">".$row['Descripcion']."</option>";
}
//$html.="</select>";
return $html;
}
/*WSPeru*/
function doRegistrarCotizacion(){
$distritoID = (isset($_REQUEST['departamento'])) && $_REQUEST['distrito']!='' ? $_REQUEST['distrito'] : '';
global $conexion;
/*$query = "select ComunaIdGildemeister as distrito, CodigoAG as provincia, regionIdAG as departamento from Comuna
left join Provincia on Comuna.ProvinciaId = Provincia.ProvinciaId
left join Region on Comuna.RegionId = Region.RegionId where ComunaId = ".$distritoID.";";
$rs = $conexion->query($query);
$distrito = isset($rs[0]['distrito']) && $rs[0]['distrito']!='' ? $rs[0]['distrito'] : '';
$provincia = isset($rs[0]['provincia']) && $rs[0]['provincia']!='' ? $rs[0]['provincia'] : '';
$departamento = isset($rs[0]['departamento']) && $rs[0]['departamento']!='' ? $rs[0]['departamento'] : '';*/
$idModelo		= (isset($_REQUEST['idmodelo'])) && $_REQUEST['idmodelo']!='' ? $_REQUEST['idmodelo'] : '';
$nombreModelo	= $idModelo === '77' ? 'haise' : 'h2l';
$Comentarios	= (isset($_REQUEST['mensaje'])) && $_REQUEST['mensaje']!='' ? $_REQUEST['mensaje'] : '';
$idMarca		= '13';
$nombreMarca 	= 'Jinbei';
$origen			= '11';
$usuario_crea	= '';
$usuario_red	= '';
$estacion_red	= '';
$canal_internet	= '0';
$documento		= (isset($_REQUEST['identificacion'])) && $_REQUEST['identificacion']!='' ? $_REQUEST['identificacion'] : '';
$numero			= (isset($_REQUEST['numero'])) && $_REQUEST['numero']!='' ? $_REQUEST['numero'] : '';
$nombre			= (isset($_REQUEST['nombre'])) && $_REQUEST['nombre']!='' ? $_REQUEST['nombre'] : '';
$APaterno		= (isset($_REQUEST['aPaterno'])) && $_REQUEST['aPaterno']!='' ? $_REQUEST['aPaterno'] : '';
$telefono		= (isset($_REQUEST['telefono'])) && $_REQUEST['telefono']!='' ? $_REQUEST['telefono'] : '';
$celular		= '0';
$correo			= (isset($_REQUEST['email'])) && $_REQUEST['email']!='' ? $_REQUEST['email'] : '';
$direccion		= (isset($_REQUEST['direccion'])) && $_REQUEST['direccion']!='' ? $_REQUEST['direccion'] : '';
$distrito		= (isset($_REQUEST['distrito'])) && $_REQUEST['distrito']!='' ? $_REQUEST['distrito'] : '';
$provincia		= (isset($_REQUEST['provincia'])) && $_REQUEST['provincia']!='' ? $_REQUEST['provincia'] : '';
$departamento	= (isset($_REQUEST['departamento'])) && $_REQUEST['departamento']!='' ? $_REQUEST['departamento'] : '';
//buscar los códigos internos de motormundo para distrito, provincia, departamenteo
$query = "select Comuna.ComunaIdGildemeister as distrito, Provincia.CodigoAG as provincia , Region.regionIdAG as departamento from Comuna
left join Provincia on Comuna.ProvinciaId = Provincia.ProvinciaId
left join Region on Comuna.RegionId = Region.RegionId where ComunaId = ".$_POST["distrito"].";";
$rs = $conexion->query($query); 
$distrito = isset($rs[0]['distrito']) && $rs[0]['distrito']!='' ? $rs[0]['distrito'] : '';
$provincia = isset($rs[0]['provincia']) && $rs[0]['provincia']!='' ? $rs[0]['provincia'] : '';
$departamento = isset($rs[0]['departamento']) && $rs[0]['departamento']!='' ? $rs[0]['departamento'] : '';
if(strlen($distrito)==1)$distrito="0".$distrito;
if(strlen($provincia)==1)$provincia="0".$provincia;
if(strlen($departamento)==1)$departamento="0".$departamento;
$fechaNacimiento = '';
$acepto = (isset($_REQUEST['acepto'])) && $_REQUEST['acepto']!='' ? $_REQUEST['acepto'] : '';
$decision = (isset($_REQUEST['decision'])) && $_REQUEST['decision']!='' ? $_REQUEST['decision'] : '';
$params = array('oContactoBE' => array(
'co_origen'=>(int)$origen,
'co_tipo_documento' =>(string)$documento,
'co_usuario_crea' =>'',
'coddist' =>(string)$distrito,
'coddpto' =>(string)$departamento,
'codprov' =>(string)$provincia,
'fe_nacimiento' =>'00/00/0000',
'nid_contacto_canal_internet' => 0,
'no_ape_mat' => '',
'nid_marca' =>(int)$idMarca,
'nid_modelo' =>(int)$idModelo,
'no_ape_pat' =>(string)$APaterno,
'no_contacto' =>(string)$nombre,
'no_correo' =>(string)$correo,
'no_direccion' =>'',
'no_estacion_red' =>'',
'no_marca' =>(string)$nombreMarca,
'no_modelo' =>(string)$nombreModelo,
'no_usuario_red' =>'',
'nu_celular' =>'',
'nu_documento' =>(string)$numero,
'nu_telefono' =>(string)$telefono,
"no_valor_adic" => '',
'tx_comentario' =>(string)$Comentarios,	
'no_plazo_compra' =>(string)$decision,
'fl_recibir_info' =>(string)$acepto==='S'?'1':'0'
));
$respuesta;
$soap;
try{ 
$soap = new SoapClient('http://sgaservicioext64.agperu.net/wsMantenimientoAGP.svc?wsdl', array('trace' => 1));
$respuesta = $soap->InsertarContacto($params);
} catch (SoapFault $exception) {
$exception->getMessage();
}
$codwsdl = $respuesta->InsertarContactoResult;
$para = "jsacop@agildemeister.com.pe";//
$nom_email = "Contacto Jinbei";
$sujeto = "Formulario de Cotización";
$sujeto2 = "Confirmación de cotización Jinbei.pe";
/*se construye el encabezado del correo*/
/*encabezado del formulario para info*/
$encabezado = "From: ".$nombre." ".$APaterno." <".$correo.">";
//$encabezado .= "\nBcc: ".$email_web; //copia oculta
$encabezado .= "\nReply-To: ".$correo;
$encabezado .= "\nX-Mailer: PHP/" . phpversion();
$encabezado2 = "From: $nom_email <$para>";
$encabezado2 .= "\nReply-To: $para";
$encabezado2 .= "\nX-Mailer: PHP/" . phpversion();
//captura la IP del que envió el mensaje
//$ip = $REMOTE_ADDR;
/*switch ($_POST["identificacion"]) {
case 1:
$identificaccion = "DNI";
break;
case 2:
$identificaccion = "PASAPORTE";
break;
case 3:
$identificaccion = "RUC";
break;
case 4:
$identificaccion = "CE";
break;
case 5:
$identificaccion = "CI";
break;
case 6:
$identificaccion = "OTROS";
break; 
}*/
if($acepto === 'S'){
$acepto = 'Sí';
}elseif($acepto === 'N'){
$acepto = 'No'	;
}
$query = "select Comuna.Descripcion as distrito, Provincia.Descripcion as provincia , Region.Descripcion as departamento from Comuna
left join Provincia on Comuna.ProvinciaId = Provincia.ProvinciaId
left join Region on Comuna.RegionId = Region.RegionId where ComunaId = ".$_POST["distrito"].";";
$rs = $conexion->query($query);
$DistritoN = isset($rs[0]['distrito']) && $rs[0]['distrito']!='' ? $rs[0]['distrito'] : '';
$ProvinciaN = isset($rs[0]['provincia']) && $rs[0]['provincia']!='' ? $rs[0]['provincia'] : '';
$DepartamentoN = isset($rs[0]['departamento']) && $rs[0]['departamento']!='' ? $rs[0]['departamento'] : '';
$mensaje = "Identificacción: ".$codwsdl;
$mensaje .= "\nModelo: ".$nombreModelo;
$mensaje .= "\nNumero: ".$numero;
$mensaje .= "\nNombre: ".$nombre;
$mensaje .= "\nApellido Paterno: ".$APaterno;
$mensaje .= "\nDepartamento: ".$DepartamentoN;
$mensaje .= "\nProvincia: ".$ProvinciaN;
$mensaje .= "\nDistrito: ".$DistritoN;
$mensaje .= "\nEmail: ".$correo;
$mensaje .= "\nTeléfono: ".$telefono;
$mensaje .= "\nLa decisión de compra la efectuará dentro de los próximos: ".$decision;
$mensaje .= "\nDesea recibir información: ".$acepto;
$mensaje .= "\nComentario: ".$Comentarios;
//$mensaje .= "\n\nIP origen mensaje: $ip\n";
$_SESSION['s_nombre'] = $nombre;
$_SESSION['s_apellido'] = $APaterno;
if(mail($correo, $sujeto2, $mensaje, $encabezado2)){
    echo json_encode(array($soap->InsertarContacto($params)));
    exit();
}else{
    echo json_encode(array('type' => 'error', 'msg' => 'Correo ingresado no está registrado.'));
    exit();
}
}