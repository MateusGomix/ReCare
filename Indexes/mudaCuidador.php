<?php
$mysql = new mysqli('localhost', 'root', '', 'recare');

$cpfMed = $_POST['cpf'];

$query = "SELECT * FROM Pessoa p, Medico m
          WHERE p.CPF = '$cpfMed'";
$aux = mysqli_query($mysql, $query, $result_mode = MYSQLI_STORE_RESULT);


if(mysqli_num_rows($aux) > 0){

    $addMed = $mysql->prepare('UPDATE Paciente SET ID_Cuidador = 
                            (SELECT DISTINCT ID_Pessoa FROM Pessoa WHERE CPF = ?)
                            WHERE ID_Paciente = ?;');
    $addMed->bind_param('ss', $cpfMed, $_GET['idPaciente']);
    $addMed->execute();

}

header("Location: indexPaciente.php"); 
exit();

?>