<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

/*
SELECT 
    pessoa.Nome, paciente.TelefoneContato, sensoroxi.Frequencia, sensorpressao.Frequencia, 
    sensorritmo.Frequencia, sensortemp.Frequencia 
    from pessoa 
    INNER JOIN paciente ON paciente.ID_Paciente = pessoa.ID_Pessoa
    INNER JOIN sensoroxi ON sensoroxi.ID_Paciente = pessoa.ID_Pessoa
    INNER JOIN sensorpressao ON sensoroxi.ID_Paciente = pessoa.ID_Pessoa
    INNER JOIN sensorritmo ON sensoroxi.ID_Paciente = pessoa.ID_Pessoa
    INNER JOIN sensortemp ON sensoroxi.ID_Paciente = pessoa.ID_Pessoa
    WHERE pessoa.ID_Pessoa = 1;
*/

$selectPaciente = $mysql->prepare('SELECT pessoa.Nome, paciente.TelefoneContato 
                                    FROM pessoa INNER JOIN paciente 
                                    ON pessoa.ID_Pessoa = paciente.ID_Paciente
                                    WHERE pessoa.ID_Pessoa = ?');
$selectPaciente->bind_param('s', $_GET['id']);
$selectPaciente->execute();
$paciente = $selectPaciente->get_result()->fetch_assoc();
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
            Contato: <?php echo $paciente['TelefoneContato'] ?>
        </p>
    </div>
    <a href="indexMedico.php">Voltar</a>
</body>

</html>