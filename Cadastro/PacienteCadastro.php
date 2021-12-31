<?php
//Coletando variáveis
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$nascimento = $_POST['nascimento'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$senha = MD5($_POST['senha']);
$contato = $_POST['contato'];
$cuidador = $_POST['cuidador'];

//Conectando ao BD
$connect = mysqli_connect('localhost','root','');
$db = mysqli_select_db($connect,'recare');

//Pesquisando um email já cadastrado
$query_select = "SELECT Email FROM Pessoa WHERE Email = '$email'";
$select = mysqli_query($connect, $query_select);
if(mysqli_num_rows($select) > 0){
  $array = mysqli_fetch_array($select);
  $emailarray = $array['Email'];
}
else{
  $emailarray = null;
}

//Pesquisando um CPF já cadastrado
$query_select = "SELECT CPF FROM Pessoa WHERE CPF = '$cpf'";
$select = mysqli_query($connect, $query_select);
if(mysqli_num_rows($select) > 0){
  $array = mysqli_fetch_array($select);
  $cpfarray = $array['CPF'];
}
else{
  $cpfarray = null;
}

if($email == "" || $email == null){ //Email não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Email' deve ser preenchido');window.location.href='PacienteCadastro.html';</script>";
}
else if($cpf == "" || $cpf == null){ //CPF não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'CPF' deve ser preenchido');window.location.href='PacienteCadastro.html';</script>";
}
else if($emailarray == $email){ //Email repetido
  echo"<script language='javascript' type='text/javascript'>alert('Esse email já existe');window.location.href='PacienteCadastro.html';</script>";
}
else if($cpfarray == $cpf){ //CPF repetido
  echo"<script language='javascript' type='text/javascript'>alert('Esse CPF já existe');window.location.href='PacienteCadastro.html';</script>";
}
else{ //Dados sujeitos a cadastro
  //Inserindo os dados na tabela Pessoa
  $query = "INSERT INTO Pessoa (Nome, CPF, DataNascimento, Telefone, Email, Senha) VALUES ('$nome','$cpf','$nascimento','$telefone','$email','$senha')";
  $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

  if($insert){ //TEM UM ERRO POR AQUI AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
    //Recuperando o ID desse paciente
    $query_select = "SELECT ID_Pessoa FROM Pessoa WHERE CPF = '$cpf'";
    $select = mysqli_query($connect, $query_select);
    if(mysqli_num_rows($select) > 0){
      $array = mysqli_fetch_array($select);
      $idarray = $array['ID_Pessoa'];
    }
    else{
      $idarray = null;
      echo"aaaaaaaaaaaaaaaaaa";
    }

    if($cuidador == "" || $cuidador == null){ //Cuidador não preenchido
      //Inserindo os dados na tabela Paciente
      $query = "INSERT INTO Paciente (ID_Paciente, TelefoneContato, ID_Cuidador) VALUES ('$idarray','$contato','')";
      $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

      if($insert){ //sucesso
        echo"<script language='javascript' type='text/javascript'>alert('Paciente cadastrado!');window.location.href='Login.html';</script>";
      }
      else{ //erro
        echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='PacienteCadastro.html';</script>";
      }
    }
    else{ //Cuidador preenchido
      //Recuperando ID do cuidador
      $query_select = "SELECT ID_Pessoa FROM Pessoa WHERE CPF = '$cuidador'";
      $select = mysqli_query($connect, $query_select);
      if(mysqli_num_rows($select) > 0){
        $array = mysqli_fetch_array($select);
        $idcuidadorarray = $array['ID_Pessoa'];
      }
      else{
        $idcuidadorarray = null;
      }

      if($idcuidadorarray == null){ //cuidador não encontrado
        //Inserindo os dados na tabela Paciente
        $query = "INSERT INTO Paciente (ID_Paciente, TelefoneContato, ID_Cuidador, ID_Medico) VALUES ('$idarray','$contato', 'NULL', 'NULL')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

        if($insert){ //sucesso
          echo"<script language='javascript' type='text/javascript'>alert('Paciente cadastrado, porém cuidador foi deixado vazio. Você pode acrescentar seus dados após o login.');window.location.href='Login.html';</script>";
        }
        else{ //erro
          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='PacienteCadastro.html';</script>";
        }
      }
      else{
        //Inserindo os dados na tabela Paciente
        $query = "INSERT INTO Paciente (ID_Paciente, TelefoneContato, ID_Cuidador) VALUES ('$idarray','$contato','$idcuidador')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

        if($insert){ //sucesso
          echo"<script language='javascript' type='text/javascript'>alert('Paciente cadastrado, porém cuidador foi deixado vazio. Você pode acrescentar seus dados após o login.');window.location.href='Login.html';</script>";
        }
        else{ //erro
          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='PacienteCadastro.html';</script>";
        }
      }
    }

  }
  else{
    echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='PacienteCadastro.html';</script>";
  }
}

?>
