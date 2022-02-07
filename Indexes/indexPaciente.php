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

<body>
    <h2>Seja Bem-Vindo, senhor(a) Paciente(a) <?php echo $nome;?></h2>

    <p>Sua lista de sinais:</p>

    <p>
        <a href="mostraOxi.php?id=<?php echo $id; ?>">Oxigenação<a>
        <a href="mostraPressao.php?id=<?php echo $id; ?>">Pressão<a>
        <a href="mostraRitmo.php?id=<?php echo $id; ?>">Ritmo Cardíaco<a>
        <a href="mostraTemp.php?id=<?php echo $id; ?>">Temperatura<a>
    </p>

    <p>Cuidador atual(clique para removê-lo):</p>
    <?php foreach ($cuidador as $cui) { ?>
    <p>
        <a class="medico" href="removecuidador.php?id=<?php echo $id; ?>">
            Cuidador: <?php echo $cui['Nome']; ?><br>
        </a>
        <a class="medico">
            Contato: <?php echo $cui['Telefone']; ?>
        </a>
    </p >
    <?php } ?>


    <p>Atualize seu cuidador:</p>

    <form method="POST" action="mudaCuidador.php?idPaciente=<?php echo $id; ?>" class="formulario">

        <label id="cpf_m">Insira o CPF do novo cuidador: </label>
        <div class = "cadastro">
            <input type="number" name="cpf" id="cpf" required>
            <input type="submit" value="Adicionar" id="adicionar" name="adicionar">

        </div>

    </form>

    <h2><a href="logout.php">Sair</a></h2>
</body>