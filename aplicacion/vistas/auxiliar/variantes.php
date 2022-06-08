<?php
/**
 * Vista que muestra las variantes de un Pokémon en una ventana auxiliar
 */
for ($i=0; $i < count($nombres); $i++) { 
    if ($fotos[$i]) {
    
    echo CHTML::dibujaEtiqueta("article",["class"=>"variante"],"",false);
        echo CHTML::dibujaEtiqueta("h1",["class"=>"tituloVariantes"],ucfirst($nombres[$i]));
        echo CHTML::imagen($fotos[$i], "variante$i", []);
    echo CHTML::dibujaEtiquetaCierre("article");
}
}