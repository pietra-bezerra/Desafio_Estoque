<td>
    <div class="caixa-acoes">
        <button onclick="showEdit(<?php echo $linha['idgestao']; ?>)" class="botao-editar"><i class="bi bi-pencil-square"></i><span>Editar</span></button>
        <button class="botao-remover" onclick="window.location.href='php/del_produto.php?id_produto=<?php echo $linha['idgestao'] ?>'"><i class="bi bi-trash3-fill"></i><span>Remover</span></button>
    </div>
</td>