<?php

/**
 * Vista que muestra la información de un Pokémon ya creado
 */

/**
 * Indicación de un fichero javascript para la creación de la vista
 */

$cadena = CHTML::scriptFichero(
    "/javascript/ver.js",
    ["defer" => "defer"]
);
$this->textoHead = $cadena;
echo CHTML::dibujaEtiqueta("article", ["class"=>"contenedorCentral"], "", false);
if ($respuesta["foto"]=="") {
    echo CHTML::imagen("/imagenes/fotosPokemon/noFoto.png");
}
else echo CHTML::imagen("/imagenes/fotosPokemon/".$respuesta["foto"]);
echo CHTML::dibujaEtiqueta("h2", [], $respuesta["nombre"]);
echo "<br>";
    echo CHTML::dibujaEtiqueta("p", [], "Vida" . " (" . $respuesta["vida"] . ")");
    echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $respuesta["vida"]], "", true);
    echo "<br>";

    echo CHTML::dibujaEtiqueta("p", [], "Ataque" . " (" . $respuesta["ataque"] . ")");
    echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $respuesta["ataque"]], "", true);
    echo "<br>";

    echo CHTML::dibujaEtiqueta("p", [], "Defensa" . " (" . $respuesta["defensa"] . ")");
    echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $respuesta["defensa"]], "", true);
    echo "<br>";

    echo CHTML::dibujaEtiqueta("p", [], "Ataque Especial" . " (" . $respuesta["ataque_especial"] . ")");
    echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $respuesta["ataque_especial"]], "", true);
    echo "<br>";

    echo CHTML::dibujaEtiqueta("p", [], "Defensa Especial" . " (" . $respuesta["defensa_especial"] . ")");
    echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $respuesta["defensa_especial"]], "", true);
    echo "<br>";

    echo CHTML::dibujaEtiqueta("p", [], "Velocidad" . " (" . $respuesta["velocidad"] . ")");
    echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $respuesta["velocidad"]], "", true);
    echo "<br>";
echo CHTML::dibujaEtiquetaCierre("article");