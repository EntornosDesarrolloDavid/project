<?php

/**
 * Vista que permite ver la información de un usuario ya existente
 */
echo CHTML::dibujaEtiqueta("section", ["id"=>"infoUser"], "",false);

    echo CHTML::dibujaEtiqueta("h2", [], "Usuario #".$modelo->cod_usuario);
    echo CHTML::imagen("/imagenes/aplicacion/trainers/".$modelo->foto);

    echo CHTML::dibujaEtiqueta("p", [], "Nick: ".$modelo->nick);
    echo CHTML::dibujaEtiqueta("p", [], "Nombre: ".$modelo->nombre);
    echo CHTML::dibujaEtiqueta("p", [], "Código de Rol: ".$modelo->cod_rol);
    if ($modelo->borrado) {
        echo CHTML::dibujaEtiqueta("p", [], "Borrado: SÍ");
    }
    else echo CHTML::dibujaEtiqueta("p", [], "Borrado: NO");

echo "<br>";
echo "<br>";

echo CHTML::link("Modificar Usuario", Sistema::app()->generaURL(array("usuarios", "modificar"), array("id"=>$modelo->cod_usuario)) );
echo "<br>";

echo CHTML::link("Borrar Usuario", Sistema::app()->generaURL(array("usuarios", "borrar"), array("id"=>$modelo->cod_usuario)) );
echo "<br>";

echo CHTML::link("Volver al CRUD de Usuarios", Sistema::app()->generaURL(array("usuarios", "indice")) );

echo CHTML::dibujaEtiquetaCierre("section");



?>