<?php
//Coletando variáveis
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$nascimento = $_POST['nascimento'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$senha = MD5($_POST['senha']);
$nomeHosp = $_POST['nomeHosp'];
$endeHosp = $_POST['endeHosp'];
$teleHosp = $_POST['teleHosp'];

if($senha == "" || $senha == null){ //Senha não preenchida
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Senha' deve ser preenchido');window.location.href='AdminCadastro.html';</script>";
}
else if($cpf == "" || $cpf == null){ //CPF não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'CPF' deve ser preenchido');window.location.href='AdminCadastro.html';</script>";
}
else if($nome == "" || $nome == null){ //Nome não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Nome' deve ser preenchido');window.location.href='AdminCadastro.html';</script>";
}
else{ //Dados sujeitos a cadastro
  //Conectando ao BD
  $connect = mysqli_connect('localhost','root','');
  $db = mysqli_select_db($connect,'recare');

  //Pesquisando se CPF já cadastrado em Admin
  $query_select = "SELECT CPF FROM Pessoa, Admin WHERE Pessoa.CPF = '$cpf' AND Pessoa.ID_Pessoa = Admin.ID_Admin";
  $select = mysqli_query($connect, $query_select);
  if(mysqli_num_rows($select) > 0){
    echo"<script language='javascript' type='text/javascript'>alert('Esse CPF já está cadastrado!');window.location.href='AdminCadastro.html';</script>";
  }
  else{
    //Pesquisando se CPF já cadastrado em Pessoa
    $query_select = "SELECT CPF FROM Pessoa WHERE CPF = '$cpf'";
    $select = mysqli_query($connect, $query_select);
    if(mysqli_num_rows($select) == 0){
      //Inserindo os dados em Pessoa
      $query = "INSERT INTO Pessoa (Nome, CPF, DataNascimento, Telefone, Email, Senha) VALUES ('$nome','$cpf','$nascimento','$telefone','$email','$senha')";
      $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

      if(!$insert){ //Erro ao inserir na tabela Pessoa
        echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='AdminCadastro.html';</script>";
      }
    }
    //Inserindo os dados em Admin

    //Pesquisando o ID correto
    $query_select = "SELECT ID_Pessoa FROM Pessoa WHERE CPF = '$cpf'";
    $select = mysqli_query($connect, $query_select);
    if(mysqli_num_rows($select) > 0){
      $array = mysqli_fetch_array($select);
      $idarray = $array['ID_Pessoa'];

      //Inserindo na tabela Admin
      $query = "INSERT INTO Admin (ID_Admin) VALUES ('$idarray')";
      $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

      if(!$insert){ //Erro ao inserir na tabela Admin
        echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='AdminCadastro.html';</script>";
      }
      else{ //Sucesso, inserir na tabela Hospital
        $query = "INSERT INTO Hospital (Nome, Endereco, Telefone, ID_Admin) VALUES ('$nomeHosp','$endeHosp','$teleHosp','$idarray')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

        if($insert){
          echo"<script language='javascript' type='text/javascript'>alert('Cadastro realizado com sucesso!');window.location.href='login.html';</script>";
        }
        else{
          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='AdminCadastro.html';</script>";
        }
      }
    }
    else{ //Erro ao pesquisar na tabela Pessoa
      echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='AdminCadastro.html';</script>";
    }
  }
}

?>
