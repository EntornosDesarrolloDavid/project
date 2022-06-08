class Shiny {

    id;
    nombre;
    generacion;
    normal_sprite;
    shiny_sprite;
    encuentros;
    shiny;
    #_random;
    constructor(id, nombre, generacion, normal_sprite, shiny_sprite, encuentros) {
        this.id = id;
        this.nombre = nombre;
        this.generacion = generacion;
        this.normal_sprite = normal_sprite;
        this.shiny_sprite = shiny_sprite;
        this.encuentros = encuentros;
        this.shiny = false;
        this.#_random = 0;
    }

    get random() {

        return this.#_random;
    }

    set random(valor) {
        this.#_random = valor;
    }

    checkShiny(number) {
        if (number == this.#_random) {
            return true;
        }
        return false;
    }

    static funcionamiento() {
        return "Un shiny es un Pokémon cuya aparición es muy rara. " +
            "Un número es generado es aleatoriamente y a través de clicks debes generar un número que se igual a ese. " +
            "Si la generación es la Quinta o una anterior la probabilidad será de 1/8192. Si es posterior a ésta será de 1/2.";
    }


}

var usuario = "";

fetch("http://" + location.host + "/usuarios/GetUser", {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
}).then(function (resp) {
    resp.text().then(function (user) {
        if (!localStorage.getItem("intentos" + user)) {
            localStorage.setItem("intentos" + user, 6);
            localStorage.setItem("fecha" + user, new Date());

        }
        document.getElementById("pVidasActuales").innerHTML = "¡Tienes "+ localStorage.getItem("intentos" + user) +" encuentros disponibles!"
        reset = new Date(localStorage.getItem("fecha" + user));
        current = new Date();
        var hours = Math.trunc((current - reset) / (3600000 * 6));
        console.log(hours)
        localStorage.setItem("intentos" + user, Number(localStorage.getItem("intentos" + user)) + hours * 6);
        reset.setHours(reset.getHours()+hours*6)
        localStorage.setItem("fecha" + user, reset)
        reset.setHours(reset.getHours()+6);
        mostrar(reset.getHours(), reset.getMinutes(), reset.getSeconds());
        if (parseInt(localStorage.getItem("intentos" + user)) < 1) {
            document.getElementById("encuentros").disabled = true
        }

    })
})


function mostrar(hora, min, seg) {
    if (seg < 10) seg = "0" + seg;
    if (min < 10) min = "0" + min;
    if (hora < 10) hora = "0" + hora;
    //llevar resultado al visor.			 
    document.getElementById("dateReset").innerHTML = "Nuevos 6 encuentros a las: " + hora + ":" + min + ":" + seg;
}

// Create new Date instance
var date = new Date()

// Add a day
date.setDate(date.getDate() + 3)


var shiny;
var odds;

document.getElementById("encuentros").disabled = true

