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
$medico = $_POST['medico'];
$idAdmin = $_COOKIE['adminID'];

if($senha == "" || $senha == null){ //Senha não preenchida
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Senha' deve ser preenchido');window.location.href='PacienteCadastro.html';</script>";
}
else if($cpf == "" || $cpf == null){ //CPF não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'CPF' deve ser preenchido');window.location.href='PacienteCadastro.html';</script>";
}
else if($nome == "" || $nome == null){ //Nome não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'Nome' deve ser preenchido');window.location.href='PacienteCadastro.html';</script>";
}
else if($medico == "" || $medico == null){ //CPF do medico não preenchido
  echo"<script language='javascript' type='text/javascript'>alert('O campo 'CPF do Médico' deve ser preenchido');window.location.href='PacienteCadastro.html';</script>";
}
else{ //Dados sujeitos a cadastro
  //Conectando ao BD
  $connect = mysqli_connect('localhost','root','');
  $db = mysqli_select_db($connect,'recare');

  //Pesquisando se CPF já cadastrado em Paciente
  $query_select = "SELECT CPF FROM Pessoa, Paciente WHERE Pessoa.CPF = '$cpf' AND Pessoa.ID_Pessoa = Paciente.ID_Paciente";
  $select = mysqli_query($connect, $query_select);
  if(mysqli_num_rows($select) > 0){
    echo"<script language='javascript' type='text/javascript'>alert('Esse CPF já está cadastrado!');window.location.href='PacienteCadastro.html';</script>";
  }
  else{
    //Pesquisando se CPF já cadastrado em Pessoa
    $query_select = "SELECT CPF FROM Pessoa WHERE CPF = '$cpf'";
    $select = mysqli_query($connect, $query_select);
    if(mysqli_num_rows($select) == 0){ //Não cadastrado em Pessoa
      //Inserindo os dados na tabela Pessoa
      $query = "INSERT INTO Pessoa (Nome, CPF, DataNascimento, Telefone, Email, Senha) VALUES ('$nome','$cpf','$nascimento','$telefone','$email','$senha')";
      $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

      if(!$insert){ //Erro ao inserir na tabela Pessoa
        echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro');window.location.href='PacienteCadastro.html';</script>";
      }
    }

    //Pesquisando pelo CPF do médico
    $query_select = "SELECT ID_Pessoa FROM Pessoa, Medico WHERE CPF = '$medico' AND Pessoa.ID_Pessoa = Medico.ID_Medico";
    $select = mysqli_query($connect, $query_select);
    if(mysqli_num_rows($select) == 0){ //Não há registro desse médico
      echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro: médico não encontrado');window.location.href='PacienteCadastro.html';</script>";
    }
    else{
      $array = mysqli_fetch_array($select);
      $idmedarray = $array['ID_Pessoa'];
    }

    //Inserindo os dados em Paciente

    //Pesquisando o ID correto do Paciente
    $query_select = "SELECT ID_Pessoa FROM Pessoa WHERE CPF = '$cpf'";
    $select = mysqli_query($connect, $query_select);
    if(mysqli_num_rows($select) > 0){ //ID encontrado
      $array = mysqli_fetch_array($select);
      $idarray = $array['ID_Pessoa'];

      if($cuidador == null || $cuidador == ""){ //Cuidador não preenchido
        //Inserindo na tabela Paciente
        $query = "INSERT INTO Paciente (ID_Paciente, TelefoneContato, ID_Medico) VALUES ('$idarray','$contato','$idmedarray')";
        $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

        if(!$insert){
          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='PacienteCadastro.html';</script>";
        }
        else{
          $query = "INSERT INTO SensorPressao (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorOxi (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorRitmo (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorTemp (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          echo"<script language='javascript' type='text/javascript'>alert('Cadastro realizado com sucesso!');window.location.href='../Indexes/indexAdmin.php';</script>";
        }
      }
      else{ //Cuidador preenchido
        //Pesquisando ID do cuidador
        $query_select = "SELECT ID_Pessoa FROM Pessoa WHERE CPF = '$cuidador'";
        $select = mysqli_query($connect, $query_select);

        if(mysqli_num_rows($select) > 0){ //ID do cuidador encontrado
          $array = mysqli_fetch_array($select);
          $cuidadorarray = $array['ID_Pessoa'];

          $query = "INSERT INTO Paciente (ID_Paciente, TelefoneContato, ID_Cuidador, ID_Medico) VALUES ('$idarray','$contato','$cuidadorarray','$idmedarray')";
          $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          if($insert){
            $query = "INSERT INTO SensorPressao (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorOxi (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorRitmo (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorTemp (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);
            echo"<script language='javascript' type='text/javascript'>alert('Cadastro realizado com sucesso!');window.location.href='../Indexes/indexAdmin.php';</script>";
          }
          else{
            echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='PacienteCadastro.html';</script>";
          }

        }
        else{ //ID do cuidador não encontrado
          $query = "INSERT INTO Paciente (ID_Paciente, TelefoneContato, ID_Medico) VALUES ('$idarray','$contato','$idmedarray')";
          $insert = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          if($insert){
            $query = "INSERT INTO SensorPressao (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorOxi (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorRitmo (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);

          $query = "INSERT INTO SensorTemp (ID_Paciente, ID_Hospital, ID_Medico) 
                    VALUES ('$idarray',
                    (SELECT DISTINCT ID_Hospital FROM Hospital
                    WHERE Hospital.ID_Admin = '$idAdmin'),
                    '$idmedarray')";
          $insert2 = mysqli_query($connect, $query, $result_mode = MYSQLI_STORE_RESULT);
            echo"<script language='javascript' type='text/javascript'>alert('Cadastro realizado, porém cuidador não encontrado e deixado em branco.');window.location.href='PacienteCadastro.html';</script>";
          }
          else{
            echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='../Indexes/indexAdmin.php';</script>";
          }
        }

      }

    }
    else{ //Erro ao pesquisar ID na tabela Pessoa
      echo"<script language='javascript' type='text/javascript'>alert('Não foi possível realizar o cadastro.');window.location.href='PacienteCadastro.html';</script>";
    }
  }
}

?>
