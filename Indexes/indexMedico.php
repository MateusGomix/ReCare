<?php
    session_start();
    include('verifica_login.php');

    $mysql = new mysqli('localhost', 'root', '', 'recare');
    $mysql->set_charset('utf-8');

    $id = $_SESSION['nome']['ID_PESSOA'];
    $nome = $_SESSION['nome']['NOME'];

    $select = "SELECT pessoa.Nome, paciente.TelefoneContato FROM pessoa 
        INNER JOIN paciente 
        ON pessoa.ID_Pessoa = paciente.ID_Paciente 
        WHERE paciente.ID_Medico = $id";

    $result = $mysql->query($select);
    $pacientes = $result->fetch_all(MYSQLI_ASSOC);
?>

<body>
    <h2>Seja Bem-Vindo, senhor Médico <?php echo $nome;?></h2>

    <?php foreach ($pacientes as $paciente) { ?>
        <p>
            Paciente: <?php echo $paciente['Nome']; ?> <br>
            Contato: <?php echo $paciente['TelefoneContato']; ?>
        </p>
    <?php } ?>

    <h2><a href="logout.php">Sair</a></h2>
</body>