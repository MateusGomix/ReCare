<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

$cpfMed = $_POST['cpf'];

$addMed = $mysql->prepare('INSERT INTO AtendeEm
                           VALUES((SELECT ID_Medico FROM Medico, Pessoa 
                           WHERE Pessoa.ID_Pessoa = Medico.ID_Medico AND Pessoa.CPF = ?),
                           (SELECT DISTINCT ID_Hospital FROM Hospital, Admin 
                           WHERE Hospital.ID_Admin = ?))');
$addMed->bind_param('ss', $cpfMed, $_GET['idAdmin']);
$addMed->execute();

header("Location: indexAdmin.php"); 
exit();

?>