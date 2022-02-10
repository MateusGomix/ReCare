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
        WHERE paciente.ID_Medico = $id";

    $result = $mysql->query($select);
    $pacientes = $result->fetch_all(MYSQLI_ASSOC);
?>
<link rel="stylesheet" href="../css/indexAdmin.css" type="text/css">
<link rel="stylesheet" href="../css/cadastro-cabecalho.css" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" rel="stylesheet">

<header>
    <div class="cabecalho">
        <nav style="width: 82%">
            <ul style="width: 50%; margin: unset;">
                <label>Re<span id="color">Care</span></label>
                <li><a href="logout.php">SAIR</a></li>
            </ul>
            <p id="usuario">Usuário(a): <?php echo $nome;?>
            </p>

        </nav>
    </div>
</header>

<!-- <h2>Seja Bem-Vindo, senhor(a) Médico(a) <?php echo $nome;?></h2> -->
<section>
    <div id="titulo">
        <h1 style="margin: 0 auto;">Sua lista de Pacientes</h1>
    </div>

    <?php foreach ($pacientes as $paciente) { ?>
    <p class="linha">

        <a>Paciente: <?php echo $paciente['Nome']; ?></a>
        </a>Contato: <?php echo $paciente['TelefoneContato']; ?></a>

        <a style="color:black; text-decoration: none;"
            href="mostraOxi.php?id=<?php echo $paciente['ID_Pessoa']; ?>">O2</a>
        <a style="color:black; text-decoration: none;"
            href="mostraPressao.php?id=<?php echo $paciente['ID_Pessoa']; ?>">P</a>
        <a style="color:black; text-decoration: none;"
            href="mostraRitmo.php?id=<?php echo $paciente['ID_Pessoa']; ?>">RC</a>
        <a style="color:black; text-decoration: none;"
            href="mostraTemp.php?id=<?php echo $paciente['ID_Pessoa']; ?>">T°</a>
    </p>
    <?php } ?>

</section>