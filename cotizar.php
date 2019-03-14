<?php
include 'includes/header.php'
?>
<?php
require_once('database.php');
$conexion = new mysql();
function Cdepartamento(){
global $conexion;
$query = "SELECT Descripcion,RegionId FROM Region;";
$rs = $conexion->query($query);
 $html='';
foreach($rs as $row){
$html.= '<option value="'.$row['RegionId']."\">".$row['Descripcion'].'</option> ';
}
return $html;
}
function Cprovincia(){	
global $conexion;
$query = "SELECT Descripcion,ProvinciaId FROM Provincia where ProvinciaId = 1;";
$rs = $conexion->query($query);
$html ='<select name="provincia" id="provincia" onchange="Distrito();">';
foreach($rs as $row)
{
$html.= '<option value="'.$row['ProvinciaId']."\">".$row['Descripcion']."</option>\n";
}
$html.="</select>";
return $html;
}
function Cdistrito(){	
global $conexion;
$query = "SELECT ComunaId,Descripcion FROM Comuna WHERE ComunaId = 1;";
$rs = $conexion->query($query);
$html="<select name=\"distrito\" id=\"distrito\" >";
foreach($rs as $row){
$html.= '<option value="'.$row['ComunaId']."\">".$row['Descripcion']."</option>\n";
}
$html.="</select>";
return $html;
}
$server = $_SERVER['HTTP_HOST'];
$NombreModelo = 'jinbei.pe/';
$NombreModelo = str_replace($server, '',$NombreModelo);
$NombreModelo = str_replace('http:///', '',$NombreModelo);
$NombreModelo = str_replace('.html', '',$NombreModelo);
$NombreModelo = str_replace("-"," ",$NombreModelo);
if($NombreModelo=='minibus'){
$NombreModelo='minibus haise';
}else{
$NombreModelo = $NombreModelo;
}
$modelos=array(77=>'Minibus Haise',248=>'Minibus H2L');
$aKey= array_keys($modelos);
$IdModelo = array_search($NombreModelo, $modelos);?>
<script language="javascript">
function Provincia(){
var departamento = $("#departamento").val();
$.post("ajax.php",{
'oper' :'cargarProvincia',
'departamento' : departamento
},function(data){
$("#provincia").html(data);
});
}
function Distrito(){
var provincia = $("#provincia").val();
$.post("ajax.php",{
'oper' :'cargarDistrito',
'provincia' : provincia
},function(data){
//alert(data);
$("#distrito").html(data);
});
}
</script>
<section>
	<div class="interior-cotizar"> <span class="titulo">
		<h1>Cotizar <?php echo strtoupper(trim($_GET['marca']))?></h1>
		</span>
		<div class="seleccion-modelo"> <img src="assets/img/<?php echo trim($_GET['marca']) ?>-cotizar.png"/> <a href="<?php 
  if($_GET['marca'] === 'haise'){
  echo 'cotizar.php?cod=248&marca=h2l';
  }else{
  echo 'cotizar.php?cod=77&marca=haise';
  }
 ?>"class="btn-version">Cambiar Minibús</a> </div>
		<form class="formulario" id="form-id">
			<div class="col-form-izq">
				<label>
					<select id="identificacion" name="identificacion">
						<option value="0" selected>Seleccione Identificación*</option>
						<option value="0001">DNI</option>
						<option value="0003">RUC</option>
						<option value="0004">CE</option>
						<option value="0002">PASAPORTE</option>
					</select>
					<input type="hidden" value="<?php echo $_GET['cod'] ?>" id="idmodelo" />
				</label>
			</div>
			<div class="col-form-der">
				<label>
					<input placeholder="Ingrese su número*" name="numero" type="text" id="numero" />
				</label>
			</div>
			<div class="col-form-izq">
				<label>
					<input placeholder="Nombres*" name="nombre" type="text" id="nombre" />
				</label>
			</div>
			<div class="col-form-der">
				<label>
					<input placeholder="Apellidos*" name="aPaterno" type="text" id="aPaterno" />
				</label>
			</div>
			<div>
			<select name="departamento" id="departamento" onchange="Provincia();">
				<div>
				<?php echo Cdepartamento(); ?>
				</div>
			</select>
			<div class="col-form-izq">
				<div> <?php echo Cprovincia(); ?> </div>
			</div>
			<div class="col-form-der">
				<div> <?php echo Cdistrito(); ?> </div>
			</div>
			<div class="col-form-izq">
				<label>
					<input placeholder="Email*" name="email" type="text" id="email" />
				</label>
			</div>
			<div class="col-form-der">
				<label>
					<input placeholder="Confirmar Email*" type="text" id="email2" />
				</label>
			</div>
			<div>
				<label>
					<input placeholder="Teléfono*" name="telefono" type="text" id="telefono" />
				</label>
			</div>
			<div>
				<label>
					<textarea placeholder="Comentario*" name="mensaje" id="mensaje"></textarea>
				</label>
			</div>
			<div>
				<div class="col-form-izq">La decisión de compra la efectuará dentro de los próximos:</div>
				<div>
					<label>
						<select id="decision" name="decision">
							<option value="HOY">HOY</option>
							<option value="1 MES" selected>1 MES</option>
							<option value="3 MESES">3 MESES</option>
						</select>
					</label>
				</div>
			</div>
			<div>
				<p>
					<input type="radio" name="acepto" id="si" value="1" checked="checked">
					Acepto recibir información comercial en el futuro de Motormundo.</p>
				<p>
					<input type="radio" name="acepto" id="no" value="0">
					No deseo recibir información comercial en el futuro de Motormundo salvo la solicitud realizada.</p>
			</div>
			<input name="Enviar" id="Enviar" type="submit" value="ENVIAR"/>
		</form>
		<p>(*) Campos obligatorios<br>
			Nota: El envío de esta información implica que usted está aceptando los <span class="legal"><a href="politicas-de-privacidad.php">aspectos legales y políticas de privacidad</a></span> de este sitio web.</p>
	</div>
