<?php
$cadena= CPager::requisitos();
$this->textoHead=$cadena;
echo "<br>";

/**
 * Vista que dibuja el Crud de los Pokémon, con su correspondiente filtro y su botón de descarga
 */


/**
 * Formulario de filtrado de nombre
 */
echo CHTML::iniciarForm("", "POST");
echo CHTML::campoLabel("Nombre", "nombre");
echo CHTML::campoText("nombre", $datos["nombre"]);
echo "<br>";
echo CHTML::campoLabel("Borrado", "borrado");

echo CHTML::campoCheckBox("borrado", boolval($datos["borrado"]));
echo "<br>";
echo "<br>";
echo CHTML::campoBotonSubmit("Filtrar", array("name"=>"fil"));
echo CHTML::campoBotonSubmit("Mostrar Todos", array("name"=>"todos"));
echo "<br>";
echo "<br>";

echo CHTML::finalizarForm();

$pagi=new CPager($opcPag,array()); 


$tabla=new CGrid($cabe,$filas, 
 array("class"=>"tabla1")); 
//dibujo el paginador 
echo $pagi->dibujate(); 
//se dibuja la tabla 
echo $tabla->dibujate(); 
//dibujo el paginador 
echo $pagi->dibujate(); 


echo CHTML::link("Nuevo Pokémon", array("pokemon", "nuevo"));
echo "<br>";
echo "<br>";

$parametros=[];
if (isset($_REQUEST)) {
    foreach ($_REQUEST as $key => $value) {
        $parametros[$key]=$value;
    }
    echo CHTML::link("Descargar Datos", Sistema::app()->generaURL(["pokemon", "DescargaPokemon"], $parametros));
}
else echo CHTML::link("Descargar Datos", Sistema::app()->generaURL(["pokemon", "DescargaPokemon"]));

?>