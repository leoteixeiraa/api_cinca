<?php

include_once('conexao.php');

header("Content-Type: text/html; charset=UTF-8",true);

$postjson = json_decode(file_get_contents('php://input'), true);





//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){


    if($postjson['textoBuscar'] == ''){
        $query = $pdo->query("SELECT * from materiais order by idMaterial desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = $pdo->query("SELECT * from materiais where descricao LIKE _utf8'%$busca%' or cod_lcin LIKE '%$busca%' order by idMaterial desc limit $postjson[start], $postjson[limit]");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

  for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
    $dados[] = array(
      'idMaterial' => $res[$i]['idMaterial'],
      'cod_lcin' => $res[$i]['cod_lcin'],
      'descricao' => $res[$i]['descricao'],
      'unidade' => $res[$i]['unidade'],
      'quantidade' => $res[$i]['quantidade'],
      'custoUnit' => $res[$i]['custoUnit'],
      'marca' => $res[$i]['marca'],
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

  $query = $pdo->prepare("INSERT INTO materiais SET cod_lcin = :cod_lcin, descricao = :descricao, unidade = :unidade, quantidade = :quantidade, custoUnit = :custoUnit, marca = :marca, observacoes = :observacoes ");

     $query->bindValue(":cod_lcin", $postjson['cod_lcin']);
     $query->bindValue(":descricao", $postjson['descricao']);
     $query->bindValue(":unidade", $postjson['unidade']);
     $query->bindValue(":quantidade", $postjson['quantidade']);
     $query->bindValue(":custoUnit", $postjson['custoUnit']);
     $query->bindValue(":marca", $postjson['marca']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->execute();

     $idMaterial = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idMaterial'=>$idMaterial));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  




}else if($postjson['requisicao'] == 'editar'){

  $query = $pdo->prepare("UPDATE materiais SET cod_lcin = :cod_lcin, descricao = :descricao, unidade = :unidade, quantidade = :quantidade, custoUnit = :custoUnit, marca = :marca, observacoes = :observacoes where idMaterial = :idMaterial ");

     $query->bindValue(":cod_lcin", $postjson['cod_lcin']);
     $query->bindValue(":descricao", $postjson['descricao']);
     $query->bindValue(":unidade", $postjson['unidade']);
     $query->bindValue(":quantidade", $postjson['quantidade']);
     $query->bindValue(":custoUnit", $postjson['custoUnit']);
     $query->bindValue(":marca", $postjson['marca']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->bindValue(":idMaterial", $postjson['idMaterial']);
     $query->execute();

     $idMaterial = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idMaterial'=>$idMaterial));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  

}else if($postjson['requisicao'] == 'excluir'){

   $query = $pdo->query("DELETE from materiais where idMaterial = '$postjson[idMaterial]' ");

   if($query){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
}



  ?>