<h1>TU EQUIPO POKÉMON</h1>
<?php

/**
 * Vista encargada de mostrar los Pokémon en forma de página, pudiendo filtrar por nombre y descargar
 * los Pokémon filtrados
 */

$cadena = CHTML::scriptFichero(
    "/javascript/combate.js",
    ["defer" => "defer"]
);

$this->textoHead = $cadena;
//dibujo el paginador 
echo CHTML::dibujaEtiqueta("article", ["id" => "pokeInvent"]);
foreach ($members as $key => $fila) {
?>
    <div class="card">
        <?php
        if ($fila["foto"] == "") {
            echo CHTML::imagen("/imagenes/fotosPokemon/noFoto.png");
        } else echo CHTML::imagen("/imagenes/fotosPokemon/" . $fila["foto"]);

        ?>
        <div class="card-body">
            <?php
            $suma = $fila["ataque"] + $fila["vida"] + $fila["defensa"] + $fila["ataque_especial"] + $fila["defensa_especial"] + $fila["velocidad"];
            echo CHTML::dibujaEtiqueta("h5", ["class" => "card-title"], $fila["nombre"]);
            echo CHTML::dibujaEtiqueta("article", ["class" => "progress-div"], "", false);
            echo CHTML::dibujaEtiqueta("p", ["class" => "text-progress"], "HP: " . " (" . $fila["vida"] . ")");
            echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $fila["vida"]], "", true);
            echo CHTML::dibujaEtiquetaCierre("article");
            echo CHTML::dibujaEtiqueta("article", ["class" => "progress-div"], "", false);

            echo CHTML::dibujaEtiqueta("p", ["class" => "text-progress"], "Atk: " . " (" . $fila["ataque"] . ")");
            echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $fila["ataque"]], "", true);
            echo CHTML::dibujaEtiquetaCierre("article");
            echo CHTML::dibujaEtiqueta("article", ["class" => "progress-div"], "", false);

            echo CHTML::dibujaEtiqueta("p", ["class" => "text-progress"], "Def: " . " (" . $fila["defensa"] . ")");
            echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $fila["defensa"]], "", true);
            echo CHTML::dibujaEtiquetaCierre("article");
            echo CHTML::dibujaEtiqueta("article", ["class" => "progress-div"], "", false);

            echo CHTML::dibujaEtiqueta("p", ["class" => "text-progress"], "Sp Atk: " . " (" . $fila["ataque_especial"] . ")");
            echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $fila["ataque_especial"]], "", true);
            echo CHTML::dibujaEtiquetaCierre("article");
            echo CHTML::dibujaEtiqueta("article", ["class" => "progress-div"], "", false);

            echo CHTML::dibujaEtiqueta("p", ["class" => "text-progress"], "Sp Def: " . " (" . $fila["defensa_especial"] . ")");
            echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $fila["defensa_especial"]], "", true);
            echo CHTML::dibujaEtiquetaCierre("article");
            echo CHTML::dibujaEtiqueta("article", ["class" => "progress-div"], "", false);

            echo CHTML::dibujaEtiqueta("p", ["class" => "text-progress"], "Spe: " . " (" . $fila["velocidad"] . ")");
            echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $fila["velocidad"]], "", true);
            echo CHTML::dibujaEtiquetaCierre("article");
            echo CHTML::dibujaEtiqueta("button", ["href" => "#bottom", "class" => "botonCombatir", "value" => $suma . "/$fila[cod_pokemonInvent]"], "Combatir")
            ?>
        </div>
    </div>

<?php
}

echo CHTML::dibujaEtiquetaCierre("article");
//se dibuja la tabla 
//dibujo el paginador 
echo CHTML::dibujaEtiqueta("p", ["id" => "pResultado"], "");
echo CHTML::dibujaEtiqueta("p", ["id" => "pResultadoVS"], "Combate contra:");

echo CHTML::imagen("", "imgLucha", ["name" => "combate", "id" => "pokemonLucha"]);

?>
<article id="battleField">
    <article class="pokemonField">
    <!-- attack-right -->
        <img id="imgMember" src="" alt="">
        <div class="hpbar" id="hpMember" style="background-color: green;" class=""></div>
    </article>
    <article class="pokemonField">
    <!-- class="attack-left" -->
        <img  id="imgEnemy" src="" alt="">
        <div class="hpbar" id="hpEnemy" style="background-color: green;" class=""></div>

    </article>
</article>


<article style="text-align: center;">
    <h3>¡Si logras vencer a <span id="nombrePokemon"></span> recibirás +<span id="evs"></span>!</h3>
    <input type="submit" value="Huir del combate" id="huir">

    <!-- Button to launch a modal -->
    <button type="button" data-toggle="modal" data-target="#exampleModal">
        Ver estadísticas del rival
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Add image inside the body of modal -->
                <div class="modal-body">
                    <div class="card-body">
                        <img id="pokemonRival" src="" alt="rivalPokémon">
                        <h5 class="card-title" id="pokename"></h5>
                        <article class="progress-div">
                            <p class="text-progress">HP: <span class="hp"></span></p><progress class="hp" max="255" value="80" style="--c:#f08024;"></progress>
                        </article>
                        <article class="progress-div">
                            <p class="text-progress">Atk: <span class="attack"></span></p><progress class="attack" max="255" value="80" style="--c:#f08024;"></progress>
                        </article>
                        <article class="progress-div">
                            <p class="text-progress">Def: <span class="defense"></span></p><progress class="defense" max="255" value="80" style="--c:#f08024;"></progress>
                        </article>
                        <article class="progress-div">
                            <p class="text-progress">Sp Atk: <span class="special-attack"></span></p><progress class="special-attack" max="255" value="80" style="--c:#f08024;"></progress>
                        </article>
                        <article class="progress-div">
                            <p class="text-progress">Sp Def: <span class="special-defense"></span></p><progress class="special-defense" max="255" value="80" style="--c:#f08024;"></progress>
                        </article>
                        <article class="progress-div">
                            <p class="text-progress">Spe: <span class="speed"></span></p><progress class="speed" max="255" value="80" style="--c:#f08024;"></progress>
                        </article>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal">
                        Cerrar Estadísticas
                    </button>
                </div>
            </div>
        </div>
    </div>
</article>