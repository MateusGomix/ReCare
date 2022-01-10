<?php
//Coletando variáveis
$cpf = $_POST['cpf'];
$senha = MD5($_POST['password']);
$tipo = $_POST['tipo'];

if($senha == "" || $senha == null){ //Senha não preenchida
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Senha' deve ser preenchido');window.location.href='login.html';</script>";
}
else if($cpf == "" || $cpf == null){ //CPF não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'CPF' deve ser preenchido');window.location.href='login.html';</script>";
}
else{ //Dados sujeitos a login
  //Conectando ao BD
  $connect = mysqli_connect('localhost','root','');
  $db = mysqli_select_db($connect,'recare');

  //Pesquisando se CPF é válido
  if($tipo == "Admin" || $tipo == "Medico" || $tipo == "Paciente") //Login de admin, medico e paciente
  {
    //pesquisando se CPF e senha estão corretos
    $query_select = "SELECT CPF FROM Pessoa, $tipo WHERE Pessoa.CPF = '$cpf' AND Pessoa.Senha = '$senha' AND Pessoa.ID_Pessoa = $tipo.ID_$tipo";
    $select = mysqli_query($connect, $query_select);

    if(mysqli_num_rows($select) > 0){ //Corretos
      setcookie(“cpf”,$cpf);
      echo"window.location.href='index$tipo.html';</script>";
    }
    else{ //Incorretos
      echo"<script language='javascript' type='text/javascript'>alert('CPF e/ou senha incorretos!');window.location.href='login.html';</script>";
    }
  }
  else{ //Login de cuidador
    //pesquisando se CPF e senha estão corretos
    $query_select = "SELECT CPF FROM Pessoa WHERE CPF = '$cpf' AND Pessoa.Senha = '$senha'";
    $select = mysqli_query($connect, $query_select);

    if(mysqli_num_rows($select) > 0){ //Corretos
      setcookie(“cpf”,$cpf);
      echo"window.location.href='indexCuidador.html';</script>";
    }
    else{ //Incorretos
      echo"<script language='javascript' type='text/javascript'>alert('CPF e/ou senha incorretos!');window.location.href='login.html';</script>";
    }
  }
}

?>
