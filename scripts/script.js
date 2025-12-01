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
        if (txtNaLinha.includes(termo)) {
            linhas[i].style.display = '';
        } else {
            linhas[i].style.display = 'none';
        }
    }
}

// valido se a movimentacao saida se a quantidade q tenho no estoque nao for o suficiente para realizar a saida eu n permito e alerto o usuario
function validarMovimentacao() {
    var operacao = document.getElementById('tipo').value;
    if (operacao == "Entrada") {
        return true; // entrada sempre aceitamos
    } else {
        var produto = document.getElementById('produto');
        var estoqueAtual = produto.selectedOptions[0].dataset.qntd;
        var quantidade = document.getElementById('quantidade');
        if (estoqueAtual < quantidade.value) {
            document.getElementById('erro-msg').innerText = "Não há estoque suficiente!";
            quantidade.focus();
            return false; // nao deixo enviar se a quantidade for maior que o estoque atual
        }
        return true; // envio se a quantidade for ok
    }
}

// valido se o usuario nao selecionou nenhuma unidade de medida
function validarCadastroProduto() {
    var unidade = document.getElementById("unidade").value

    if (unidade == "sem Valor") {
        document.getElementById("erro-msg-unidade").innerText = "Por-favor selecione uma unidade de medida!";
        return false;
    } else {
        erroMsg.innerText = ""; // limpa mensagem de erro
    }

    return true; // formulário ok

}

const regex = /^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/;

function validarEditCPF() {
    var cpf = document.getElementById('edit-cpf').value;
    if (regex.test(cpf)) {
        document.getElementById('erro-msg-edit-cpf').innerText = '';
    } else {
        document.getElementById('erro-msg-edit-cpf').innerText = 'CPF inválido!';
        return false;
    }

    return true;
}

function validarCPF() {
    var cpf = document.getElementById('cpf').value;
    if (regex.test(cpf)) {
        document.getElementById('erro-msg-cpf').innerText = '';
    } else {
        document.getElementById('erro-msg-cpf').innerText = 'CPF inválido!';
        return false;
    }

    return true;
}

