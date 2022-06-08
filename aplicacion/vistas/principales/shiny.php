<?php

/**
 * Vista que permite la búsqueda de Pokémon Shinies
 */

/**
 * Indicación de un fichero javascript para la creación de la vista
 */
$cadena = CHTML::scriptFichero(
  "/javascript/shiny.js",
  ["defer" => "defer"]
);
$this->textoHead = $cadena;

echo CHTML::dibujaEtiqueta("h2", [], "Elija una Generación y posteriormente un Pokémon");

echo CHTML::campoRadioButton("gen", false, ["value"=>1, "etiqueta"=>"Primera Generación", "id"=>"primera"]);
echo "<br>";
echo CHTML::campoRadioButton("gen", false, ["value"=>2, "etiqueta"=>"Segunda Generación", "id"=>"segunda"]);
echo "<br>";
echo CHTML::campoRadioButton("gen", false, ["value"=>3, "etiqueta"=>"Tercera Generación", "id"=>"tercera"]);
echo "<br>";
echo CHTML::campoRadioButton("gen", false, ["value"=>4, "etiqueta"=>"Cuarta Generación", "id"=>"cuarta"]);
echo "<br>";
echo CHTML::campoRadioButton("gen", false, ["value"=>5, "etiqueta"=>"Quinta Generación", "id"=>"quinta"]);
echo "<br>";
echo CHTML::campoRadioButton("gen", false, ["value"=>6, "etiqueta"=>"Sexta Generación", "id"=>"sexta"]);
echo "<br>";
echo CHTML::campoRadioButton("gen", false, ["value"=>7, "etiqueta"=>"Séptima Generación", "id"=>"septima"]);
echo "<br>";
echo CHTML::campoRadioButton("gen", false, ["value"=>8, "etiqueta"=>"Octava Generación", "id"=>"octava"]);
echo "<br>";
// echo CHTML::dibujaEtiqueta("p", [], $_SESSION["intentos"][Sistema::app()->acceso()->getNombre()]["intentos"])

?>
<!--Al ser un popover da problemas si lo hago con CHTML-->
<button type="button" id="popoverShiny" class="btn btn-lg btn-danger" data-bs-toggle="popover" title="Funcionamiento">¿Cómo funciona el minijuego?</button>

<?php

echo CHTML::imagen("", "Poké", ["id" => "imgShiny"]);
echo CHTML::dibujaEtiqueta("article", ["id"=>"divBotones"], "", false);
echo CHTML::dibujaEtiqueta("p", ["id"=>"pVidasActuales"],"");

echo CHTML::botonHtml("¡Suma Encuentros!", ["id"=>"encuentros"]);
echo CHTML::dibujaEtiqueta("p", ["id"=>"pContador"],"");

echo CHTML::dibujaEtiqueta("p", ["id"=>"pResultado"],"");
echo CHTML::dibujaEtiqueta("p", ["id"=>"dateReset"], "");

echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::botonHtml("Volver al Inicio", ["href"=>"#top", "title"=>"top", "id"=>"myBtn"]);


?>

