<?php

/**
 * Vista que permite modificar un Pokémon ya existente
 */

$cadena = CHTML::scriptFichero(
    "/javascript/nuevoPoke.js",
    ["defer" => "defer"]
);
$this->textoHead=$cadena;
/**
 * Formulario encargado de realizar un login
 */

if (isset($errores)) {
    echo CHTML::dibujaEtiqueta("article", ["class"=>"error"], "", false);
    foreach ($errores as $key => $value) {
        echo CHTML::dibujaEtiqueta("p",[], $value);
    }
    echo CHTML::dibujaEtiquetaCierre("article");

}

echo CHTML::dibujaEtiqueta("h1", [], "Modificar Pokémon", true);

echo CHTML::iniciarForm("", "post", ["id" => "formPoke", "enctype"=>"multipart/form-data"]);




echo CHTML::campoLabel("Nombre", "nombre");
echo CHTML::campoText(
    "nombre",
    $modelo->nombre,
    array("maxlength" => 20, "size" => 21)
);
echo CHTML::dibujaEtiqueta("p", ["style"=>"color:red","id"=>"errorNombre"], "");





echo "<br>";



echo CHTML::campoLabel("Vida", "vida",[]);
echo CHTML::campoNumber("vida", $modelo->vida,[]);

echo "<br>";

echo CHTML::campoLabel("Ataque", "ataque",[]);
echo CHTML::campoNumber("ataque", $modelo->ataque,[]);

echo "<br>";

echo CHTML::campoLabel("Defensa", "defensa",[]);
echo CHTML::campoNumber("defensa", $modelo->defensa,[]);

echo "<br>";

echo CHTML::campoLabel("Ataque_especial", "ataque_especial",[]);
echo CHTML::campoNumber("ataque_especial", $modelo->ataque_especial,[]);

echo "<br>";

echo CHTML::campoLabel("Defensa_especial", "defensa_especial",[]);
echo CHTML::campoNumber("defensa_especial", $modelo->defensa_especial,[]);

echo "<br>";

echo CHTML::campoLabel("Velocidad", "velocidad",[]);
echo CHTML::campoNumber("velocidad", $modelo->velocidad,[]);

echo CHTML::dibujaEtiquetaCierre("section");


echo "<br>";

echo CHTML::campoLabel("Foto", "foto", []);
echo CHTML::imagen("/imagenes/fotosPokemon/".$modelo->foto);
echo CHTML::campoFile("foto", $modelo->foto,[]);
echo "<br>";


echo CHTML::campoBotonSubmit("Modificar Pokémon", ["class"=>"buttonPoke","name"=>"modificar"]);
echo CHTML::finalizarForm();
