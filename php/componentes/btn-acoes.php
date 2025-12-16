<td>                                       <!-- Início de célula de tabela HTML -->
    <div class="caixa-acoes">              <!-- Div com classe para estilização CSS -->
        <!-- quando for clicado vai executar showEdit com id do produto de parametro  -->
        <button onclick="showEdit(<?php echo $linha['idgestao']; ?>)" class="botao-editar"><i class="bi bi-pencil-square"></i><span>Editar</span></button>
        <!-- 
        Cria um botão "Editar" que quando clicado chama a função JavaScript showEdit()
        passando o ID do produto (idgestao) como parâmetro
        - onclick="showEdit(<?php echo $linha['idgestao']; ?>)" - Evento JavaScript que chama showEdit com ID
        - class="botao-editar" - Classe CSS para estilização
        - <i class="bi bi-pencil-square"></i> - Ícone Bootstrap de lápis
        - <span>Editar</span> - Texto do botão
        -->
        
        <!-- quando for clicado vai enviar para php/del_ produto.php passando o id do produto via get -->
        <button class="botao-remover" onclick="window.location.href='php/produtos/del_produto.php?id_produto=<?php echo $linha['idgestao'] ?>'"><i class="bi bi-trash3-fill"></i><span>Remover</span></button>
        <!-- 
        Cria um botão "Remover" que quando clicado redireciona para a página de exclusão
        - onclick="window.location.href='php/produtos/del_produto.php?id_produto=<?php echo $linha['idgestao'] ?>'" - Redireciona para del_produto.php com ID via GET
        - class="botao-remover" - Classe CSS para estilização
        - <i class="bi bi-trash3-fill"></i> - Ícone Bootstrap de lixeira
        - <span>Remover</span> - Texto do botão
        -->
    </div>  <!-- Fecha a div caixa-acoes -->
</td>  <!-- Fecha a célula da tabela -->
