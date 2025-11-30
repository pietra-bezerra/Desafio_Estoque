function showMovimentacao() {
    document.getElementById('modalMovimentacao').style.display = 'flex';
}

function closeMovimentacao() {
    document.getElementById('modalMovimentacao').style.display = 'none';
}

function showEdit(id) {
    // Em uma aplicação real, você preencheria os campos do modal com os dados do produto clicado.
    document.getElementById('modalEdicao').style.display = 'flex';
    document.getElementById('edit-id').value = id;
}

function closeEdit() {
    document.getElementById('modalEdicao').style.display = 'none';
}

// Inicializa o modal de movimentação como oculto
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('modalMovimentacao').style.display = 'none';
    document.getElementById('modalEdicao').style.display = 'none';
});