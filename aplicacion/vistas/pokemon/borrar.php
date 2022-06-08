<?php

/**
 * Vista que pide la confirmación del borrado del Pokémon
 */
echo CHTML::dibujaEtiqueta("article", ["class"=>"contenedorCentral"], "", false);

echo CHTML::dibujaEtiqueta("h1", [], "¿Estás seguro de que quieres borrar al Pokémon $respuesta[nombre]?");

echo CHTML::iniciarForm();

if ($respuesta["foto"]=="") {
    echo CHTML::imagen("/imagenes/fotosPokemon/noFoto.png");
}
else echo CHTML::imagen("/imagenes/fotosPokemon/".$respuesta["foto"]);echo "<br>";
echo CHTML::campoBotonSubmit("Borrar", array("name"=>"borrar"));

echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("article");