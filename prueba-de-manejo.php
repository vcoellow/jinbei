<?php
include 'includes/header.php'
?>
<section>
	<div class="interior"><span class="titulo">
		<h1>Solicite su prueba de manejo:</h1>
		</span>
		<form action="envio.php" method="post" name="form" id="form" class="formulario">
			<div class="col-form-izq">
				<input type="text" placeholder="Nombre*" id="Nombre" name="nombre">
				<input type="text" placeholder="Email*" id="Email" name="email">
				<input type="text" placeholder="Teléfono*" id="Telefono" name="telefono">
			</div>
			<div class="col-form-der">
				<textarea placeholder="Mensaje*" id="Mensaje" name="mensaje"></textarea>
			</div>
			<input type="submit" value="ENVIAR">
		</form>
		<p>(*) Campos obligatorios<br>
			Nota: El envío de esta información implica que usted está aceptando los <span class="legal"><a href="politicas-de-privacidad.php">aspectos legales y políticas de privacidad</a></span> de este sitio web.</p>
	</div>
</section>
<?php
include 'includes/footer.php'
?>