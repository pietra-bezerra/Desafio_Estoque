function mudarTema(){
    var tema = document.getElementById("temaSelecionado");

    if(tema.className.match("temaNoturno")){
        tema.innerHTML = '<i class="bi bi-sun-fill"></i>';
        tema.className = "temaDiurno";
    } else {
        tema.innerHTML = '<i class="bi bi-moon-stars-fill"></i>';
        tema.className = "temaNoturno";
    }
}