<?php

/**
 * Vista que permite el funcionamiento de la Pokédex generada en JS
 */

/**
 * Indicación de un fichero javascript para la creación de la vista
 */
$cadena = CHTML::scriptFichero(
	"/javascript/main.js",
	["defer" => "defer"]
);
$this->textoHead = $cadena;

?>

<?php
echo CHTML::iniciarForm();
if (isset($_SESSION["audio"])) {
	if ($_SESSION["audio"]) {
		echo CHTML::campoBotonSubmit("Desactivar Sonido", ["name" => "bAudio"]);
	} else echo CHTML::campoBotonSubmit("Activar Sonido", ["name" => "bAudio"]);
}
echo CHTML::finalizarForm();
?>

<audio loop <?php
			if (isset($_SESSION["audio"])) {
				if ($_SESSION["audio"]) {
					echo "autoplay";
				}
			}
			?>>
	<source src="/imagenes/aplicacion/main.mp3" type="audio/mp3">
	Your browser does not support the audio element.
</audio>
<?php
echo CHTML::dibujaEtiqueta("h1", [], "Pokédex", true);


echo CHTML::dibujaEtiqueta("section", ["id" => "pokemon-container"], "", true);

?>
<nav aria-label="Page navigation example">
	<ul class="pagination">
		<li class="page-item" id="previous"><a class="page-link" href="#">Previous</a></li>
		<li class="page-item" id="next"><a class="page-link" href="#">Next</a></li>
	</ul>

</nav>

<?php
echo CHTML::dibujaEtiqueta("p", ["id"=>"info"]);
echo CHTML::campoNumber("page","",["id"=>"page"]);
echo CHTML::botonHtml("¡Ir a Página!", ["id"=>"changePage"]);
echo "<br>";
echo CHTML::campoText("pokeSearch", "", ["id"=>"pokeSearch"]);
echo CHTML::botonHtml("¡Buscar Pokémon!", ["id"=>"poke"]);

?>
