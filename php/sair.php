<?php
session_start();
#inicio a sessao
session_unset();
#removo todas as variaveis de sessao
session_destroy();
# aqui destrui a sessao
header('Location: ../index.php');
# volta para index.php (tela de login)
