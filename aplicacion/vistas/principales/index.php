<?php

/**
 * Vista que dibuja la página inicial con el pokémon del día y un resumen de lo que hay en la página
 */

echo CHTML::dibujaEtiqueta("article");

echo CHTML::imagen("/imagenes/aplicacion/inicial.png", "mainLogo",["id"=>"mainLogo"]);
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiqueta("section", ["id"=>"sectionIndex"], "", false);
echo CHTML::dibujaEtiqueta("h1", [], "Tu Pokémon del Día", true);
echo CHTML::dibujaEtiqueta("article");

echo CHTML::link(CHTML::imagen($imagen, "dailyPokemon", ["id"=>"imgDia"]), Sistema::app()->generaURL(array("principales", "info"), array("id"=>$_COOKIE["dailyPokemonId"])));
echo CHTML::dibujaEtiquetaCierre("article");
echo "<hr>";


echo CHTML::dibujaEtiqueta("section", ["class"=>"articleIndex"], "", false);
    echo CHTML::imagen("/imagenes/aplicacion/pokedex.png", "pokédexImg", []);
    echo CHTML::dibujaEtiqueta("article");
    echo CHTML::dibujaEtiqueta("h3", [], "Consulta la Pokédex");
    echo CHTML::dibujaEtiqueta("p", [], "Aventúrate en la Pokédex y busca cualquier Pokémon que desees. ¡Podrás navegar libremente entre todas las entradas de ésta y consultar información sobre cualquier criatura fantástica!");
    echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiquetaCierre("section");



echo CHTML::dibujaEtiqueta("section", ["class"=>"articleIndex"], "", false);
    echo CHTML::dibujaEtiqueta("article");
    echo CHTML::dibujaEtiqueta("h3", [], "¡Da rienda suelta a tu imaginación!");
    echo CHTML::dibujaEtiqueta("p", [], "¿Alguna vez has deseado crear tus propios Pokémon? ¡Pues estás en el lugar perfecto! ¡Aquí podrás crear tus propios Pokémon e incluso luchar con ellos!");
    echo CHTML::dibujaEtiquetaCierre("article");
    echo CHTML::imagen("/imagenes/aplicacion/combate.png", "combate", []);

echo CHTML::dibujaEtiquetaCierre("section");


echo CHTML::dibujaEtiqueta("section", ["class"=>"articleIndex"], "", false);
    echo CHTML::imagen("/imagenes/aplicacion/shiny.jpg", "shiny", []);
    echo CHTML::dibujaEtiqueta("article");
    echo CHTML::dibujaEtiqueta("h3", [], "¡Busca Shinies!");
    echo CHTML::dibujaEtiqueta("p", [], "¿Sabías que existen Pokémon de diferente color muy raros de ver? Entra en el minijuego en el que podrás buscar la forma variocolor de cualquier Pokémon.");
    echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiquetaCierre("section");

echo CHTML::dibujaEtiqueta("section", ["class"=>"articleIndex"], "", false);
    echo CHTML::dibujaEtiqueta("article");
    echo CHTML::dibujaEtiqueta("h3", [], "¡Demuetra tu habilidad!");
    echo CHTML::dibujaEtiqueta("p", [], "Si eres un experto entrenador Pokémon podrás reconocer mensajes cifrados en lenguaje Unown ¿Podrás descifrarlos?");
    echo CHTML::dibujaEtiquetaCierre("article");
    echo CHTML::imagen("/imagenes/aplicacion/lenguajeUnown.jpg", "unown", []);

echo CHTML::dibujaEtiquetaCierre("section");

echo CHTML::dibujaEtiquetaCierre("section");