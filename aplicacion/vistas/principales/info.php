<?php

/**
 * Vista que dibuja la información de un Pokémon oficial
 */


/**
 * Indicación de un fichero javascript para la creación de la vista
 */
$cadena = CHTML::scriptFichero(
  "/javascript/info.js",
  ["defer" => "defer"]
);
$this->textoHead = $cadena;

echo CHTML::dibujaEtiqueta("section", ["id" => "section1info"], "", false);
echo CHTML::dibujaEtiqueta("h1", [], ucfirst($data["name"]) . " #" . $data["id"]);
echo CHTML::dibujaEtiqueta("article", ["id" => "imgInformacion"]);
if (is_null($data["sprites"]["other"]["dream_world"]["front_default"])) {
  echo CHTML::imagen($data["sprites"]["other"]["official-artwork"]["front_default"], "imgInfo", []);
} else echo CHTML::imagen($data["sprites"]["other"]["dream_world"]["front_default"], "imgInfo", []);
$objetos = "";
echo CHTML::dibujaEtiqueta("article", ["id" => "infoText"]);

if (count($data["held_items"]) > 0) {

  foreach ($data["held_items"] as $key => $value) {
    $objetos = $data["held_items"][$key]["item"]["name"] . ", ";
  }
  $objetos = rtrim($objetos, ", ");
} else $objetos = "Ninguno";
echo CHTML::dibujaEtiqueta("p", [], "Posibles Objetos Equipados: " . $objetos);



echo CHTML::dibujaEtiqueta("p", [], "Altura: " . ($data["height"] / 10) . "m");
echo CHTML::dibujaEtiqueta("p", [], "Peso: " . ($data["weight"] / 10) . "kg");

$habilidades = "";
foreach ($data["abilities"] as $key => $value) {
  if ($value["is_hidden"]) {
    echo CHTML::dibujaEtiqueta("p", [], "Habilidad Oculta: " . ucfirst($value["ability"]["name"]) . "<br>");

  } else echo CHTML::dibujaEtiqueta("p", [], "Habilidad " . ($key + 1) . ": " . ucfirst($value["ability"]["name"]) . "<br>");
}
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiquetaCierre("article");
echo CHTML::dibujaEtiqueta("article", ["class" => $data["types"][0]["type"]["name"]." tipos"], "", false);
echo CHTML::dibujaEtiqueta("p", [], ucfirst($data["types"][0]["type"]["name"]));
echo CHTML::dibujaEtiquetaCierre("article");

if (count($data["types"]) == 2) {
  echo CHTML::dibujaEtiqueta("article", ["class" => $data["types"][1]["type"]["name"]." tipos"], "", false);
  echo CHTML::dibujaEtiqueta("p", [], ucfirst($data["types"][1]["type"]["name"]));
  echo CHTML::dibujaEtiquetaCierre("article");
}
echo "<hr>";

echo CHTML::dibujaEtiqueta("article", ["id" => "kkkk"]);
echo CHTML::dibujaEtiqueta("article", ["id" => "stats"]);

$arrayStats = ["HP", "Ataque", "Defensa", "Ataque Especial", "Defensa Especial", "Velocidad"];
foreach ($data["stats"] as $key => $value) {
  echo CHTML::dibujaEtiqueta("p", [], $arrayStats[$key] . " (" . $value["base_stat"] . ")");
  echo CHTML::dibujaEtiqueta("progress", ["max" => 255, "value" => $value["base_stat"]], "", true);
  echo "<br>";
}
echo CHTML::dibujaEtiquetaCierre("article");


$level = [];
$egg = [];
$machine = [];

foreach ($data["moves"] as $key => $value) {
  foreach ($value["version_group_details"] as $clave => $info) {
    if ($info["version_group"]["name"] == "sword-shield") {
      if ($info["move_learn_method"]["name"] == "egg") {
        array_push($egg, $value["move"]["name"]);
      }
      if ($info["move_learn_method"]["name"] == "machine") {
        array_push($machine, $value["move"]["name"]);
      }
      if ($info["move_learn_method"]["name"] == "level-up") {
        $level[$info["level_learned_at"]] = $value["move"]["name"];
      }
    }
  }
}

?>
<div class="accordion" id="movements">
  <div class="accordion-item" style="max-width: 500px;">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        Movimientos Huevo
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <?php
        foreach ($egg as $key => $value) {
          echo CHTML::dibujaEtiqueta("p", ["class" => "movimiento"], ucfirst($value));
          echo "<br>";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="accordion-item" style="max-width: 500px;">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Movimientos Por MT
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <?php
        foreach ($machine as $key => $value) {
          echo CHTML::dibujaEtiqueta("p", ["class" => "movimiento"], ucfirst($value));
          echo "<br>";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="accordion-item" style="max-width: 500px;">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Movimientos Por Nivel
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <?php
        $moves = [];
        foreach ($level as $key => $value) {
          $moves[$key] = $value;
        }
        ksort($moves);
        foreach ($moves as $key => $value) {
          echo CHTML::dibujaEtiqueta("p", ["class" => "movimiento"], ucfirst($value) . ": aprendido al nivel " . $key);
          echo "<br>";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php

echo CHTML::dibujaEtiqueta("article", ["id" => "forms"]);


echo CHTML::dibujaEtiqueta("h2", [], "Forma Shiny");
echo CHTML::imagen($data["sprites"]["front_shiny"], "shiny", []);

echo CHTML::dibujaEtiqueta("h2", [], "Formas Alternativas");
echo CHTML::dibujaEtiqueta("button", ["id" => "botonVariantes"], "Variantes de este Pokémon");
echo CHTML::dibujaEtiquetaCierre("article");

echo CHTML::dibujaEtiquetaCierre("section");
echo "<br>";
echo CHTML::dibujaEtiquetaCierre("article");
