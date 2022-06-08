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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity=
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous">
    </script>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous">
    </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous">
    </script>  

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
			<a name="top" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/principales/index">
				<h1>Pokémon</h1>
			</a>
			<article class="break"></article>
			<?php

			if (Sistema::app()->acceso()->hayUsuario()) {
				echo CHTML::dibujaEtiqueta("h6", [], "Entrenador " . Sistema::app()->acceso()->getNick());
			} else {
				echo CHTML::dibujaEtiqueta("h6", [], "Aún no ha iniciado sesión");
			}
			?>
			<button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
				<img src="/imagenes/aplicacion/icons8-menu-64.png" alt="">
				<!-- <p>Menú</p> -->
			</button>
			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
				<div class="offcanvas-header">
					<h1 id="offcanvasRightLabel">¡Bienvenido a Pokémon!</h1>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">

					<div class="container">

						<div class="d-grid gap-2">
							<a class="btn btn-primary" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/registro/login">Login</a>
							<a class="btn btn-primary" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/registro/register">Registrarse</a>
							<?php

							if (Sistema::app()->acceso()->hayUsuario()) {
								if (Sistema::app()->acceso()->puedePermiso(2)) {
							?>
									<a class="btn btn-primary" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/usuarios/indice">Crud Usuarios</a>
									<a class="btn btn-primary" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/pokemon/indice">Crud Pokémon</a>

								<?php
								}
								?>
								<a class="btn btn-primary" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/registro/CerrarSesion">Cerrar Sesión</a>

							<?php
							}
							?>
						</div>
					</div>

				</div>
			</div>
		</header><!-- #header -->

		<?php

		if (!Sistema::app()->acceso()->hayUsuario()) {
			$menu = new CMenu(array("¡Consulta la Pokédex!", "¡Adivina el Texto!"), array(["principales", "pokedex"], ["principales", "adivinar"]));
		}
		if (Sistema::app()->acceso()->puedePermiso(1)) {
			$menu = new CMenu(array("¡Consulta la Pokédex!", "Simula un Combate", "¡Busca Shinies!", "¡Adivina el Texto!"), array(["principales", "pokedex"], ["combate", "combate"], ["principales", "shiny"], ["principales", "adivinar"]));
		}
		if (Sistema::app()->acceso()->puedePermiso(1) && Sistema::app()->acceso()->puedePermiso(5)) {
			$menu = new CMenu(array("¡Consulta la Pokédex!", array("Combates", ["Gestionar mi equipo", "combate", "pokemonList"],["Combates", "combate", "Combate"], ["Administrar Pokémon", "pokemon", "indice"]), "¡Busca Shinies!", "¡Adivina el Texto!"), array(["principales", "pokedex"], ["combate", "combate"], ["principales", "shiny"], ["principales", "adivinar"]));
		}

		echo $menu->dibujate();
		?>


		<main class="contenido">


			<article id="interior">
				<?php echo $contenido; ?>
			</article><!-- #content -->

		</main>
		<footer name="bottom">
			<p>All Content is © Copyright of Proyecto.net 1999-2022. |
				Pokémon and All Respective Names are Trademark & © of Nintendo 1996-2022 </p>
			<?php
				if (isset($_COOKIE["API"])) {
					echo CHTML::dibujaEtiqueta("p",[],"Information from ".$_COOKIE["API"]);
				}

			?>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>