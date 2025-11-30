<?php
    $atualmente = basename($_SERVER['PHP_SELF']);
    // Aqui eu estou "lendo" a URL vai me retornar o caminho que estou.
    // echo "<script>alert('$atualmente')</script>";
?>
<nav class="sidebar">
    <div class="sidebar-header">
        <img src="assets/imgs/logo.png" alt="Logo ERP">
        <h1>ERP System</h1>
    </div>

    <div class="sidebar-links">
        <a href="principal.php" class="<?php if($atualmente == 'principal.php') echo "ativo" ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="estoque.php" class="<?php if($atualmente == 'estoque.php') echo "ativo" ?>">
            <i class="bi bi-box-seam"></i> Estoque
        </a>
        <a href="produto.php" class="<?php if($atualmente == 'produto.php') echo "ativo" ?>">
            <i class="bi bi-cart4"></i> Produtos
        </a>
        <?php 
        if($atualmente == 'usuario.php'){
            $ativo = 'ativo';
        } else{
            $ativo = '';
        }

        if($_SESSION['user_permissao'] == "ADMIN"){
            echo "<a href='usuario.php' class='$ativo'>";
            echo "<i class='bi bi-file-earmark-person'></i> Usuários";
            echo "</a>";
        }
        ?>
    </div>

    <div class="sidebar-footer">
        <a href="php/sair.php" class="btn-sair">
            <i class="bi bi-box-arrow-right"></i> Sair
        </a>
    </div>
</nav>