<?php
include 'includes/header.php';
require('PHPmailer/class.phpmailer.php'); //ARCHIVOS QUE DEBEN IR EN LA RAIZ DEL SITIO
require('PHPmailer/class.smtp.php'); //ARCHIVOS QUE DEBEN IR EN LA RAIZ DEL SITIO
//BLOQUE 1: CAMPOS QUE TIENE EL FORMULARIO, LOS MISMOS QUE DEBE TENER EL HTML
$nombre = $_POST["nombre"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$mensaje = $_POST["mensaje"];
//________________________________________________
$mail = new PHPMailer();
//BLOQUE 2: CUERPO DEL FORMULARIO QUE SE ENVÍA (CAMPOS IGUALES AL ANTERIOR) LOS 2 SE NECESITAN (BLOQUE 1 Y 2)
$body .= "<p>Nombre:$nombre</p><br/>";
$body .= "<p>Email: $email</p><br/>";
$body .= "<p>Teléfono: $telefono</p><br/>";
$body .= "<p>Mensaje: $mensaje</p><br/>";
//________________________________________________
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = "localhost";
$mail->From = "jsacop@agildemeister.com.pe"; //NO SE DEBE MODIFICAR, AUTENTICACIÓN DE MAIL PERUANO
$mail->FromName = "Jinbei Perú"; //INDICAR NOMBRE DEL SITIO
$mail->Subject = "Contacto Jinbei Perú"; //ASUNTO DEL MAIL
$mail->MsgHTML($body);
$mail->AddAddress("jsacop@agildemeister.com.pe"); //MAIL AL QUE LLEGA
if(!$mail->Send()){
include 'error.php';
}else{
include 'prueba-de-manejo-gracias.php';
}
include 'includes/footer.php';
?>