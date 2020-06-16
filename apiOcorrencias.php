<?php

include_once('conexao.php');

header("Content-Type: text/html; charset=UTF-8",true);

$postjson = json_decode(file_get_contents('php://input'), true);

$subject = ['.',','];
$replace =['','.'];





//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){


    if($postjson['textoBuscar'] == ''){
        $query = $pdo->query("SELECT * from ocorrencias order by idOcorrencia desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = $pdo->query("SELECT * from ocorrencias where cidade LIKE _utf8'%$busca%' or municipio LIKE _utf8'%$busca%' order by idOcorrencia desc limit $postjson[start], $postjson[limit] ");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

  for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
    $dados[] = array(
      
      'idOcorrencia' => $res[$i]['idOcorrencia'],
      'municipio' => $res[$i]['municipio'],
      'solicitante' => $res[$i]['solicitante'],
      'endereco' => $res[$i]['endereco'],
      'complemento' => $res[$i]['complemento'],
      'bairro' => $res[$i]['bairro'],
      'cep' => $res[$i]['cep'],
      'pontoReferencia' => $res[$i]['pontoReferencia'],
      'UF' => $res[$i]['UF'],
      'cod_ponto' => $res[$i]['cod_ponto'],
      'origem' => $res[$i]['origem'],
      'dataAbertura' => $res[$i]['dataAbertura'],
      'dataAutorizacao' => $res[$i]['dataAutorizacao'],
      'dataFechamento' => $res[$i]['dataFechamento'],
      'prioridade' => $res[$i]['prioridade'],
      'situacao' => $res[$i]['situacao'],
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

  $query = $pdo->prepare("INSERT INTO ocorrencias SET municipio = :municipio, solicitante = :solicitante, endereco = :endereco,
   complemento = :complemento, bairro = :bairro, cep = :cep, pontoReferencia = :pontoReferencia,
     uf = :uf, cod_ponto = :cod_ponto, origem = :origem, dataAbertura = :dataAbertura, dataAutorizacao = :dataAutorizacao, dataFechamento = :dataFechamento, 
     prioridade = :prioridade, situacao = :situacao, observacoes = :observacoes ");

     $query->bindValue(":municipio", $postjson['municipio']);
     $query->bindValue(":solicitante", $postjson['solicitante']);
     $query->bindValue(":endereco", $postjson['endereco']);
     $query->bindValue(":complemento", $postjson['complemento']);
     $query->bindValue(":bairro", $postjson['bairro']);
     $query->bindValue(":cep", $postjson['cep']);
     $query->bindValue(":pontoReferencia", $postjson['pontoReferencia']);
     $query->bindValue(":uf", $postjson['uf']);
     $query->bindValue(":cod_ponto", $postjson['cod_ponto']);
     $query->bindValue(":origem", $postjson['origem']);
     $query->bindValue(":dataAbertura", $postjson['dataAbertura']);
     $query->bindValue(":dataAutorizacao", $postjson['dataAutorizacao']);
     $query->bindValue(":dataFechamento", $postjson['dataFechamento']);
     $query->bindValue(":prioridade", $postjson['prioridade']);
     $query->bindValue(":situacao", $postjson['situacao']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->execute();

     $idOcorrencia = $pdo->lastInsertId();
     
     

    if($query){
    $result = json_encode(array('success'=>true, 'idOcorrencia'=>$idOcorrencia));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  




}else if($postjson['requisicao'] == 'editar'){

  $query = $pdo->prepare("UPDATE ocorrencias SET municipio = :municipio, solicitante = :solicitante, endereco = :endereco,
  complemento = :complemento, bairro = :bairro, cep = :cep, pontoReferencia = :pontoReferencia,
    uf = :uf, cod_ponto = :cod_ponto, origem = :origem, dataAbertura = :dataAbertura, dataAutorizacao = :dataAutorizacao, dataFechamento = :dataFechamento, 
    prioridade = :prioridade, situacao = :situacao, observacoes = :observacoes where idOcorrencia = :idOcorrencia ");

  $query->bindValue(":municipio", $postjson['municipio']);
  $query->bindValue(":solicitante", $postjson['solicitante']);
  $query->bindValue(":endereco", $postjson['endereco']);
  $query->bindValue(":complemento", $postjson['complemento']);
  $query->bindValue(":bairro", $postjson['bairro']);
  $query->bindValue(":cep", $postjson['cep']);
  $query->bindValue(":pontoReferencia", $postjson['pontoReferencia']);
  $query->bindValue(":uf", $postjson['uf']);
  $query->bindValue(":cod_ponto", $postjson['cod_ponto']);
  $query->bindValue(":origem", $postjson['origem']);
  $query->bindValue(":dataAbertura", $postjson['dataAbertura']);
  $query->bindValue(":dataAutorizacao", $postjson['dataAutorizacao']);
  $query->bindValue(":dataFechamento", $postjson['dataFechamento']);
  $query->bindValue(":prioridade", $postjson['prioridade']);
  $query->bindValue(":situacao", $postjson['situacao']);
  $query->bindValue(":observacoes", $postjson['observacoes']);
  $query->bindValue(":idOcorrencia", $postjson['idOcorrencia']);
  $query->execute();

     $idOcorrencia = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idOcorrencia'=>$idOcorrencia));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  

}else if($postjson['requisicao'] == 'excluir'){

   $query = $pdo->query("DELETE from ocorrencias where idOcorrencia = '$postjson[idOcorrencia]' ");

   if($query){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
}



  ?>