<?php

include_once('conexao.php');

header("Content-Type: text/html; charset=UTF-8",true);

$postjson = json_decode(file_get_contents('php://input'), true);





//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){


    if($postjson['textoBuscar'] == ''){
        $query = $pdo->query("SELECT * from PFisica order by idPFisica desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = $pdo->query("SELECT * from PFisica where nome LIKE '$busca' or cpf LIKE '$busca' order by idPFisica desc limit $postjson[start], $postjson[limit]");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

  for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
    $dados[] = array(
      'idPFisica' => $res[$i]['idPFisica'],
      'nome' => $res[$i]['nome'],
      'cpf' => $res[$i]['cpf'],
      'rg' => $res[$i]['rg'],
      'sexo' => $res[$i]['sexo'],
      'dataNascimento' => $res[$i]['dataNascimento'],
      'estadoCivil' => $res[$i]['estadoCivil'],
      'cep' => $res[$i]['cep'],
      'endereco' => $res[$i]['endereco'], //problema no retorno de dados
      'complemento' => $res[$i]['complemento'],
      'cidade' => $res[$i]['cidade'],
      'bairro' => $res[$i]['bairro'],
      'uf' => $res[$i]['uf'],
      'celular' => $res[$i]['celular'],
      'telFixo' => $res[$i]['telFixo'],
      'email' => $res[$i]['email'],
      'observacoes' => $res[$i]['observacoes'],

    );

 }

        if($query){
                $result = json_encode(array('success'=>true, 'result'=>$dados));

            }else{
                $result = json_encode(array('success'=>false));

            }
            echo $result;



}else if($postjson['requisicao'] == 'add'){

  $query = $pdo->prepare("INSERT INTO PFisica SET nome = :nome, cpf = :cpf, rg = :rg, sexo = :sexo, dataNascimento = :dataNascimento, estadoCivil = :estadoCivil, cep = :cep, endereco = :endereco, complemento = :complemento, cidade = :cidade, bairro = :bairro, uf = :uf, celular = :celular, telFixo = :telFixo, email = :email, observacoes = :observacoes ");

     $query->bindValue(":nome", $postjson['nome']);
     $query->bindValue(":cpf", $postjson['cpf']);
     $query->bindValue(":rg", $postjson['rg']);
     $query->bindValue(":sexo", $postjson['sexo']);
     $query->bindValue(":dataNascimento", $postjson['dataNascimento']);
     $query->bindValue(":estadoCivil", $postjson['estadoCivil']);
     $query->bindValue(":cep", $postjson['cep']);
     $query->bindValue(":endereco", $postjson['endereco']);
     $query->bindValue(":complemento", $postjson['complemento']);
     $query->bindValue(":cidade", $postjson['cidade']);
     $query->bindValue(":bairro", $postjson['bairro']);
     $query->bindValue(":uf", $postjson['uf']);
     $query->bindValue(":celular", $postjson['celular']);
     $query->bindValue(":telFixo", $postjson['telFixo']);
     $query->bindValue(":email", $postjson['email']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->execute();

     $idPFisica = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPFisica'=>$idPFisica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  




}else if($postjson['requisicao'] == 'editar'){

  $query = $pdo->prepare("UPDATE PFisica SET nome = :nome, cpf = :cpf, rg = :rg, sexo = :sexo, dataNascimento = :dataNascimento, estadoCivil = :estadoCivil, cep = :cep, endereco = :endereco, complemento = :complemento, cidade = :cidade, bairro = :bairro, uf = :uf, celular = :celular, telFixo = :telFixo, email = :email, observacoes = :observacoes where idPFisica = :idPFisica ");

     $query->bindValue(":nome", $postjson['nome']);
     $query->bindValue(":cpf", $postjson['cpf']);
     $query->bindValue(":rg", $postjson['rg']);
     $query->bindValue(":sexo", $postjson['sexo']);
     $query->bindValue(":dataNascimento", $postjson['dataNascimento']);
     $query->bindValue(":estadoCivil", $postjson['estadoCivil']);
     $query->bindValue(":cep", $postjson['cep']);
     $query->bindValue(":endereco", $postjson['endereco']);
     $query->bindValue(":complemento", $postjson['complemento']);
     $query->bindValue(":cidade", $postjson['cidade']);
     $query->bindValue(":bairro", $postjson['bairro']);
     $query->bindValue(":uf", $postjson['uf']);
     $query->bindValue(":celular", $postjson['celular']);
     $query->bindValue(":telFixo", $postjson['telFixo']);
     $query->bindValue(":email", $postjson['email']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->bindValue(":idPFisica", $postjson['idPFisica']);
     $query->execute();

     $idPFisica = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPFisica'=>$idPFisica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  

}else if($postjson['requisicao'] == 'excluir'){

   $query = $pdo->query("DELETE from PFisica where idPFisica = '$postjson[idPFisica]' ");

   if($query){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
}



  ?>