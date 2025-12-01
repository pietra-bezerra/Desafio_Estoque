<td>
    <div class="caixa-acoes">
        <!-- quando for clicado vai executar showEdit com id do produto de parametro  -->
        <button onclick="showEdit(<?php echo $linha['idgestao']; ?>)" class="botao-editar"><i class="bi bi-pencil-square"></i><span>Editar</span></button>
        <!-- quando for clicado vai enviar para php/del_ produto.php passando o id do produto via get -->
        <button class="botao-remover" onclick="window.location.href='php/produtos/del_produto.php?id_produto=<?php echo $linha['idgestao'] ?>'"><i class="bi bi-trash3-fill"></i><span>Remover</span></button>
    </div>
</td>