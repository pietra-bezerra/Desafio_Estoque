function showMovimentacao() {
    // exibo a modal de movimentacao
    document.getElementById('modalMovimentacao').style.display = 'flex';
}

function closeMovimentacao() {
    // fecho a modal
    document.getElementById('modalMovimentacao').style.display = 'none';
}

function showEdit(id) {
    // exibo a modal de edicao
    document.getElementById('modalEdicao').style.display = 'flex';
    // o parametro id passa a ser o valor do campo edit-id em alguns formularios
    document.getElementById('edit-id').value = id;
}

function closeEdit() {
    // fecho a modal
    document.getElementById('modalEdicao').style.display = 'none';
}

// Inicializa o modal de movimentação como oculto
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('modalMovimentacao').style.display = 'none';
    document.getElementById('modalEdicao').style.display = 'none';
});

// se algo for digitado na barra de pesquisa, executo uma função que transforma o termo digitado em caixa baixa (minusuclo)
// depois coleto todas as linhas da no corpo da tabela
// faço um for para percorrer todas as linhas
// deixo os textos presentes na minha em caixa baixa
// se o texto da linha possuir oque foi digitado na barra, ela fica visivel já as outras ficam invisiveis

function pesquisar() {
    var termo = document.getElementById('pesquisa').value.toLowerCase();
    var linhas = document.querySelectorAll('tbody tr');

    for (let i = 0; i < linhas.length; i++) {
        var txtNaLinha = linhas[i].innerText.toLowerCase();
        if(txtNaLinha.includes(termo)){
            linhas[i].style.display = '';
        } else{
            linhas[i].style.display = 'none';
        }
    }
}