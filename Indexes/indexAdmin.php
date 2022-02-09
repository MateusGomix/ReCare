<?php
    session_start();
    include('verifica_login.php');

    $mysql = new mysqli('localhost', 'root', '', 'recare');
    //$mysql->set_charset('utf-8');

    $id = $_SESSION['nome']['ID_PESSOA'];
    $nome = $_SESSION['nome']['NOME'];

    setcookie("adminID", $id, time() + (86400 * 30), "/"); // 86400 = 1 day

    $select = "SELECT pessoa.ID_Pessoa, pessoa.Nome, pessoa.Telefone, medico.CRM FROM pessoa 
        INNER JOIN medico 
        ON pessoa.ID_Pessoa = medico.ID_Medico 
        INNER JOIN AtendeEm
        ON medico.ID_Medico = AtendeEm.ID_Medico
        INNER JOIN Hospital
        ON Hospital.ID_Hospital = AtendeEm.ID_Hospital
        WHERE hospital.ID_Admin = $id";

    $result = $mysql->query($select);
    $medicos = $result->fetch_all(MYSQLI_ASSOC);

?>
<link rel="stylesheet" href="../css/indexAdmin.css" type="text/css">
<link rel="stylesheet" href="../css/cadastro-cabecalho.css" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" rel="stylesheet">

<header>
    <div class="cabecalho">
        <nav>
            <ul style="width: 50%; margin: unset;">
                <label>Re<span id="color">Care</span></label>
                <li><a href="../cadastro/Cadastro.html">CADASTRAR</a></li>
                <li><a href="logout.php">SAIR</a></li>
            </ul>
            <p id="usuario">Usuário(a): <?php echo $_SESSION['nome']['NOME'];?>
            <p>

        </nav>
    </div>
</header>
<section>
    <div id="titulo">
        <h1>Insira o CPF do médico a ser adcionado, ou clique para removê-lo</h1>
    </div>

    <?php foreach ($medicos as $paciente) { ?>
    <p>
        <a class="medico" href="removemedico.php?id=<?php echo $paciente['ID_Pessoa']; ?>">
            Médico: <?php echo $paciente['Nome']; ?>
        </a>
        <a class="medico">
            Contato: <?php echo $paciente['Telefone']; ?>
        </a>
        <a class="medico">
            CRM: <?php echo $paciente['CRM']; ?>
        </a>
    </p >

    <?php } ?>
    <div class="secao">
        <form method="POST" action="adicionaMedico.php?idAdmin=<?php echo $id; ?>" class="formulario">

            <label id="cpf_m">CPF do médico: </label>
            <div class = "cadastro">
                <input type="number" name="cpf" id="cpf" required>
                <input type="submit" value="Adicionar" id="adicionar" name="adicionar">

            </div>

        </form>
    </div>

    </form>