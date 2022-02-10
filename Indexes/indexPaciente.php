<?php
    session_start();
    include('verifica_login.php');

    $id = $_SESSION['nome']['ID_PESSOA'];
    $nome = $_SESSION['nome']['NOME'];

    $mysql = new mysqli('localhost', 'root', '', 'recare');

    $select = "SELECT pessoa.ID_Pessoa, pessoa.Nome, pessoa.Telefone FROM pessoa 
        INNER JOIN paciente
        ON pessoa.ID_Pessoa = paciente.ID_Cuidador 
        WHERE paciente.ID_Paciente = $id";

    $result = $mysql->query($select);
    $cuidador = $result->fetch_all(MYSQLI_ASSOC);

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
        <h1 style="margin: 0 auto;">Sua lista de sinais:</h1>
    </div>
    <p class="linha">

        <a style="color:black; text-decoration: none; "
            href="mostraOxi.php?id=<?php echo $paciente['ID_Pessoa']; ?>">O2</a>
        <a style="color:black; text-decoration: none;"
            href="mostraPressao.php?id=<?php echo $paciente['ID_Pessoa']; ?>">P</a>
        <a style="color:black; text-decoration: none;"
            href="mostraRitmo.php?id=<?php echo $paciente['ID_Pessoa']; ?>">RC</a>
        <a style="color:black; text-decoration: none;"
            href="mostraTemp.php?id=<?php echo $paciente['ID_Pessoa']; ?>">T°</a>

    </p>

    <p class="linha">Cuidador atual (clique para removê-lo):
        <?php foreach ($cuidador as $cui) { ?>
        <a style="color:black; text-decoration: none;" href="removecuidador.php?id=<?php echo $id; ?>">
            Cuidador: <?php echo $cui['Nome']; ?></a>
        <a style="color:black; text-decoration: none;">
            Contato: <?php echo $cui['Telefone']; ?>
        </a>
    </p>
    <?php } ?>
    
    <form method="POST" action="mudaCuidador.php?idPaciente=<?php echo $id; ?>" class="formulario linha">
        <label class="atualizacao">Atualize seu cuidador: </label>
        <div class="cadastro">
            <input type="number" name="cpf" id="cpf" required>
            <input type="submit" value="Adicionar" id="adicionar" name="adicionar">
        </div>
    </form>
    </section>