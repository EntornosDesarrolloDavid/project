select1=document.getElementsByName("poketipo[cod_tipo1]")[0];
select2=document.getElementsByName("poketipo[cod_tipo2]")[0];
select2.disabled=true;
select1.onchange=function(){
    if (select1.value=="") {
        console.log(select1.value);
        select2.disabled=true;
    }
    else{
        select2.disabled=false;

    }
}