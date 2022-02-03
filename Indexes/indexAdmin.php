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

<h2>Seja Bem-Vindo, senhor Admin <?php echo $_SESSION['nome']['NOME'];?></h2>

    <p>
        Para remover um médico dos registros de seu hospital, clique sobre o seu nome:<br>
    </p>

    <?php foreach ($medicos as $paciente) { ?>
        <p>
            <a href="removemedico.php?id=<?php echo $paciente['ID_Pessoa']; ?>">
                Paciente: <?php echo $paciente['Nome']; ?> 
            <a> <br>
            Contato: <?php echo $paciente['Telefone']; ?> <br>
            CRM: <?php echo $paciente['CRM']; ?>
        </p>
    <?php } ?>

    <form method="POST" action="adicionaMedico.php?idAdmin=<?php echo $id; ?>" class="formulario">
      <div class="form-entrada">
        <label>CPF do médico: </label><input type="number" name="cpf" id="cpf" class="entrada" required>
      </div>
      <div class="cadastrar">
        <input type="submit" value="Adicionar à lista" id="adicionar" name="adicionar" class="entrada">
      </div>
    </form>

    <div class="container-botao">
        <a class="botao" href="../cadastro/Cadastro.html">Cadastre seus constituintes</a>
    </div>

<h2><a href="logout.php">Sair</a></h2>