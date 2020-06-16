<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


//LISTAGEM PESSOA JURIDICA

if($postjson['requisicao'] == 'listar'){

     if($postjson['textoBuscar'] == 'get-all'){
      $query = mysqli_query($mysqli, "select * from pessoaFisica order by idPFisica desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = mysqli_query($mysqli, "select * from pessoaFisica where nome LIKE '$busca' or cpf LIKE '$busca' or rg LIKE '$busca' order by idPFisica desc limit $postjson[start], $postjson[limit]");
    }
   
  while($row = mysqli_fetch_array($query)){ 
    $dados2[] = array(
      'idPFisica' => $row['idPFisica'], 
      'nome' => $row['nome'],
      'cpf' => $row['cpf'],
      'rg' => $row['rg'],
      'sexo' => $row['sexo'],
      'dataNascimento' => $row['dataNascimento'], //verificar retorno dos dados no banco UTF 8 !!!!!!!
      'estadoCivil' => $row['estadoCivil'],
      'cep' => $row['cep'],
      'endereco' => $row['endereco'],
      'complemento' => $row['complemento'],
      'cidade' => $row['cidade'],
      'bairro' => $row['bairro'],
      'uf' => $row['uf'],
      'celular' => $row['celular'],
      'telFixo' => $row['telFixo'],
      'email' => $row['email'],
      'observacoes' => $row['observacoes']
    );

 }

        if($query){
                $result = json_encode(array('success'=>true, 'result'=>$dados2));

            }else{
                $result = json_encode(array('success'=>false));

            }
            echo $result;




  }else if($postjson['requisicao'] == 'add'){

  $query = mysqli_query($mysqli, "INSERT INTO pessoaFisica SET nome = '$postjson[nome]', cpf = '$postjson[cpf]', rg = '$postjson[rg]', sexo = '$postjson[sexo]', dataNascimento = '$postjson[dataNascimento]', estadoCivil = '$postjson[estadoCivil]', cep = '$postjson[cep]', endereco = '$postjson[endereco]', complemento = '$postjson[complemento]', cidade = '$postjson[cidade]', bairro = '$postjson[bairro]', uf = '$postjson[uf]', celular = '$postjson[celular]', telFixo = '$postjson[telFixo]', email = '$postjson[email]', observacoes = '$postjson[observacoes]' ");

     $idPFisica = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPFisica'=>$idPFisica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

   }else if($postjson['requisicao'] == 'editar'){

       $query = mysqli_query($mysqli, "UPDATE pessoaFisica SET nome = '$postjson[nome]', cpf = '$postjson[cpf]', rg = '$postjson[rg]', sexo = '$postjson[sexo]', dataNascimento = '$postjson[dataNascimento]', estadoCivil = '$postjson[estadoCivil]', cep = '$postjson[cep]', endereco = '$postjson[endereco]', complemento = '$postjson[complemento]', cidade = '$postjson[cidade]', bairro = '$postjson[bairro]', uf = '$postjson[uf]', celular = '$postjson[celular]', telFixo = '$postjson[telFixo]', email = '$postjson[email]', observacoes = '$postjson[observacoes]' WHERE idPFisica = '$postjson[idPFisica]' ");

     $idPFisica = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPFisica'=>$idPFisica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

  }else if($postjson['requisicao'] == 'excluir'){

   $query = mysqli_query($mysqli, "delete from pessoaFisica where idPFisica = '$postjson[idPFisica]' ");

   $idPFisica = mysqli_insert_id($mysqli);
   

   if($query){
    $result = json_encode(array('success'=>true, 'idPFisica'=>$idPFisica));

  }else{
    $result = json_encode(array('success'=>false));

  }
  echo $result;

   }else if($postjson['requisicao'] == 'login'){

    $query = mysqli_query($mysqli, "SELECT * from pessoaFisica where cpf = '$postjson[cpf]' and senha = '$postjson[senha]' ");

    $result = mysqli_num_rows($query);

  

     if($result > 0){
     $result = json_encode(array('success'=>true));

    }else{
     $result = json_encode(array('success'=>false));

    }
    echo $result;

       }
   
       

