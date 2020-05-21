<?php

include_once('conexao.php');

header("Content-Type: text/html; charset=UTF-8",true);

$postjson = json_decode(file_get_contents('php://input'), true);





//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){


    if($postjson['textoBuscar'] == ''){
        $query = $pdo->query("SELECT * from PJuridica order by idPJuridica desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = $pdo->query("SELECT * from PJuridica where cnpj LIKE '$busca' or razaoSocial LIKE '$busca' order by idPJuridica desc limit $postjson[start], $postjson[limit]");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

  for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
    $dados[] = array(
      'idPJuridica' => $res[$i]['idPJuridica'],
      'razaoSocial' => $res[$i]['razaoSocial'],
      'cnpj' => $res[$i]['cnpj'],
      'status' => $res[$i]['status'],
      'endereco' => $res[$i]['endereco'],
      'complemento' => $res[$i]['complemento'],
      'cidade' => $res[$i]['cidade'],
      'bairro' => $res[$i]['bairro'],
      'numero' => $res[$i]['numero'], //problema no retorno de dados
      'pontoReferencia' => $res[$i]['pontoReferencia'],
      'cep' => $res[$i]['cep'],
      'uf' => $res[$i]['uf'],
      'email' => $res[$i]['email'],
      'telefone' => $res[$i]['telefone'],
      'site' => $res[$i]['site'],
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

  $query = $pdo->prepare("INSERT INTO PJuridica SET razaoSocial = :razaoSocial, cnpj = :cnpj, status = :status, endereco = :endereco, complemento = :complemento, cidade = :cidade, bairro = :bairro, numero = :numero, pontoReferencia = :pontoReferencia, cep = :cep, uf = :uf, email = :email, telefone = :telefone, site = :site, observacoes = :observacoes ");

     $query->bindValue(":razaoSocial", $postjson['razaoSocial']);
     $query->bindValue(":cnpj", $postjson['cnpj']);
     $query->bindValue(":status", $postjson['status']);
     $query->bindValue(":endereco", $postjson['endereco']);
     $query->bindValue(":complemento", $postjson['complemento']);
     $query->bindValue(":cidade", $postjson['cidade']);
     $query->bindValue(":bairro", $postjson['bairro']);
     $query->bindValue(":numero", $postjson['numero']);
     $query->bindValue(":pontoReferencia", $postjson['pontoReferencia']);
     $query->bindValue(":cep", $postjson['cep']);
     $query->bindValue(":uf", $postjson['uf']);
     $query->bindValue(":email", $postjson['email']);
     $query->bindValue(":telefone", $postjson['telefone']);
     $query->bindValue(":site", $postjson['site']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->execute();

     $idPJuridica = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPJuridica'=>$idPJuridica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  




}else if($postjson['requisicao'] == 'editar'){

  $query = $pdo->prepare("UPDATE PJuridica SET razaoSocial = :razaoSocial, cnpj = :cnpj, status = :status, endereco = :endereco, complemento = :complemento, cidade = :cidade, bairro = :bairro, numero = :numero, pontoReferencia = :pontoReferencia, cep = :cep, uf = :uf, email = :email, telefone = :telefone, site = :site, observacoes = :observacoes where idPJuridica = :idPJuridica ");

     $query->bindValue(":razaoSocial", $postjson['razaoSocial']);
     $query->bindValue(":cnpj", $postjson['cnpj']);
     $query->bindValue(":status", $postjson['status']);
     $query->bindValue(":endereco", $postjson['endereco']);
     $query->bindValue(":complemento", $postjson['complemento']);
     $query->bindValue(":cidade", $postjson['cidade']);
     $query->bindValue(":bairro", $postjson['bairro']);
     $query->bindValue(":numero", $postjson['numero']);
     $query->bindValue(":pontoReferencia", $postjson['pontoReferencia']);
     $query->bindValue(":cep", $postjson['cep']);
     $query->bindValue(":uf", $postjson['uf']);
     $query->bindValue(":email", $postjson['email']);
     $query->bindValue(":telefone", $postjson['telefone']);
     $query->bindValue(":site", $postjson['site']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->bindValue(":idPJuridica", $postjson['idPJuridica']);
     $query->execute();

     $idPJuridica = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPJuridica'=>$idPJuridica));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  

}else if($postjson['requisicao'] == 'excluir'){

   $query = $pdo->query("DELETE from PJuridica where idPJuridica = '$postjson[idPJuridica]' ");

   if($query){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
}



  ?>