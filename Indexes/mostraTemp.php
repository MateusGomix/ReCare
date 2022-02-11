<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

$selectPaciente = $mysql->prepare('SELECT pessoa.Nome, paciente.TelefoneContato 
                                    FROM pessoa INNER JOIN paciente 
                                    ON pessoa.ID_Pessoa = paciente.ID_Paciente
                                    WHERE pessoa.ID_Pessoa = ?');
$selectPaciente->bind_param('s', $_GET['id']);
$selectPaciente->execute();
$paciente = $selectPaciente->get_result()->fetch_assoc();

$idPaciente = $_GET['id'];

$select = "SELECT Sinal.valor, Sinal.dataHora
            FROM pessoa 
            INNER JOIN paciente ON paciente.ID_Paciente = pessoa.ID_Pessoa
            INNER JOIN sensortemp ON sensorTemp.ID_Paciente = pessoa.ID_Pessoa
            INNER JOIN Sinal ON sensortemp.ID_Temp = Sinal.ID_Temp
            WHERE pessoa.ID_Pessoa = $idPaciente
            ORDER BY Sinal.dataHora";

$result = $mysql->query($select);
$sinais = $result->fetch_all(MYSQLI_ASSOC);

$selectSensor = $mysql->prepare('SELECT ID_Temp 
                                    FROM pessoa INNER JOIN SensorTemp 
                                    ON pessoa.ID_Pessoa = sensorTemp.ID_Paciente
                                    WHERE pessoa.ID_Pessoa = ?');
$selectSensor->bind_param('s', $_GET['id']);
$selectSensor->execute();
$sensor = $selectSensor->get_result()->fetch_assoc();

?>

<link rel="stylesheet" href="../css/indexAdmin.css" type="text/css">

<link rel="stylesheet" href="../css/cadastro-cabecalho.css" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" rel="stylesheet">

<div style="height:100vh;">
    <header>
        <div class="cabecalho">
            <nav>
                <ul style="width: 50%; margin: unset;">
                    <label>Re<span id="color">Care</span></label>
                    <li><a href="indexMedico.php">PACIENTES</a></li>
                    <li><a href="logout.php">SAIR</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section>
        <div id="titulo">
            <h1 style="margin: 0 auto;">Temperatura do paciente: <?php echo $paciente['Nome'] ?></h1>
        </div>
        <p class="linha">

            <a class="medico">Contato: <?php echo $paciente['TelefoneContato'] ?></a>
            <a class="medico">ID do sensor: <?php if($sensor!= null)echo $sensor['ID_Temp'];
                                else echo "nenhum sensor registrado" ?></a>
        <table class="medico">

            <tr>
                <th>Data e hora</th>
                <th>:</th>
                <th>Temperatura</th>
            </tr>

            <?php foreach ($sinais as $sinal) { ?>
            <tr>
                <td><?php echo $sinal['dataHora']; ?></td>
                <td>:</td>
                <td><?php echo $sinal['valor']; ?></td>
            </tr>
            <?php }?>
        </table>
        </p>
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
    <span style=    "font-size: 18px;
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