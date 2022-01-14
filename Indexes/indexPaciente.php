<?php
    session_start();
    include('verifica_login.php');
?>

<h2>Seja Bem-Vindo, senhor Paciente <?php echo $_SESSION['nome'];?></h2>
<h2><a href="logout.php">Sair</a></h2>