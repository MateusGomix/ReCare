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
            INNER JOIN sensorRitmo ON sensorRitmo.ID_Paciente = pessoa.ID_Pessoa
            INNER JOIN Sinal ON sensorRitmo.ID_Ritmo = Sinal.ID_Ritmo
            WHERE pessoa.ID_Pessoa = $idPaciente
            ORDER BY Sinal.dataHora";

$result = $mysql->query($select);
$sinais = $result->fetch_all(MYSQLI_ASSOC);

$selectSensor = $mysql->prepare('SELECT ID_Ritmo 
                                    FROM pessoa INNER JOIN SensorRitmo 
                                    ON pessoa.ID_Pessoa = sensorRitmo.ID_Paciente
                                    WHERE pessoa.ID_Pessoa = ?');
$selectSensor->bind_param('s', $_GET['id']);
$selectSensor->execute();
$sensor = $selectSensor->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Paciente</title>
</head>

<body>
    <div>
        <h1><?php echo $paciente['Nome'] ?></h1>
        <p>
            Contato: <?php echo $paciente['TelefoneContato'] ?><br>
            ID do sensor: <?php if($sensor!= null)echo $sensor['ID_Ritmo'];
                                else echo "nenhum sensor registrado" ?>
        </p>
    </div>
    <table>

    <tr>
        <th>Data e hora</th>
        <th>Ritmo Cardíaco</th>
    </tr>

    <?php foreach ($sinais as $sinal) { ?>
        <tr>
            <td><?php echo $sinal['dataHora']; ?></td>
            <td><?php echo $sinal['valor']; ?></td>
        </tr>
    <?php }?>
    </table>


    <a href="index<?php echo $_COOKIE['tipo'] ?>.php">Voltar</a>

</body>

</html>