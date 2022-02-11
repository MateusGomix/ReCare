<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

$cpfMed = $_POST['cpf'];

$query = "SELECT * FROM Pessoa p, Medico m
          WHERE m.ID_Medico = p.ID_Pessoa 
          AND p.CPF = '$cpfMed'";
$aux = mysqli_query($mysql, $query, $result_mode = MYSQLI_STORE_RESULT);

$query = "SELECT * FROM Pessoa p, Medico m, AtendeEm ae
          WHERE m.ID_Medico = p.ID_Pessoa 
          AND p.CPF = '$cpfMed'
          AND ae.ID_Medico = m.ID_Medico";
$aux2 = mysqli_query($mysql, $query, $result_mode = MYSQLI_STORE_RESULT);

if(mysqli_num_rows($aux) > 0 && mysqli_num_rows($aux2) == 0){

    $addMed = $mysql->prepare('INSERT INTO AtendeEm
                           VALUES((SELECT ID_Medico FROM Medico, Pessoa 
                           WHERE Pessoa.ID_Pessoa = Medico.ID_Medico AND Pessoa.CPF = ?),
                           (SELECT DISTINCT ID_Hospital FROM Hospital, Admin 
                           WHERE Hospital.ID_Admin = ?))');
    $addMed->bind_param('ss', $cpfMed, $_GET['idAdmin']);
    $addMed->execute();

}

header("Location: indexAdmin.php"); 
exit();

?>