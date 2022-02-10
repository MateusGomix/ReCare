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
            INNER JOIN sensorPressao ON sensorPressao.ID_Paciente = pessoa.ID_Pessoa
            INNER JOIN Sinal ON sensorPressao.ID_Pressao = Sinal.ID_Pressao
            WHERE pessoa.ID_Pessoa = $idPaciente
            ORDER BY Sinal.dataHora";

$result = $mysql->query($select);
$sinais = $result->fetch_all(MYSQLI_ASSOC);

$selectSensor = $mysql->prepare('SELECT ID_Pressao 
                                    FROM pessoa INNER JOIN SensorPressao 
                                    ON pessoa.ID_Pessoa = sensorPressao.ID_Paciente
                                    WHERE pessoa.ID_Pessoa = ?');
$selectSensor->bind_param('s', $_GET['id']);
$selectSensor->execute();
$sensor = $selectSensor->get_result()->fetch_assoc();

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
                <li><a href="indexMedico.php">PACIENTES</a></li>
                <li><a href="logout.php">SAIR</a></li>
            </ul>
        </nav>
    </div>
</header>
<section>
    <div id="titulo">
        <h1 style="margin: 0 auto;">Pressão do paciente: <?php echo $paciente['Nome'] ?></h1>
    </div>

    <p class="linha">
        <a>Contato: <?php echo $paciente['TelefoneContato'] ?></a>
        <a>ID do sensor: <?php if($sensor!= null)echo $sensor['ID_Pressao'];
                                else echo "nenhum sensor registrado" ?></a>
    <table>

        <tr>
            <th>Data e hora |</th>
            <th>Pressão</th>
        </tr>
        <tr>
            <th>Data e hora |</th>
            <th>Pressão</th>
        </tr>  <tr>
            <th>Data e hora |</th>
            <th>Pressão</th>
        </tr>  <tr>
            <th>Data e hora |</th>
            <th>Pressão</th>
                </tr>
        <?php foreach ($sinais as $sinal) { ?>
        <tr>
            <td><?php echo $sinal['dataHora']; ?></td>
            <td><?php echo $sinal['valor']; ?></td>
        </tr>
        <?php }?>
    </table>
    </p>
</section>