<?php
/**
 * Vista que pide confirmación de borrado de un usuario
 */
echo CHTML::dibujaEtiqueta("section", ["id"=>"infoUser"], "", false);
echo CHTML::iniciarForm();

/**
 * Dibujar el resumen del producto y posteriormente un botón que confirmará el borrado
 */
$this->dibujaVistaParcial(
    "ver",
    array("modelo" => $modelo),

);

echo "<br>";
echo CHTML::campoBotonSubmit("Borrar", array("name"=>"borrar"));

echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("section");