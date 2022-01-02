<?php
//Coletando variáveis
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$nascimento = $_POST['nascimento'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$senha = MD5($_POST['senha']);

if($senha == "" || $senha == null){ //Senha não preenchida
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Senha' deve ser preenchido');window.location.href='CuidadorCadastro.html';</script>";
}
else if($cpf == "" || $cpf == null){ //CPF não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'CPF' deve ser preenchido');window.location.href='CuidadorCadastro.html';</script>";
}
else if($nome == "" || $nome == null){ //Nome não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Nome' deve ser preenchido');window.location.href='CuidadorCadastro.html';</script>";
}
else{ //Dados sujeitos a cadastro
  //Conectando ao BD
  $connect = mysqli_connect('localhost','root','');
  $db = mysqli_select_db($connect,'recare');

  //Pesquisando se CPF já cadastrado em Pessoa
  $query_select = "SELECT CPF FROM Pessoa WHERE CPF = '$cpf'";
  $select = mysqli_query($connect, $query_select);
  if(mysqli_num_rows($select) > 0){ //CPF já cadastrado
    echo"<script language='javascript' type='text/javascript'>alert('Esse CPF já está cadastrado!');window.location.href='CuidadorCadastro.html';</script>";
  }
  else{
      //Inserindo os dados em Pessoa
      $query = "INSERT INTO Pessoa (Nome, CPF, DataNascimento, Telefone, Email, Senha) VALUES ('$nome','$cpf','$nascimento','$telefone','$email','$senha')";
      $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

      if($insert){ //Sucesso ao inserir na tabela Pessoa
        echo"<script language='javascript' type='text/javascript'>alert('Cadastro realizado com sucesso!');window.location.href='login.html';</script>";
      }
      else{ //Erro ao inserir na tabela Pessoa
        echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='CuidadorCadastro.html';</script>";
      }
  }

}

?>
