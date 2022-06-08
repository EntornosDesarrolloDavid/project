botones = document.getElementsByClassName("botonCombatir")
for (const i of botones) {
  i.addEventListener("click", catchPoke);

}

popups = document.getElementsByClassName("popuptext");
for (const i of popups) {
  i.addEventListener("click", function () {
    i.classList.remove("show");
  });

}

function catchPoke() {
  popups = document.getElementsByClassName("popuptext");
  for (const i of popups) {
    i.classList.remove("show");

  }
  members = document.getElementsByClassName("team-member").length;
  if (members == 6) {

    popup = this.nextElementSibling
    popup.classList.toggle("show");
    if (document.getElementById("addPoke")) {
      document.getElementById("addPoke").id = "modalAdd"

    }
  }
  else {
    if (document.getElementById("modalAdd")) {
      document.getElementById("modalAdd").id = "addPoke"

    }


    var info = this.value;
    var myInfo = info.split("/");
    var stats1 = myInfo[0];
    var id = myInfo[1];

    fetch("http://" + location.host + "/combate/catchPoke", {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + id
    })
      .then(function (resp) {
        resp.json().then(function (data) {
          dibujaUno(data)
        })
      })

    // location.reload();
  }
}

liberar = document.getElementsByClassName("btnLiberar")
for (const i of liberar) {
  i.addEventListener("click", function () {
    if (confirm("¿Estás seguro de que quieres liberar a este Pokémon?") == true) {
      liberarPoke(i.value)
    }
    // element = i
    // while (!element.classList.contains('card')) {
    //   element = element.parentNode;
    // }
    // var dupNode = element.cloneNode(true);
    // // console.log(dupNode)
    // // console.log(dupNode.getElementsByClassName("btn"))
    // dupNode.getElementsByClassName("btn")[0].remove()
    // dupNode.getElementsByClassName("btnLiberar")[0].remove()

    // pokefree.appendChild(dupNode)
  });
}

function dibujaUno(datos) {
  console.log(datos)
  var article = document.createElement("article");
  article.className = "card team-member";
  article.style.order = datos.id;
  var img = document.createElement("img");
  img.src = "imagenes/fotosPokemon/" + datos.foto;
  if (datos.foto == "") {
    img.src = "/imagenes/fotosPokemon/noFoto.png";
  }
  img.className = "card-img-top";
  img.alt = datos.nombre;
  img.className = "card-img-top"
  img.classList.add("teamPokeimg")
  var article2 = document.createElement("article");
  article2.className = "card-body";
  var parrafo = document.createElement("p");
  parrafo.className = "card-text";
  var liberarbtn = document.createElement("button");
  liberarbtn.setAttribute("data-toggle", "modal")
  liberarbtn.setAttribute("data-target", "#exampleModal")
  liberarbtn.addEventListener("click", function () {
    document.getElementById("cliberar").value = datos.cod_pokemon_usuario;
  });
  liberarbtn.className = "btnLiberar"
  liberarbtn.innerHTML = "Liberar"
  liberarbtn.value = datos.cod_pokemon_usuario
  var button = document.createElement("a");
  button.href = "http://" + location.host + "/pokemon/ver?id=" + datos.cod_pokemon_usuario + "&invent=1";
  var info = document.createElement("img");


  info.src = "/imagenes/aplicacion/info.svg"

  button.appendChild(info)


  var textoID = document.createTextNode("#" + datos.cod_pokemonInvent);
  var textoNombre = document.createTextNode(datos.nombre);
  parrafo.appendChild(textoID);
  parrafo.appendChild(document.createElement("br"))
  parrafo.appendChild(textoNombre);

  article2.appendChild(parrafo);
  article.appendChild(img);
  article.appendChild(article2);
  article.appendChild(button);
  article.appendChild(liberarbtn)

  document.getElementById("pokemonTeam").appendChild(article);

}

// document.getElementById("cliberar").addEventListener("click", liberarPoke)

function liberarPoke(poke) {
  var el = this
  fetch("http://" + location.host + "/combate/freePoke", {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id=' + poke
  })
    .then(function (data) {
      liberar = document.getElementsByClassName("btnLiberar")
      for (const i of liberar) {
        if (i.value == poke) {
          element = i
          while (!element.classList.contains('card')) {
            element = element.parentNode;
          }
          element.classList.add("dissapear")
          setTimeout(() => {
            element.remove()
          }, 800);
        }
      }
    })

}

document.getElementById("bar").onclick = function () {
  document.getElementById("hp").ariaValueNow = "20";

  for (let i = 0; i < 25; i++) {
    setTimeout(() => {
      document.getElementById("hp").style.width = i + "%"

    }, 10);

  }
  console.log(document.getElementById("hp").width);
}

document.getElementById("modalAdd").onclick = function () {
}