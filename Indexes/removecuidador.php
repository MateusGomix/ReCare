<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

$removeMed = $mysql->prepare('UPDATE Paciente SET ID_Cuidador = NULL
                             WHERE ID_Paciente = ?;');
$removeMed->bind_param('s', $_GET['id']);
$removeMed->execute();

header("Location: indexPaciente.php"); 
exit();

?>