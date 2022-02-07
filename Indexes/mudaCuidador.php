<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

$cpfMed = $_POST['cpf'];

$addMed = $mysql->prepare('UPDATE Paciente SET ID_Cuidador = 
                           (SELECT DISTINCT ID_Pessoa FROM Pessoa WHERE CPF = ?)
                           WHERE ID_Paciente = ?;');
$addMed->bind_param('ss', $cpfMed, $_GET['idPaciente']);
$addMed->execute();

header("Location: indexPaciente.php"); 
exit();

?>