<?php

/**
 * Vista con los elementos para crear el minijuego de adivinar el texto
 */


/**
 * Indicación de un fichero javascript para la creación de la vista
 */
$cadena = CHTML::scriptFichero(
  "/javascript/adivinar.js",
  ["defer" => "defer"]
);
$this->textoHead = $cadena;

echo CHTML::dibujaEtiqueta("p", ["id" => "pAdivinar"], "", false);
foreach ($palabras as $key => $value) {
  echo CHTML::dibujaEtiqueta("span", [], $value, true);
  echo " ";
}

echo CHTML::dibujaEtiquetaCierre("p");
?>

<article style="text-align: center; margin: auto;">
  <?php

  echo CHTML::campoText("palabra", "", ["id" => "iPalabra", "autofocus" => "autofocus", "pattern" => "[A-Za-z]+", "title" => "Adivina una palabra solamente"]);
  echo CHTML::campoBotonSubmit("Adivinar", ["id" => "bPalabra"]);
  echo "<br>";
  echo "<br>"; ?>
  <!-- Button to launch a modal -->
  <button type="button" data-toggle="modal" data-target="#exampleModal">
    ¿Necesitas una pista?
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <!-- Add image inside the body of modal -->
        <div class="modal-body">
          <h4>¡Memoriza los carácteres para ponerlos en práctica!</h4>
          <article id="imgPista">
          <img src="/imagenes/aplicacion/lenguajeUnown.jpg" alt="lenguajeUnown" />
          </article>
        </div>

        <div class="modal-footer">
          <button type="button" data-dismiss="modal">
            Cerrar pista
          </button>
        </div>
      </div>
    </div>
  </div>
  <?php

  // echo CHTML::dibujaEtiqueta("p", [], "¡Aprende el lenguaje Unown con la siguiente imagen!");
  // echo CHTML::imagen("/imagenes/aplicacion/lenguajeUnown.jpg", "unown", ["id"=>"imgPista"]);
  echo CHTML::dibujaEtiquetaCierre("article");
  echo "<br>";
  echo "<br>";
  ?>

  <hr class="styled">
  <article id="translationDiv">

    <?php
    echo CHTML::dibujaEtiqueta("p", [], "¡Prueba a escribir cualquier texto para ver como cambia la palabra!");
    echo CHTML::campoText("palabra", "", ["id" => "textTranslate", "autofocus" => "autofocus", "title" => "Introduzca un texto y vea como es traducido a lenguaje Unown"]);
    echo CHTML::campoBotonSubmit("Traducir", ["id" => "bTranslate"]);
    echo "<br>";
    echo "<br>";

    echo CHTML::dibujaEtiqueta("h1", ["id" => "translation"], "");
    ?>
  </article>