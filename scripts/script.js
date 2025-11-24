function showCadastro(){
    const caixaCad = document.querySelector(".caixa-sec-cadastro");

    caixaCad.style.display = "flex";
}

function showEsqueceu(){
    const caixaEsq = document.querySelector(".caixa-sec-esqueceu");

    caixaEsq.style.display = "flex";
}

function showMovimentacao(){
    const caixaMov = document.querySelector(".caixa-sec-movimentacao");

    caixaMov.style.display = "flex";
}

// Abre modal de editar preenchendo com os dados da tabela
function editarProduto(row) {
    const cols = row.querySelectorAll("td");

    document.getElementById("edit_nome").value = cols[1].textContent;
    document.getElementById("edit_descricao").value = cols[2].textContent;
    document.getElementById("edit_unidade").value = cols[3].textContent;
    document.getElementById("edit_quantidade").value = cols[4].textContent;
    document.getElementById("edit_minimo").value = cols[5].textContent;

    document.querySelector(".caixa-sec-edit").style.display = "flex";
}

function fecharEdit() {
    document.querySelector(".caixa-sec-edit").style.display = "none";
}

// Ativa o botão "Editar" de cada linha
document.querySelectorAll("#editar").forEach(btn => {
    btn.addEventListener("click", function () {
        const linha = this.closest("tr");
        editarProduto(linha);
    });
});
