<?php
/**
 * Vista que permite crear un nuevo Pokémon
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

echo CHTML::dibujaEtiqueta("h1", [], "Nuevo Pokémon", true);

echo CHTML::iniciarForm("", "post", ["id" => "formPoke", "enctype"=>"multipart/form-data"]);



echo CHTML::dibujaEtiqueta("article");
echo CHTML::campoLabel("Nombre", "nombre");
echo CHTML::campoText(
    "nombre",
    "",
    array("maxlength" => 20, "size" => 21)
);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiqueta("p", ["style"=>"color:red","id"=>"errorNombre"], "");




echo CHTML::dibujaEtiqueta("article");

echo CHTML::campoLabel("Vida", "vida",[]);
echo CHTML::campoNumber("vida", $datos["vida"],[]);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiqueta("article");

echo CHTML::campoLabel("Ataque", "ataque",[]);
echo CHTML::campoNumber("ataque", $datos["ataque"],[]);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiqueta("article");

echo CHTML::campoLabel("Defensa", "defensa",[]);
echo CHTML::campoNumber("defensa", $datos["defensa"],[]);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiqueta("article");

echo CHTML::campoLabel("Ataque especial", "ataque_especial",[]);
echo CHTML::campoNumber("ataque_especial", $datos["ataque_especial"],[]);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiqueta("article");

echo CHTML::campoLabel("Defensa especial", "defensa_especial",[]);
echo CHTML::campoNumber("defensa_especial", $datos["defensa_especial"],[]);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiqueta("article");

echo CHTML::campoLabel("Velocidad", "velocidad",[]);
echo CHTML::campoNumber("velocidad", $datos["velocidad"],[]);
echo CHTML::dibujaEtiquetaCierre("article");


echo CHTML::dibujaEtiquetaCierre("section");


echo CHTML::dibujaEtiqueta("article", ["id"=>"FotoField"]);

echo CHTML::campoLabel("Foto", "foto", []);
echo CHTML::campoFile("foto", "foto",[]);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::campoBotonSubmit("Crear Pokémon", ["class"=>"buttonPoke", "name"=>"crear"]);
echo CHTML::finalizarForm();
