var aciertos=0;

document.getElementById("bPalabra").onclick=function(){
    var palabra= document.getElementById("iPalabra").value;

    var arraySpan=document.getElementsByTagName("span");
    var exp= new RegExp("^"+palabra+"$","i")
    for (const i in arraySpan) {
        if(exp.test(arraySpan[i].innerHTML) && arraySpan[i].className != "spanNormal"){
            arraySpan[i].className="spanNormal";
            aciertos++;
            var audio = new Audio('/imagenes/aplicacion/reward.mp3');
            audio.play();
        }
    }    

    if (aciertos==15) {
        document.getElementById("pAdivinar").style.fontFamily='Lucida Sans';
        document.getElementById("pAdivinar").innerHTML="¡Felicidades! El mensaje era: "+document.getElementById("pAdivinar").innerHTML
    }
    document.getElementById("iPalabra").focus();
    document.getElementById("iPalabra").value="";

}


document.getElementById("bTranslate").onclick=function(){
    document.getElementById("translation").innerHTML=document.getElementById("textTranslate").value
}