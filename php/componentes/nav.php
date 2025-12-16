<?php
    $atualmente = basename($_SERVER['PHP_SELF']);  // Obtém o nome do arquivo PHP atual
    // basename() extrai apenas o nome do arquivo do caminho completo
    // $_SERVER['PHP_SELF'] contém o caminho do script atual
    // $atualmente armazenará algo como "principal.php", "estoque.php", etc.
    
    // pega o nome do arquivo atual que está sendo executado
    // echo "<script>alert('$atualmente')</script>";  // Linha comentada que mostraria um alerta com o nome do arquivo
?>
<!-- Fim do bloco PHP -->

<nav class="sidebar">  <!-- Início da barra lateral de navegação -->
    <div class="sidebar-header">  <!-- Cabeçalho da sidebar -->
        <img src="assets/imgs/logo.png" alt="Logo ERP">  <!-- Imagem do logo -->
        <h1>BlockStone</h1>  <!-- Nome do sistema -->
    </div>

    <!-- o arquivo que eu estiver executando vai ficar com a classe ativo -->
    <div class="sidebar-links">  <!-- Container dos links de navegação -->
        <a href="principal.php" class="<?php if($atualmente == 'principal.php') echo "ativo" ?>">  <!-- Link para Dashboard -->
            <!-- 
            Link para principal.php com classe condicional:
            - Se $atualmente for igual a 'principal.php', adiciona classe "ativo"
            - Caso contrário, não adiciona nada (string vazia)
            -->
            <i class="bi bi-speedometer2"></i> Dashboard  <!-- Ícone e texto -->
        </a>
        
        <a href="estoque.php" class="<?php if($atualmente == 'estoque.php') echo "ativo" ?>">  <!-- Link para Estoque -->
            <!-- 
            Link para estoque.php com classe condicional:
            - Se $atualmente for igual a 'estoque.php', adiciona classe "ativo"
            -->
            <i class="bi bi-box-seam"></i> Estoque  <!-- Ícone e texto -->
        </a>
        
        <a href="produto.php" class="<?php if($atualmente == 'produto.php') echo "ativo" ?>">  <!-- Link para Produtos -->
            <!-- 
            Link para produto.php com classe condicional:
            - Se $atualmente for igual a 'produto.php', adiciona classe "ativo"
            -->
            <i class="bi bi-cart4"></i> Produtos  <!-- Ícone e texto -->
        </a>
        
        <?php 
        # se eu estiver em usuario.php a variavel ativo tera o valor 'ativo' senão vai ter ''
        if($atualmente == 'usuario.php'){  // Verifica se o arquivo atual é usuario.php
            $ativo = 'ativo';  // Se sim, define $ativo como 'ativo'
        } else{  // Se não for usuario.php
            $ativo = '';  // Define $ativo como string vazia
        }

        # caso a variavel de sessão user_permissao tiver o valor "ADMIN" vou exibir na barra de navegacao uma tag a que leva para usuario.php
        if($_SESSION['user_permissao'] == "ADMIN"){  // Verifica se o usuário tem permissão de ADMIN
            echo "<a href='usuario.php' class='$ativo'>";  // Cria link para usuario.php com classe condicional
            echo "<i class='bi bi-file-earmark-person'></i> Usuários";  // Ícone e texto do link
            echo "</a>";  // Fecha a tag <a>
        }
        // Nota: $_SESSION['user_permissao'] deve ter sido definida anteriormente no login
        ?>
    </div>

    <div class="sidebar-footer">  <!-- Rodapé da sidebar -->
        <a href="php/sair.php" class="btn-sair">  <!-- Link para sair do sistema -->
            <i class="bi bi-box-arrow-right"></i> Sair  <!-- Ícone e texto -->
        </a>
    </div>
</nav>  <!-- Fim da barra lateral -->
