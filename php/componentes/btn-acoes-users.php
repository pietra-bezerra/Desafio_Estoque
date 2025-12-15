<td>
    <div class="caixa-acoes">
        <!-- quando for clicado vai executar showEdit com id do usuario de parametro  -->
        <button onclick="showEdit(<?php echo $linha['id']; ?>)" class="botao-editar"><i class="bi bi-pencil-square"></i><span>Editar</span></button>
        <!-- quando for clicado vai enviar para php/del_ usuario.php passando o id do usuario via get -->
         <?php
            if($user_name == $linha['nome']){
                
            } else{

         ?>
        <button class="botao-remover" onclick="window.location.href='php/usuarios/del_usuario.php?id=<?php echo $linha['id'] ?>'"><i class="bi bi-trash3-fill"></i><span>Remover</span></button>
        <?php }?>
    </div>
</td>