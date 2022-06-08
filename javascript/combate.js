document.getElementById("hpEnemy").style.setProperty("--h", "75%");


colorBars();

findFight();

document.getElementById("huir").onclick=function(){
  console.log("Prueba")
  findFight();
}
if (localStorage.resultado) {
  document.getElementById("pResultado").innerHTML="Último Resultado: "+localStorage.resultado
}

function findFight(){
  let random = Math.floor(Math.random() * 898);
  fetch("https://pokeapi.co/api/v2/pokemon/" + random)
    .then(function (resp) {
      //Se recibe la respuesta
      console.log(resp)
        if (!resp.ok) {
          fetch("https://pokeapi.co/api/v2/pokemon-species/"+random).then(function(datos){
              datos.json().then(function(data){
                  fetch(data.varieties[0].pokemon.url).then(function(datos){
                      datos.json().then(function(data){
                        evs(random)
                        document.getElementById("pokename").innerHTML = data.name.charAt(0).toUpperCase() + data.name.slice(1);
                        document.getElementById("pokemonLucha").src = data.sprites.front_default;
                        document.getElementById("pokemonRival").src = data.sprites.front_default;
                        document.getElementById("nombrePokemon").innerHTML = data.name.charAt(0).toUpperCase() + data.name.slice(1);
                        stats(data.stats);
                        
                      })
                  })
              })
          })
      }
        resp.json().then(function (data) {
          evs(random)
          document.getElementById("pokename").innerHTML = data.name.charAt(0).toUpperCase() + data.name.slice(1);
          document.getElementById("pokemonLucha").src = data.sprites.front_default;
          document.getElementById("pokemonRival").src = data.sprites.front_default;
          document.getElementById("nombrePokemon").innerHTML = data.name.charAt(0).toUpperCase() + data.name.slice(1);
          stats(data.stats);
        })


      

    })
}
    


botones = document.getElementsByClassName("botonCombatir")
for (const i of botones) {
  i.addEventListener("click", combate);
}


function combate() {
  window.scrollTo(0,document.body.scrollHeight);
 

}

function stats(stats){

  for (const i of stats) {
    campos = document.getElementsByClassName(i.stat.name)
    for (const j of campos) {
      j.innerHTML = "("+i.base_stat+")"
      j.value = i.base_stat
    }
  }
  colorBars();

}

function colorBars(){
  var progress = document.querySelectorAll("progress");
  for(var i = 0;i<progress.length;i++) {
     var n = parseInt(progress[i].getAttribute("value"));
     if (n>40) {
      progress[i].style.setProperty("--c", "rgb(255,0,0)");
  
     }
     if (n>60){
      progress[i].style.setProperty("--c", "#f08024");
  
     }
     if (n>80){
      progress[i].style.setProperty("--c", "#e9f022");
  
     }
  
     if (n>100){
      progress[i].style.setProperty("--c", "#95ed3e");
  
     }
  }
}
function evs(pokemon){
  fetch("https://pokeapi.co/api/v2/pokemon/" + pokemon)
  .then(function (resp) {
    //Se recibe la respuesta
      resp.json().then(function (data) {
        for (const i of data.stats) {
          if (i.effort>0) {
            document.getElementById("evs").innerHTML= i.effort+" "+i.stat.name;
          }
          console.log(i)
        }
      })


    

  })
}

