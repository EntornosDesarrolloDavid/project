<?php

/**
 * Vista que permite registrarse por primera vez en la página
 */
$cadena=CHTML::scriptFichero("/javascript/register.js",
["defer"=>"defer"]);
$this->textoHead=$cadena;

/**
 * Formulario encargado de realizar un login
 */

echo CHTML::dibujaEtiqueta("h1", [], "Registro", true);

echo CHTML::iniciarForm("", "post", ["id"=>"formRegister"]);
echo CHTML::modeloErrorSumario($modelo, array("class" => "error"));
echo "<br>";



echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText(
    $modelo,
    "nombre",
    array("maxlength" => 20, "size" => 21)
);



echo "<br>";




echo CHTML::modeloLabel($modelo, "nick");
echo CHTML::modeloText(
    $modelo,
    "nick",
    array("maxlength" => 20, "size" => 21)
);




echo "<br>";



echo CHTML::modeloLabel($modelo, "contrasenia");
echo CHTML::modeloPassword(
    $modelo,
    "contrasenia",
    array("maxlength" => 20, "size" => 21)
);


echo CHTML::modeloLabel($modelo, "confirmar_contrasenia");
echo "&nbsp";
echo CHTML::modeloPassword(
    $modelo,
    "confirmar_contrasenia",
    array("maxlength" => 30, "size" => 31)
);
echo "<br>";

echo CHTML::dibujaEtiqueta("h3",[], "Elige un Sprite");

echo CHTML::modeloHidden($modelo, "foto", ["id"=>"imgTrainer"]);
echo CHTML::dibujaEtiqueta("section",["id"=>"trainerSection"],"", false);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen1.png", "imgTrainer1", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen2M.png", "imgTrainer2", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen2F.webp", "imgTrainer3", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen3M.webp", "imgTrainer4", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen3F.webp", "imgTrainer5", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen4M.png", "imgTrainer6", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen4F.webp", "imgTrainer7", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen5M.png", "imgTrainer8", ["class"=>"trainer"]);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/gen5F.png", "imgTrainer9", ["class"=>"trainer"]);

echo CHTML::dibujaEtiquetaCierre("section");


echo "<br>";



echo CHTML::campoBotonSubmit("Iniciar Sesión", ["id"=>"bLogin"]);

echo CHTML::finalizarForm();