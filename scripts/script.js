function showMovimentacao() {
    // exibo a modal de movimentacao
    document.getElementById('modalMovimentacao').style.display = 'flex';
}
// Função que exibe a modal de movimentação
// - Obtém elemento com ID 'modalMovimentacao'
// - Altera a propriedade CSS display para 'flex' (torna visível)

function closeMovimentacao() {
    // fecho a modal
    window.location.href = 'php/limpar-dados.php';
    document.getElementById('modalMovimentacao').style.display = 'none';
}
// Função que fecha a modal de movimentação
// - Redireciona para 'php/limpar-dados.php' (provavelmente limpa dados temporários ou da sessão)
// - Altera display da modal para 'none' (oculta)

function closeMovimentacao2() {
    // fecho a modal
    window.location.href = 'php/limpar-dados2.php';
    document.getElementById('modalMovimentacao').style.display = 'none';
}
// Função alternativa para fechar a modal de movimentação
// - Similar à anterior, mas redireciona para 'php/limpar-dados2.php'
// - Possivelmente para diferentes tipos de dados ou contextos

function showEdit(id) {
    // exibo a modal de edicao
    document.getElementById('modalEdicao').style.display = 'flex';
    // o parametro id passa a ser o valor do campo edit-id em alguns formularios
    document.getElementById('edit-id').value = id;
}
// Função que exibe a modal de edição
// - Parâmetro 'id': ID do item a ser editado
// - Exibe a modal com ID 'modalEdicao'
// - Define o valor do campo oculto com ID 'edit-id' para o ID recebido

function closeEdit() {
    // fecho a modal
    document.getElementById('modalEdicao').style.display = 'none';
    window.location.href = 'php/limpar-dados.php';
}
// Função que fecha a modal de edição
// - Oculta a modal de edição
// - Redireciona para 'php/limpar-dados.php'

function closeEdit2() {
    // fecho a modal
    document.getElementById('modalEdicao').style.display = 'none';
    window.location.href = 'php/limpar-dados2.php';
}
// Função alternativa para fechar a modal de edição
// - Similar à anterior, mas redireciona para 'php/limpar-dados2.php'

// Inicializa o modal de movimentação como oculto
// document.addEventListener('DOMContentLoaded', () => {
//     document.getElementById('modalMovimentacao').style.display = 'none';
//     document.getElementById('modalEdicao').style.display = 'none';
// });
// Bloco de código comentado que inicializaria as modais como ocultas
// - Seria executado quando o DOM estivesse completamente carregado
// - Definiria display das modais como 'none'
// - Está comentado, possivelmente porque as modais já começam ocultas no HTML

// se algo for digitado na barra de pesquisa, executo uma função que transforma o termo digitado em caixa baixa (minusuclo)
// depois coleto todas as linhas da no corpo da tabela
// faço um for para percorrer todas as linhas
// deixo os textos presentes na minha em caixa baixa
// se o texto da linha possuir oque foi digitado na barra, ela fica visivel já as outras ficam invisiveis
function pesquisar() {
    var termo = document.getElementById('pesquisa').value.toLowerCase();
    // Obtém valor do campo de pesquisa e converte para minúsculas
    
    var linhas = document.querySelectorAll('tbody tr');
    // Seleciona todas as linhas (<tr>) dentro de <tbody>

    for (let i = 0; i < linhas.length; i++) {
        var txtNaLinha = linhas[i].innerText.toLowerCase();
        // Obtém todo o texto da linha atual e converte para minúsculas
        
        if (txtNaLinha.includes(termo)) {
            linhas[i].style.display = '';
            // Se a linha contém o termo, define display vazio (visível)
        } else {
            linhas[i].style.display = 'none';
            // Se não contém, oculta a linha
        }
    }
}

// valido se a movimentacao saida se a quantidade q tenho no estoque nao for o suficiente para realizar a saida eu n permito e alerto o usuario
function validarMovimentacao() {

    var produto = document.getElementById('produto');
    if (produto.value == 'Vazio') {
        document.getElementById('erro').innerText = "Selecione um Produto";
        return false;
    }
    // Valida se um produto foi selecionado
    // - Se o valor for 'Vazio', mostra mensagem de erro e retorna false

    var operacao = document.getElementById('tipo').value;
    if (operacao == "Entrada") {
        return true; // entrada sempre aceitamos
    } else {
        var produto = document.getElementById('produto');
        var estoqueAtual = produto.selectedOptions[0].dataset.qntd;
        // Obtém quantidade atual do estoque do atributo data-qntd da opção selecionada
        
        var quantidade = document.getElementById('quantidade');
        if (parseInt(estoqueAtual) < parseInt(quantidade.value)) {
            document.getElementById('erro-msg').innerText = "Não há estoque suficiente!";
            return false; // nao deixo enviar se a quantidade for maior que o estoque atual
        } else {
            return true; // envio se a quantidade for ok
        }
        // Para operações de "Saída":
        // - Compara estoque atual com quantidade desejada
        // - Se estoque insuficiente, mostra erro e retorna false
        // - Caso contrário, retorna true
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
        // Nota: 'erroMsg' não está definido, deveria ser 'erro-msg-unidade' ou elemento similar
    }

    return true; // formulário ok

}

// const regex = /^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/; //aceita tanto 222333444-55 quanto 222.333.444-55
// Regex para validação de CPF comentada
// - Aceita formatos: 22233344455, 222.333.444-55, 222333444-55

// function validarEditCPF() {
//     var cpf = document.getElementById('edit-cpf').value;
//
//     // Remove espaços em branco antes de testar
//     cpf = cpf.trim();
//
//     // Lógica: Se estiver vazio, limpa msg de erro e deixa passar
//     if (cpf === "") {
//         document.getElementById('erro-msg-edit-cpf').innerText = '';
//         return true;
//     }
//
//     // Se chegou aqui, é porque TEM texto, então aplica a Regex
//     if (regex.test(cpf)) {
//         document.getElementById('erro-msg-edit-cpf').innerText = '';
//         return true;
//     } else {
//         document.getElementById('erro-msg-edit-cpf').innerText = 'CPF inválido!';
//         return false;
//     }
// }
// Função comentada para validar CPF na edição
// - Permite campo vazio (limpa erro)
// - Se preenchido, valida com regex
// - Mostra mensagem de erro se inválido

// function validarCPF() {
//     var cpf = document.getElementById('cpf').value;
//     if (regex.test(cpf)) {
//         document.getElementById('erro-msg-cpf').innerText = '';
//     } else {
//         document.getElementById('erro-msg-cpf').innerText = 'CPF inválido!';
//         return false;
//     }
//
//     return true;
// }
// Função comentada para validar CPF no cadastro
// - Sempre valida (não permite vazio)
// - Retorna false se inválido

function maskCPF(input) {
    let value = input.value.replace(/\D/g, "");
    // Remove todos os caracteres não numéricos (/\D/g)
    
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    // Adiciona ponto após os primeiros 3 dígitos: 123456789 → 123.456789
    
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    // Adiciona ponto após os próximos 3 dígitos: 123.456789 → 123.456.789
    
    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    // Adiciona hífen antes dos últimos 2 dígitos: 123.456.789 → 123.456.789-12
    
    input.value = value;
    // Atualiza o valor do input com a máscara aplicada
}
// Função que aplica máscara de CPF
// - Formato final: 123.456.789-01
// - Executada provavelmente no evento 'oninput' dos campos de CPF