if (document.cookie) {
    arrayCookies = document.cookie.split(";");

    for (let i in arrayCookies) {
        fetch("http://" + location.host + "/usuarios/GetUser", {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (resp) {
            resp.text().then(function (user) {
                
                if (arrayCookies[i].match("shiny" + user)) {
                    let arrayAux = arrayCookies[i].split("=");
                    shinyAux = JSON.parse(arrayAux[1].trim());
                    document.getElementById("imgShiny").style.visibility = "visible";

                    shiny = new Shiny(shinyAux.id, shinyAux.nombre, shinyAux.generacion, shinyAux.normal_sprite, shinyAux.shiny_sprite, shinyAux.encuentros);
                    shiny.shiny = shinyAux.shiny

                    if (shiny.shiny) {
                        document.getElementById("imgShiny").src = shiny.shiny_sprite
                        document.getElementById("encuentros").disabled = true
                    }
                    else {
                        document.getElementById("encuentros").disabled = false
                        document.getElementById("imgShiny").src = shiny.normal_sprite
                        document.getElementById("pContador").innerHTML = "Encuentros: " + shiny.encuentros
                    }

                    if (parseInt(shiny.generation) < 6) {
                        odds = 8192;
                        shiny.random = Math.floor(Math.random() * odds);
                    }
                    else {
                        odds = 4096;
                        shiny.random = Math.floor(Math.random() * odds);

                    }

                }

            })
        })

    }
}




fetch("https://pokeapi.co/api/v2/pokemon?limit=0").then(function (data) {
    data.json().then(function (resultados) {
        total = resultados.count;
    })

})

radios = document.getElementsByName("gen");
for (let i = 0; i < radios.length; i++) {

    radios[i].addEventListener('focus', function () {
        crearSelect(radios[i].value)
    })
}

function crearSelect(generation) {


    fetch("https://pokeapi.co/api/v2/generation/" + generation).then(function (data) {
        data.json().then(function (nodos) {
            // if(document.getElementById("imgShiny"))
            // document.getElementById("imgShiny").remove();

            if (document.getElementById("tablaShiny"))
                document.getElementById("tablaShiny").remove();
            var tabla = document.createElement("section");
            tabla.id = "tablaShiny";
            for (const i of nodos.pokemon_species) {
                fetch("https://pokeapi.co/api/v2/pokemon/" + i.name).then(function (first) {
                    if (!first.ok) {
                        fetch("https://pokeapi.co/api/v2/pokemon-species/" + i.name).then(function (datos) {
                            datos.json().then(function (data) {
                                fetch(data.varieties[0].pokemon.url).then(function (datos) {
                                    datos.json().then(function (data) {
                                        var td = document.createElement("article");
                                        dibujarTabla(td, data, generation)
                                        tabla.appendChild(td);

                                    })
                                })
                            })
                        })
                    }
                    first.json().then(function (datos) {

                        var td = document.createElement("article");
                        td.onmouseenter
                        dibujarTabla(td, datos, generation);
                        tabla.appendChild(td);
                    })
                })
                    .catch(function (err) {
                        console.log("Error");
                    })
            }



            document.getElementById("interior").insertBefore(tabla, document.getElementById('imgShiny'));


        })
    })

}

function dibujarTabla(td, datos, generation) {
    td.style.order = datos.id
    td.style.border = "1px solid blue"
    td.style.borderRadius = "15px/45px";
    td.style.margin = "1%";
    var a = document.createElement("a");
    a.href = "#imgShiny"
    txtTabla = document.createTextNode(datos.name)
    a.appendChild(txtTabla)
    var imgPoke = document.createElement("img");
    imgPoke.src = datos.sprites.front_default;
    td.onmouseover = function () {
        imgPoke.src = datos.sprites.front_shiny
    }

    td.onmouseout = function () {
        imgPoke.src = datos.sprites.front_default;
    }

    a.appendChild(imgPoke);
    td.appendChild(a)
    a.addEventListener("click", function () {

        interfazEncuentros(datos, generation);

    })
}


document.getElementById("encuentros").onclick = function () {
    let found = false;
    document.getElementById("encuentros").disabled = true
    encuentros = 1;
    fetch("http://" + location.host + "/usuarios/GetUser", {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    }).then(function (resp) {
        resp.text().then(function (user) {
            localStorage.setItem("intentos" + user, Number(localStorage.getItem("intentos" + user)) - 1);
            if (parseInt(localStorage.getItem("intentos" + user)) > 0 && !found) {
                document.getElementById("encuentros").disabled = false
                localStorage.removeItem("shiny");

            }

        })
    })
    let randomNumber = Math.floor(Math.random() * odds);
    if (shiny.checkShiny(randomNumber)) {
        shiny.shiny = true;
        document.getElementById("imgShiny").src = shiny.shiny_sprite;
        found = true;
        document.getElementById("encuentros").disabled = true
        var audio = new Audio('/imagenes/aplicacion/badge.mp3');
        audio.play();


        document.getElementById("pResultado").innerHTML = "El Shiny se ha guardado en la BD"

        var xhr = new XMLHttpRequest();

        shinyEnviado = {
            id: shiny.id,
            nombre: shiny.nombre,
            foto: shiny.shiny_sprite
        }

        //Con conexión a través de POST los datos van en el xhr.send
        xhr.open("POST", "http://" + location.host + "/shiny/AddShiny");

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send(JSON.stringify(shinyEnviado));
    }

    shiny.encuentros += parseInt(encuentros)

    fetch("http://" + location.host + "/usuarios/GetUser", {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    }).then(function (resp) {
        resp.text().then(function (user) {
            document.cookie = 'shiny' + user + "=" + JSON.stringify(shiny) + ';expires=' + date;

        })
    })
    document.getElementById("pContador").innerHTML = "Encuentros: " + shiny.encuentros
}


function removeChildNodes(parent) {
    while (parent.childNodes.length > 1) {
        parent.removeChild(parent.lastChild);
    }

}

function interfazEncuentros(datos, generation) {
    var img = document.getElementById('imgShiny');
    document.getElementById("pResultado").innerHTML = ""

    img.src = datos.sprites.front_default;
    img.style.visibility = "visible";

    document.getElementById("encuentros").disabled = false


    var img = document.getElementById('imgShiny');
    img.id = "imgShiny";




    shiny = new Shiny(datos.id, datos.name, generation, datos.sprites.front_default, datos.sprites.front_shiny, 0);

    if (parseInt(generation) < 6) {
        odds = 8192;
        shiny.random = Math.floor(Math.random() * odds);
    }
    else {
        odds = 4096;
        shiny.random = Math.floor(Math.random() * odds);

    }
    document.getElementById("pContador").innerHTML = "Encuentros: " + shiny.encuentros;
    fetch("http://" + location.host + "/usuarios/GetUser", {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    }).then(function (resp) {
        resp.text().then(function (user) {
            document.cookie = 'shiny' + user + "=" + JSON.stringify(shiny) + ';expires=' + date;

        })
    })

}
document.getElementById("popoverShiny").setAttribute("data-bs-content", Shiny.funcionamiento());


var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})


document.getElementById("myBtn").onclick = function () {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
