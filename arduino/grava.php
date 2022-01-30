<?php

//coletando ID do sensor
if(isset($_GET['id']))
    $id = $_GET['id'];
else{
    echo"<script language='javascript' type='text/javascript'>alert('Erro: ID não encontrado.');</script>";
    die();
}
//coletando tipo do sensor
if(isset($_GET['tipo']))
    $tipo = $_GET['tipo'];
else{
    echo"<script language='javascript' type='text/javascript'>alert('Erro: tipo não encontrado.');</script>";
    die();
}

//coletando medição
if(isset($_GET['valor']))
    $valor = $_GET['valor'];
else{
    echo"<script language='javascript' type='text/javascript'>alert('Erro: valor não encontrado.');</script>";
    die();
}

//Conectando ao BD
$connect = mysqli_connect('localhost','root','');
$db = mysqli_select_db($connect,'recare');

echo $tipo;

switch($tipo){
    case "oxi":
        $query = "INSERT INTO Sinal (Valor, ID_Oxi) VALUES ('$valor','$id')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);
    break;

    case "pressao":
        $query = "INSERT INTO Sinal (Valor, ID_Pressao) VALUES ('$valor','$id')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);
    break;

    case "ritmo":
        $query = "INSERT INTO Sinal (Valor, ID_Ritmo) VALUES ('$valor','$id')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);
    break;

    case "temp":
        $query = "INSERT INTO Sinal (Valor, ID_Temp) VALUES ('$valor','$id')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);
    break;

    default:
        echo"<script language='javascript' type='text/javascript'>alert('Erro: não foi possível localizar o tipo.');</script>";
        die();
}

if($insert){
    echo"<script language='javascript' type='text/javascript'>alert('Sinal registrado com sucesso.');</script>";
}
else{
    echo"<script language='javascript' type='text/javascript'>alert('Erro: não foi possível registrar o sinal.');</script>";
}

?>