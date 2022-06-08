<?php

/**
 * Vista que permite asignar uno o dos tipos a un Pokémon
 */

echo CHTML::dibujaEtiqueta("h1", [], "Elige Tipos de este Pokémon");
echo "<br>";

/**
 * Indicación de un fichero javascript para la creación de la vista
 */
$cadena = CHTML::scriptFichero(
    "/javascript/pokeInventado.js",
    ["defer" => "defer"]
);
$this->textoHead = $cadena;
/**
 * Formulario encargado de realizar un login
 */


echo CHTML::iniciarForm();

echo CHTML::modeloErrorSumario($modelo, array("class" => "error"));
echo "<br>";

echo CHTML::modeloLabel($modelo, "cod_tipo1");
echo CHTML::modeloListaDropDown($modelo, "cod_tipo1", Tipo::dameTipos());
echo "<br>";echo "<br>";
echo CHTML::modeloLabel($modelo, "cod_tipo2");

echo CHTML::modeloListaDropDown($modelo, "cod_tipo2", Tipo::dameTipos());
echo "<br>";echo "<br>";

echo CHTML::campoBotonSubmit("Elegir tipos", ["id"=>"bLogin"]);
echo "<br>";

echo CHTML::finalizarForm();
