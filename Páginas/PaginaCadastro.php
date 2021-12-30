<?php

$nome = $_POST['nome'];

$nascimento = $_POST['nascimento'];

$telefone = $_POST['telefone'];

$email = $_POST['email'];

$senha = MD5($_POST['senha']);

$connect = mysqli_connect('localhost','root','Deusefiel29');

$db = mysqli_select_db($connect,'recare');

$query_select = "SELECT Email FROM Pessoa WHERE Email = '$email'";

$select = mysqli_query($connect, $query_select);

$array = mysqli_fetch_array($select);

$logarray = $array['Email'];

  if($email == "" || $email == null){

    echo"<script language='javascript' type='text/javascript'>alert('O campo email deve ser preenchido');window.location.href='PaginaCadastro.html';</script>";

    }else{

      if($logarray == $email){

        echo"<script language='javascript' type='text/javascript'>alert('Esse email já existe');window.location.href='PaginaCadastro.html';</script>";

        die();

      }else{

        $query = "INSERT INTO Pessoa (Nome, DataNascimento, Telefone, Email, Senha) VALUES ('$nome','$nascimento','$telefone','$email','$senha')";

        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

        if($insert){

          echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='email.html'</script>";

        }else{

          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='PaginaCadastro.html'</script>";

        }

      }

    }

?>
