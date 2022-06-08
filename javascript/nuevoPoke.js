var expRegular= new RegExp(/^[A-Z]{1}[a-z]+mon$/);

if (!expRegular.test(document.getElementById("nombre").value)) {
    document.getElementsByClassName("buttonPoke")[0].disabled=true;

}


document.getElementById("nombre").onkeyup=function(){
    let nombre=this.value;


    if (!expRegular.test(nombre)) {
        document.getElementsByClassName("buttonPoke")[0].disabled=true;
        document.getElementById("errorNombre").style.visibility="visible";
        document.getElementById("errorNombre").innerHTML="El nombre debe empezar con mayúscula y terminar en -mon"

    }
    else{
        document.getElementById("errorNombre").innerHTML=""
        document.getElementById("errorNombre").style.visibility="hidden";

        document.getElementsByClassName("buttonPoke")[0].disabled=false;
    }


}