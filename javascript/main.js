
let total=0;
fetch("https://pokeapi.co/api/v2/pokemon?limit=0").then(function(data){
  data.json().then(function(resultados){
    total= resultados.count;
    info=document.createTextNode("¡Hay un total de "+total+" Pokémon y podrás viajar entre "+Math.round(total/9)+" páginas!")
    document.getElementById("info").appendChild(info)
  })

})



const pokemonContainer = document.querySelector("#pokemon-container");

const previous = document.querySelector("#previous");
const next = document.querySelector("#next");

console.log(previous)

let limit = 9;
let offset = 0;

previous.addEventListener("click", () => {
  if (offset != 0) {
    offset -= 9;
    removeChildNodes(pokemonContainer);
    fetchPokemon(offset, limit);
  }
});

next.addEventListener("click", () => {
  offset += 9;
  removeChildNodes(pokemonContainer);
  fetchPokemon(offset, limit);
});

var arrayPromises=[];

function fetchPokemon(offset, limit=1) {
  fetch("https://pokeapi.co/api/v2/pokemon?offset="+offset+"&limit="+limit)
  .then(function (resp) {
    //Se recibe la respuesta
    if (resp.ok) {

      resp.json().then(function(data){
        splitPokemon(data.results);
        if (data.results.length==0) {
          if (document.getElementsByClassName("error")[0]) {
            document.getElementsByClassName("error")[0].remove();
          }
          var p = document.createElement("p");
          p.className="error"
          p.appendChild(document.createTextNode("No hay coincidencias"))
          document.getElementsByTagName("nav")[1].insertBefore(p, document.getElementsByClassName("pagination")[0]);
        
        }
      })


    }

})
}

document.getElementById("changePage").onclick=function(){

      let pagina=parseInt(document.getElementById("page").value);

      if (pagina==1) {
        offset=0;
      }
      else{
        offset = 9*(parseInt(document.getElementById("page").value)-1);
      }
      removeChildNodes(pokemonContainer);
      fetchPokemon(offset, limit);


}

document.getElementById("poke").onclick=function(){

  removeChildNodes(pokemonContainer);
  datosPokemon(document.getElementById("pokeSearch").value);
}

function splitPokemon(pokemon){

    if (Array.isArray(pokemon)) {
        for (const i of pokemon) {
            datosPokemon(i.name);
            
        }
    }
    else datosPokemon(pokemon.name);
}

function dibujaUno(datos){
    var article=document.createElement("article");
    article.className="card";
    article.style.order=datos.id;
    var img=document.createElement("img");
    img.src= datos.sprites.front_default;
    img.className="card-img-top";
    img.alt=datos.name;
    var article2=document.createElement("article");
    article2.className="card-body";
    var parrafo=document.createElement("p");
    parrafo.className="card-text";

    var button = document.createElement("a");

    button.href="http://"+location.host+"/principales/info?id="+datos.id;
    button.id="bInfo";
    button.className="btn btn-outline-secondary"
    var info= document.createElement("img");
    info.src="/imagenes/aplicacion/info.svg"

    button.appendChild(info)


    var id="#";
    if (datos.id>=100) {
        id+=datos.id;
    }
    else if (datos.id>=10) {
        id+="0"+datos.id
    }
    else id+="00"+datos.id;

    var textoID= document.createTextNode(id);
    var textoNombre= document.createTextNode(datos.name);
    parrafo.appendChild(textoID);
    parrafo.appendChild(document.createElement("br"))
    parrafo.appendChild(textoNombre);

    article2.appendChild(parrafo);
    article.appendChild(img);
    article.appendChild(article2);
    article.appendChild(button);

    document.getElementById("pokemon-container").appendChild(article);
}

function datosPokemon(name){
    fetch("https://pokeapi.co/api/v2/pokemon/"+name)
    .then(function (resp) {
      //Se recibe la respuesta
      if (resp.ok) {
 
  
        resp.json().then(function(data){
          dibujaUno(data);
        })
  
      }
      else {
        if (document.getElementsByClassName("error")[0]) {
          document.getElementsByClassName("error")[0].remove();
        }
        var p = document.createElement("p");
        p.className="error"
        p.appendChild(document.createTextNode("No hay coincidencias"))
        document.getElementsByTagName("nav")[1].insertBefore(p, document.getElementsByClassName("pagination")[0]);
      }
  
  })
}


function removeChildNodes(parent) {
  while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
  }
}

var cards= document.getElementsByClassName("card");
for (const i of cards) {
    i.onclick=function(){
        alert("prueba");
}
}


fetchPokemon(offset, limit);
