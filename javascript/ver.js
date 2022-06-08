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