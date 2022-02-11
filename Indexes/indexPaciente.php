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