</section>
<script>
function Ws_envio(){
var idmodelo	= $('#idmodelo').val();
var modelos					= new Array("<?php echo implode('","',$modelos)?>");
var identificacion			= $("#identificacion").val();
var numero					= $("#numero").val();
var nombre					= $("#nombre").val();
var aPaterno					= $("#aPaterno").val();
var direccion				= $("#direccion").val();
var departamento				= $("#departamento").val();
var provincia				= $("#provincia").val();
var distrito					= $("#distrito").val();
var telefono					= $("#telefono").val();
var email					= $("#email").val();
var mensaje					= $("#mensaje").val();
var decision					= $("#decision").val();
var acepto					= $("#acepto").val();
var decision					= $("#decision").val();
if($("#si:checked").val()=='1'){
var acepto = "S";
}else if($("#no:checked").val()=='0'){
var acepto = "N";
} 
$.ajax({
	url: "ajax.php",
	data:{
		'oper'					: 'doRegistrarCotizacion',
		'idmodelo'				: idmodelo,
		'identificacion'		: identificacion,
		'numero'					: numero,
		'nombre'					: nombre,
		'aPaterno'				: aPaterno,
		'direccion'				: direccion,
		'departamento'			: departamento,
		'provincia'				: provincia,
		'distrito'				: distrito,
		'telefono'				: telefono,
		'email'					: email,
		'mensaje'				: mensaje,
		'acepto'					: acepto,
		'decision'				: decision
	},
	dataType:'json',
	type:'POST',
	cache: false,
	success: function(data){
		if(data){
			document.location.href="gracias-por-cotizar.php";
		}else{
			document.location.href="error.php";
		}
	},
	error: function(data, textStatus, errorThrown){
		console.log(data);
		console.log(textStatus);
		console.log(errorThrown);
	}
});
}
document.getElementById('form-id').onsubmit = function(e) {
	e.preventDefault();
	e.stopImmediatePropagation();
function validar_email(Email){
var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
if(filter.test(Email)){
return true;
}else{
return false;
}
}
var idmodelo					= $("#idmodelo").val();
var identificacion			= $("#identificacion").val();
var numero					= $("#numero").val();
var nombre					= $("#nombre").val();
var direccion				= $("#direccion").val();
var departamento				= $("#departamento").val();
var provincia				= $("#provincia").val();
var distrito					= $("#distrito").val();
var telefono					= $("#telefono").val();
var email					= $("#email").val();
var mensaje					= $("#mensaje").val();
var email2 					= $('#email2').val();
if(identificacion == 0 ){
alert('Ingrese identificación, por favor.')
return false
}if(identificacion==3 && numero.length!=11){
alert('RUC no válido.')
return false
}if(identificacion==1 && numero.length!=8){
alert('DNI no válido.')
return false
}
if(nombre=="") {
alert('Ingrese su nombre, por favor.')
return false
}
if(aPaterno=="") {
alert('Ingrese su apellido, por favor.')
return false
}
if(direccion=="") {
alert('Ingrese dirección, por favor.')
return false
}
if(departamento==1){
alert('Ingrese departamento, por favor.')
return false
}
if(provincia==1){
alert('Ingrese provincia, por favor.')
return false
}
if(distrito==1){
alert('Ingrese distrito, por favor.')
return false
}
if(telefono==""){
alert('Ingrese teléfono, por favor.')
return false
}
if(email==""){
alert('Ingrese email, por favor.');
return false;
}else if(!validar_email(email)){
alert('Email no válido.');
return false;
}
if(mensaje==""){
alert('Ingrese comentario, por favor.')
return false
}
if(email !== email2){
alert('El correo de confirmación no coincide con su email actual.')
return false
}
$("#botones").hide();
$("#mensanjeEnvio").show();
//comprueba campos de teléfonos (permite campos vacíos y guiones)
/*if( !er_telefono.test(telefono) ) {
alert('El número de teléfono no es válido.')
return false
}
comprueba campo de email
if(!er_email.test(email)) {
alert('El email no es válido.')
return false
}*/
/*if (document.calform.mensaje.value.length==0){
alert("Ingrese mensaje.")
return false
}*/
Ws_envio();
//document.calform.action='envio_cotizar.php';
//document.calform.method='POST';
//document.calform.submit();
};
</script>
<?php
include 'includes/footer.php'
?>