<?php

/**
 * Vista encargada de mostrar los Pokémon en forma de página, pudiendo filtrar por nombre y descargar
 * los Pokémon filtrados
 */

$cadena = CHTML::scriptFichero(
    "/javascript/pokemonTeam.js",
    ["defer" => "defer"]
);

$cadena .= CPager::requisitos();
$this->textoHead = $cadena;

/**
 * Formulario de filtrado de nombre
 */
echo CHTML::iniciarForm("", "POST");
echo CHTML::campoLabel("Nombre", "nombre");
echo CHTML::campoText("nombre", $data["nombre"]);
echo "<br>";

echo "<br>";
echo CHTML::campoBotonSubmit("Filtrar", array("name" => "fil"));
echo CHTML::campoBotonSubmit("Mostrar Todos", array("name" => "todos"));
echo "<br>";
echo "<br>";
$array = [];
if (isset($_REQUEST)) {
    foreach ($_REQUEST as $key => $value) {
        $array[$key] = $value;
    }
    echo CHTML::link("Descargar Datos", Sistema::app()->generaURL(["pokemon", "DescargaPokemon"], $array));
} else echo CHTML::link("Descargar Datos", Sistema::app()->generaURL(["pokemon", "DescargaPokemon"]));
echo CHTML::link("Nuevo Pokémon", array("pokemon", "nuevo"));
echo "<br>";

echo CHTML::finalizarForm();
echo "<br>";
echo "<br>";


$pagi = new CPager($opcPag, array());

//dibujo el paginador 
echo $pagi->dibujate();
echo CHTML::dibujaEtiqueta("article", ["id" => "pokeInvent"]);
foreach ($filas as $key => $fila) {
?>
    <div class="card" style="width: 18rem;">
        <?php
        if ($fila["foto"] == "") {
            echo CHTML::imagen("/imagenes/fotosPokemon/noFoto.png");
        } else echo CHTML::imagen("/imagenes/fotosPokemon/" . $fila["foto"]);

        ?>
        <div class="card-body">
            <?php
            $suma = $fila["ataque"] + $fila["vida"] + $fila["defensa"] + $fila["ataque_especial"] + $fila["defensa_especial"] + $fila["velocidad"];
            echo CHTML::dibujaEtiqueta("h5", ["class" => "card-title"], $fila["nombre"]);
            echo CHTML::dibujaEtiqueta("p", ["class" => "card-text"], $suma);
            ?>
            <div class="popup">
            <?php
            echo CHTML::dibujaEtiqueta("button", [ "data-toggle"=>"modal", "data-target"=>"#addPoke", "href" => "#bottom", "class" => "botonCombatir", "value" => $suma . "/$fila[cod_pokemonInvent]"], "¡Añadir a mi equipo!");
            ?>
           <span class="popuptext" id="myPopup">¡Tú equipo está lleno! ¡Libera uno de tus miembros si quieres reclutar a este Pokémon!</span>
            </div>
            <br>
            <a href="http://www.proyecto.es/pokemon/ver?id=<?php echo $fila["cod_pokemonInvent"] ?>" class="bInfo-sec btn"><img src="/imagenes/aplicacion/info.svg"></a>
     
        </div>
    </div>

<?php
}

echo CHTML::dibujaEtiquetaCierre("article");
//se dibuja la tabla 
//dibujo el paginador 
echo $pagi->dibujate();

?>

<div id="bar" class="progress">
  <div id="hp" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<button id="myBtn" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">¡Ver mi Equipo!</button>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasTopLabel">Mi equipo</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <article id="pokemonTeam">
            <?php
            foreach ($equipo as $key => $value) {
                if ($value["foto"] == "") {
                    $img = "/imagenes/fotosPokemon/noFoto.png";
                } else $img = "/imagenes/fotosPokemon/" . $value["foto"];
            ?>
                <article class="team-member card"><img src="<?php echo $img; ?>" class="card-img-top teamPokeimg" alt="venusaur">
                    <article class="card-body">
                        <p class="card-text">#<?php echo $value["cod_pokemonInvent"] ?><br><?php echo $value["nombre"] ?></p>
                    </article>

                    <a href="http://www.proyecto.es/pokemon/ver?id=<?php echo $value["cod_pokemon_usuario"] ?>&invent=1" class="bInfo-sec btn"><img src="/imagenes/aplicacion/info.svg"></a>
                    <button class="btnLiberar" value="<?php echo $value["cod_pokemon_usuario"]; ?>">Liberar</button>
     
                </article>
            <?php

            }
            ?>

        </article>
    </div>




</div>

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog" role="document">
    <div class="modal-content">

        <!-- Add image inside the body of modal -->
        <div class="modal-body">
            <div class="card-body">
                <p>¡Se ha añadido el Pokémon a tu Equipo!</p>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" data-dismiss="modal">
                Aceptar
                </button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog" role="document">
    <div class="modal-content">

        <!-- Add image inside the body of modal -->
        <div class="modal-body">
            <div class="card-body">
                <div id="pokefree">

                </div>
                <button id="cliberar" data-dismiss="modal" value="">
                    Liberar
                </button>
                <button type="button" data-dismiss="modal">
                Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
</div>