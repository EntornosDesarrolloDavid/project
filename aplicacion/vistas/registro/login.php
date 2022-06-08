<?php
/**
 * Vista que permite realizar el login en la página
 */

echo CHTML::dibujaEtiqueta("h1", [], "Iniciar Sesión");
echo "<br>";



/**
 * Formulario encargado de realizar un login
 */


echo CHTML::iniciarForm();

echo CHTML::modeloErrorSumario($modelo, array("class" => "error"));
echo "<br>";

echo CHTML::modeloLabel($modelo, "nick");
echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo CHTML::modeloText(
    $modelo,
    "nick",
    array("maxlength" => 20, "size" => 21)
);
echo "<br>";
echo CHTML::modeloLabel($modelo, "password");
echo "&nbsp";
echo CHTML::modeloPassword(
    $modelo,
    "password",
    array("maxlength" => 20, "size" => 21)
);
echo "<br>";

echo CHTML::campoBotonSubmit("Iniciar Sesión", ["id"=>"bLogin"]);
echo "<br>";

echo CHTML::link("¿No tienes una Cuenta? Regístrate", array("registro", "register"));
echo CHTML::finalizarForm();
