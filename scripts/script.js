function showMovimentacao() {
    document.getElementById('modalMovimentacao').style.display = 'flex';
}

function closeMovimentacao() {
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