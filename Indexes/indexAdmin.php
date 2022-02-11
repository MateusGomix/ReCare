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


<div style="height:100vh">

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
    <p class="linha">
        <a class="medico" href="removemedico.php?id=<?php echo $paciente['ID_Pessoa']; ?>">
            Médico: <?php echo $paciente['Nome']; ?>
        </a>
        <a class="medico">
            Contato: <?php echo $paciente['Telefone']; ?>
        </a>
        <a class="medico">
            CRM: <?php echo $paciente['CRM']; ?>
        </a>
    </p>

    <?php } ?>

    <form method="POST" action="adicionaMedico.php?idAdmin=<?php echo $id; ?>" class="formulario">
        <div class="busca_cpf">
            <label id="cpf_m">CPF do médico: </label>
        </div>
        <div class="busca_cpf">
            <input type="number" name="cpf" id="cpf" required>
        </div>
        <div class="busca_cpf">
            <input type="submit" value="Adicionar" id="adicionar" name="adicionar">
        </div>

    </form>


</div>
    <footer style=" box-shadow: 0 0 1em rgb(0 0 0 / 50%); background-color:rgb(23,86,155);">
        <div style=" display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;">

            <span style="font-size: 18px;color: white;
            font-family: 'Rubik';
            font-style: normal;
            font-weight: normal;
            line-height: 24px;
            justify-content: center;
            text-align: center;">
                <p>Site desenvolvido para matéria de Engenharia de Software
                </p>
            </span>

            <div>
                <div>
                    <div style="font-size: 18px; color: white; flex-direction: column; display: flex;
                    align-items: flex-start; margin: 0 auto; font-family: 'Rubik' ; font-style: normal; font-weight:
                    normal; line-height: 24px; margin: -10px 0px 30px 45px;">
                        <h2 style=" font-weight: 300;"> Desenvolvedores:</h2>

                        <li style="list-style-type: none"><a style="text-decoration:none; color: white;"
                                href="https://github.com/BeatrizIrineu"><img style="width: 25px;margin-right: 10px;"
                                    src="../image/git.png">Beatriz Irineu</a></li>
                        <li style="list-style-type: none"><a style="text-decoration:none; color: white;"
                                href="https://github.com/dspaiva123"><img style="width: 25px;margin-right: 10px;"
                                    src="../image/git.png">Daniel Paiva</a></li>
                        <li style="list-style-type: none"><a style="text-decoration:none; color: white;"
                                href="https://github.com/BnnSplt"><img style="width: 25px;margin-right: 10px;"
                                    src="../image/git.png">Felipe Cassiano</a></li>
                        <li style="list-style-type: none"><a style="text-decoration:none; color: white;"
                                href="https://github.com/Luizpson"><img style="width: 25px;margin-right: 10px;"
                                    src="../image/git.png">Luiz Felipe</a></li>
                        <li style="list-style-type: none"><a style="text-decoration:none; color: white;"
                                href="https://github.com/MateusGomix"><img style="width: 25px;margin-right: 10px;"
                                    src="../image/git.png">Mateus Gomes</a></li>

                    </div>



                </div>
            </div>
    </footer>
    <div style=" box-shadow: 0 0 1em rgb(0 0 0 / 50%); height:6vh; background-color:white;">
        <span style="font-size: 18px;
    color: black;
    font-family: 'Rubik';
    font-style: normal;
    font-weight: normal;
    line-height: 24px;
    justify-content: center;
    display: flex;
    height: 100%;
    align-items: center;">2022. Todos os direitos reservados.</span>
    </div>