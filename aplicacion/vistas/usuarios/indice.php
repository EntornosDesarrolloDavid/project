<?php

/**
 * Vista que dibuja el crud de los usuarios y su correspondiente filtrado
 */
$cadena= CPager::requisitos();
$this->textoHead=$cadena;
echo "<br>";



/**
 * Formulario de filtrado de nombre, rol y borrado
 */
echo CHTML::iniciarForm("", "POST");
echo CHTML::campoLabel("Nombre", "nombre");
echo CHTML::campoText("nombre", $datos["nombre"]);
echo "<br>";
echo CHTML::campoLabel("Rol", "cod_rol");
echo CHTML::campoListaDropDown(
    "rol",
    $datos["rol"],
    Rol::dameRoles(),
    array("linea" => "Elija un rol")
);
echo "<br>";
echo CHTML::campoLabel("Borrado", "borrado");

echo CHTML::campoCheckBox("borrado", boolval($datos["borrado"]));
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


echo CHTML::link("Nuevo Usuario", array("usuarios", "nuevo"));

?>