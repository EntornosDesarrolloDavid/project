<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">

	<!--BootStrap-->
	<!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>



	<link rel="stylesheet" type="text/css" href="/estilos/style.css" />
	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />
	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
</head>

<body>
	<div id="todo">
		<header>

			<article>
				<img src="/imagenes/aplicacion/logo.png" alt="">

			</article>
			<a name="top" href="#"><h1>Pokémon</h1></a>
			<article class="break"></article>
<?php

if (Sistema::app()->acceso()->hayUsuario()) {
	echo CHTML::dibujaEtiqueta("h6", [], "Entrenador ".Sistema::app()->acceso()->getNick());

}
else{
	echo CHTML::dibujaEtiqueta("h6", [], "Aún no ha iniciado sesión");
} 
?>

		</header><!-- #header -->


		<div class="contenido">


			<article id="interior">
				<?php echo $contenido; ?>
			</article><!-- #content -->

		</div>
		<footer>
			<p>All Content is © Copyright of Proyecto.net 1999-2022. |
				Pokémon and All Respective Names are Trademark & © of Nintendo 1996-2022 </p>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>