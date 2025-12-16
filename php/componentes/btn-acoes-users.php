<td>                                       <!-- Início de célula de tabela HTML -->
    <div class="caixa-acoes">              <!-- Div com classe para estilização CSS -->
        <!-- quando for clicado vai executar showEdit com id do usuario de parametro  -->
        <button onclick="showEdit(<?php echo $linha['id']; ?>)" class="botao-editar"><i class="bi bi-pencil-square"></i><span>Editar</span></button>
        <!-- 
        Cria um botão "Editar" que quando clicado chama a função JavaScript showEdit()
        passando o ID do usuário como parâmetro
        - onclick="showEdit(<?php echo $linha['id']; ?>)" - Evento JavaScript que chama showEdit com ID
        - class="botao-editar" - Classe CSS para estilização
        - <i class="bi bi-pencil-square"></i> - Ícone Bootstrap de lápis
        - <span>Editar</span> - Texto do botão
        -->
        
        <!-- quando for clicado vai enviar para php/del_ usuario.php passando o id do usuario via get -->
         <?php
            if($user_name == $linha['nome']){  // Se o nome do usuário atual for igual ao nome do usuário na linha
                
            } else{  // Se não for o mesmo usuário

         ?>
        <!-- 
        Bloco condicional PHP:
        - Verifica se $user_name (provavelmente o usuário logado) é igual a $linha['nome'] (usuário na tabela)
        - Se for o mesmo usuário: não exibe o botão de remover (evita que o usuário se delete)
        - Se for usuário diferente: exibe o botão de remover
        -->
        
        <button class="botao-remover" onclick="window.location.href='php/usuarios/del_usuario.php?id=<?php echo $linha['id'] ?>'"><i class="bi bi-trash3-fill"></i><span>Remover</span></button>
        <!-- 
        Cria um botão "Remover" que quando clicado redireciona para a página de exclusão
        - onclick="window.location.href='php/usuarios/del_usuario.php?id=<?php echo $linha['id'] ?>'" - Redireciona para del_usuario.php com ID via GET
        - class="botao-remover" - Classe CSS para estilização
        - <i class="bi bi-trash3-fill"></i> - Ícone Bootstrap de lixeira
        - <span>Remover</span> - Texto do botão
        -->
        
        <?php }?>  <!-- Fecha o bloco else do PHP -->
    </div>  <!-- Fecha a div caixa-acoes -->
</td>  <!-- Fecha a célula da tabela -->
