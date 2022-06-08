var imagenes=document.getElementsByClassName("trainer");

for (const i of imagenes) {
    i.addEventListener("click", function(){

        if(document.getElementsByClassName("preVisu")[0]){
            document.getElementsByClassName("preVisu")[0].remove();
        }
        var preVisu=i.cloneNode();
        preVisu.className="preVisu";
        preVisu.alt="trainerSeleccionado";
        imagen=preVisu.src.split("/");
        console.log(imagen[imagen.length-1])
        document.getElementById("imgTrainer").value=imagen[imagen.length-1];
        document.getElementById("formRegister").insertBefore(preVisu, document.getElementById("imgTrainer"));
    })
}