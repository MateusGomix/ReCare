<?php
    session_start();
    include('verifica_login.php');

    $mysql = new mysqli('localhost', 'root', '', 'recare');
    //$mysql->set_charset('utf-8');

    $id = $_SESSION['nome']['ID_PESSOA'];
    $nome = $_SESSION['nome']['NOME'];

    $select = "SELECT pessoa.ID_Pessoa, pessoa.Nome, paciente.TelefoneContato FROM pessoa 
        INNER JOIN paciente 
        ON pessoa.ID_Pessoa = paciente.ID_Paciente 
        WHERE paciente.ID_Cuidador = $id";

    $result = $mysql->query($select);
    $pacientes = $result->fetch_all(MYSQLI_ASSOC);

?>

<body>
    <h2>Seja Bem-Vindo, senhor(a) Cuidador(a) <?php echo $nome;?></h2>

    <p>Sua lista de pacientes:</p>

    <?php foreach ($pacientes as $paciente) { ?>
        <p>
            Paciente: <?php echo $paciente['Nome']; ?> <br>
            Contato: <?php echo $paciente['TelefoneContato']; ?> <br>
            <a href="mostraOxi.php?id=<?php echo $paciente['ID_Pessoa']; ?>">Oxigenação<a>
            <a href="mostraPressao.php?id=<?php echo $paciente['ID_Pessoa']; ?>">Pressão<a>
            <a href="mostraRitmo.php?id=<?php echo $paciente['ID_Pessoa']; ?>">Ritmo Cardíaco<a>
            <a href="mostraTemp.php?id=<?php echo $paciente['ID_Pessoa']; ?>">Temperatura<a>
        </p>
    <?php } ?>

    <h2><a href="logout.php">Sair</a></h2>
</body>