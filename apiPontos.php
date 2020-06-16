<?php

include_once('conexao.php');

header("Content-Type: text/html; charset=UTF-8",true);

$postjson = json_decode(file_get_contents('php://input'), true);

$subject = ['.',','];
$replace =['','.'];





//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){


    if($postjson['textoBuscar'] == ''){
        $query = $pdo->query("SELECT * from pontos order by idPonto desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = $pdo->query("SELECT * from pontos where cidade LIKE _utf8'%$busca%' or bairro LIKE _utf8'%$busca%' order by idPonto desc limit $postjson[start], $postjson[limit] ");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

  for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
    $dados[] = array(
      
      'idPonto' => $res[$i]['idPonto'],
      'potencia' => $res[$i]['potencia'],
      'consumo' => $res[$i]['consumo'],
      'status' => $res[$i]['status'],
      'endereco' => $res[$i]['endereco'],
      'complemento' => $res[$i]['complemento'],
      'latitude' => $res[$i]['latitude'],
      'longitude' => $res[$i]['longitude'],
      'cidade' => $res[$i]['cidade'],
      'bairro' => $res[$i]['bairro'],
      'pontoReferencia' => $res[$i]['pontoReferencia'],
      'uf' => $res[$i]['uf'],
      'cep' => $res[$i]['cep'],
      'fabricante' => $res[$i]['fabricante'],
      'tipoPoste' => $res[$i]['tipoPoste'],
      'dimensoes' => $res[$i]['dimensoes'],
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

  $query = $pdo->prepare("INSERT INTO pontos SET potencia = :potencia, consumo = :consumo, status = :status,
   endereco = :endereco, complemento = :complemento, latitude = :latitude,
    longitude = :longitude, cidade = :cidade, bairro = :bairro, pontoReferencia = :pontoReferencia,
     uf = :uf, cep = :cep, fabricante = :fabricante, tipoPoste = :tipoPoste,
      dimensoes = :dimensoes, observacoes = :observacoes ");

     $query->bindValue(":potencia", $postjson['potencia']);
     $query->bindValue(":consumo", $postjson['consumo']);
     $query->bindValue(":status", $postjson['status']);
     $query->bindValue(":endereco", $postjson['endereco']);
     $query->bindValue(":complemento", $postjson['complemento']);
     $query->bindValue(":latitude", $postjson['latitude']);
     $query->bindValue(":longitude", $postjson['longitude']);
     $query->bindValue(":cidade", $postjson['cidade']);
     $query->bindValue(":bairro", $postjson['bairro']);
     $query->bindValue(":pontoReferencia", $postjson['pontoReferencia']);
     $query->bindValue(":uf", $postjson['uf']);
     $query->bindValue(":cep", $postjson['cep']);
     $query->bindValue(":fabricante", $postjson['fabricante']);
     $query->bindValue(":tipoPoste", $postjson['tipoPoste']);
     $query->bindValue(":dimensoes", $postjson['dimensoes']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->execute();

     $idPonto = $pdo->lastInsertId();
     
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPonto'=>$idPonto));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  




}else if($postjson['requisicao'] == 'editar'){

  $query = $pdo->prepare("UPDATE pontos SET potencia = :potencia, consumo = :consumo,
   status = :status, endereco = :endereco, complemento = :complemento, latitude = :latitude,
    longitude = :longitude, cidade = :cidade, bairro = :bairro,
     pontoReferencia = :pontoReferencia, uf = :uf, cep = :cep,
      fabricante = :fabricante, tipoPoste = :tipoPoste,
       dimensoes = :dimensoes, observacoes = :observacoes where idPonto = :idPonto ");

  $query->bindValue(":potencia", $postjson['potencia']);
  $query->bindValue(":consumo", $postjson['consumo']);
  $query->bindValue(":status", $postjson['status']);
  $query->bindValue(":endereco", $postjson['endereco']);
  $query->bindValue(":complemento", $postjson['complemento']);
  $query->bindValue(":latitude", $postjson['latitude']);
  $query->bindValue(":longitude", $postjson['longitude']);
  $query->bindValue(":cidade", $postjson['cidade']);
  $query->bindValue(":bairro", $postjson['bairro']);
  $query->bindValue(":pontoReferencia", $postjson['pontoReferencia']);
  $query->bindValue(":uf", $postjson['uf']);
  $query->bindValue(":cep", $postjson['cep']);
  $query->bindValue(":fabricante", $postjson['fabricante']);
  $query->bindValue(":tipoPoste", $postjson['tipoPoste']);
  $query->bindValue(":dimensoes", $postjson['dimensoes']);
  $query->bindValue(":observacoes", $postjson['observacoes']);
  $query->bindValue(":idPonto", $postjson['idPonto']);
  $query->execute();

     $idPonto = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idPonto'=>$idPonto));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  

}else if($postjson['requisicao'] == 'excluir'){

   $query = $pdo->query("DELETE from pontos where idPonto = '$postjson[idPonto]' ");

   if($query){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
}



  ?>