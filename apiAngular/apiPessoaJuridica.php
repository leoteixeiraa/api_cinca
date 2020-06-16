<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


//LISTAGEM PESSOA JURIDICA

if($postjson['requisicao'] == 'listar'){

     if($postjson['textoBuscar'] == 'get-all'){
      $query = mysqli_query($mysqli, "select * from pessoaJuridica order by idPJuridica desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = mysqli_query($mysqli, "select * from pessoaJuridica where razaoSocial LIKE '$busca' or cnpj LIKE '$busca' or status LIKE '$busca' order by idPJuridica desc limit $postjson[start], $postjson[limit]");
    }
   
  while($row = mysqli_fetch_array($query)){ 
    $dados2[] = array(
      'idPJuridica' => $row['idPJuridica'], 
      'razaoSocial' => $row['razaoSocial'],
      'cnpj' => $row['cnpj'],
      'status' => $row['status'],
      'endereco' => $row['endereco'],
      'complemento' => $row['complemento'], //verificar retorno dos dados no banco UTF 8 !!!!!!!
      'cidade' => $row['cidade'],
      'bairro' => $row['bairro'],
      'numero' => $row['numero'],
      'pontoReferencia' => $row['pontoReferencia'],
      'cep' => $row['cep'],
      'uf' => $row['uf'],
      'email' => $row['email'],
      'telefone' => $row['telefone'],
      'site' => $row['site'],
      'observacoes' => $row['observacoes'],
      'status' => $row['status']
    );

 }

        if($query){
                $result = json_encode(array('success'=>true, 'result'=>$dados2));

            }else{
                $result = json_encode(array('success'=>false));

            }
            echo $result;




  }else if($postjson['requisicao'] == 'add'){

  $query = mysqli_query($mysqli, "INSERT INTO pessoaJuridica SET razaoSocial = '$postjson[razaoSocial]', cnpj = '$postjson[cnpj]', status = '$postjson[status]', endereco = '$postjson[endereco]', complemento = '$postjson[complemento]', cidade = '$postjson[cidade]', bairro = '$postjson[bairro]', numero = '$postjson[numero]', pontoReferencia = '$postjson[pontoReferencia]', cep = '$postjson[cep]', uf = '$postjson[uf]', email = '$postjson[email]', telefone = '$postjson[telefone]', site = '$postjson[site]', observacoes = '$postjson[observacoes]' ");

     $idPJuridica = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPJuridica'=>$idPJuridica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

   }else if($postjson['requisicao'] == 'editar'){

       $query = mysqli_query($mysqli, "UPDATE pessoaJuridica SET razaoSocial = '$postjson[razaoSocial]', cnpj = '$postjson[cnpj]', status = '$postjson[status]', endereco = '$postjson[endereco]', complemento = '$postjson[complemento]', cidade = '$postjson[cidade]', bairro = '$postjson[bairro]', numero = '$postjson[numero]', pontoReferencia = '$postjson[pontoReferencia]', cep = '$postjson[cep]', uf = '$postjson[uf]', email = '$postjson[email]', telefone = '$postjson[telefone]', site = '$postjson[site]', observacoes = '$postjson[observacoes]' WHERE idPJuridica = '$postjson[idPJuridica]' ");

     $idPJuridica = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPJuridica'=>$idPJuridica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

  }else if($postjson['requisicao'] == 'excluir'){

   $query = mysqli_query($mysqli, "delete from pessoaJuridica where idPJuridica = '$postjson[idPJuridica]' ");

   $idPJuridica = mysqli_insert_id($mysqli);
   

   if($query){
    $result = json_encode(array('success'=>true, 'idPJuridica'=>$idPJuridica));

  }else{
    $result = json_encode(array('success'=>false));

  }
  echo $result;

  }
   
       

