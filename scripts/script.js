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

function showCadastro(){
    const caixaCad = document.querySelector(".caixa-sec-cadastro");

    caixaCad.style.display = "flex";
}

function showEsqueceu(){
    const caixaEsq = document.querySelector(".caixa-sec-esqueceu");

    caixaEsq.style.display = "flex";
}