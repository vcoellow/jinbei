<?php
session_start();
include 'includes/header.php'
?>
<section>
	<div class="interior">
		<article>
			<h1>Gracias por su cotización.</h1>
			<p>Estimado(a) <?php echo $_SESSION['s_nombre'].' '.$_SESSION['s_apellido'] ?>,<br>
				<br>
				Hemos recibido su cotización. Agradecemos su preferencia.<br>
				Le contactaremos a la brevedad.</p>
			<br>
			<p>Le saluda,<br>
				Equipo Jinbei.</p>
		</article>
	</div>
</section>
<?php
include 'includes/footer.php'
?>