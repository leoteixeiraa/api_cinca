<?php

include_once('conexao.php');

header("Content-Type: text/html; charset=UTF-8",true);

$postjson = json_decode(file_get_contents('php://input'), true);





//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){


    if($postjson['textoBuscar'] == ''){
        $query = $pdo->query("SELECT * from servicos order by idServico desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = $pdo->query("SELECT * from servicos where descricao LIKE _utf8'%$busca%' or cod_lcin LIKE '%$busca%' order by idServico desc limit $postjson[start], $postjson[limit]");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

  for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
    $dados[] = array(
      'idServico' => $res[$i]['idServico'],
      'cod_lcin' => $res[$i]['cod_lcin'],
      'descricao' => $res[$i]['descricao'],
      'custoUnit' => number_format((float)$res[$i]['custoUnit'], 2, ",", "."),
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

  $query = $pdo->prepare("INSERT INTO servicos SET cod_lcin = :cod_lcin, descricao = :descricao, custoUnit = :custoUnit, marca = :marca, observacoes = :observacoes ");

     $query->bindValue(":cod_lcin", $postjson['cod_lcin']);
     $query->bindValue(":descricao", $postjson['descricao']);
     $postjson['custoUnit'] = str_replace(',','.',str_replace('.','',$postjson['custoUnit']));
     $query->bindValue(":marca", $postjson['marca']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->execute();

     $idServico = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idServico'=>$idServico));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  




}else if($postjson['requisicao'] == 'editar'){

  $query = $pdo->prepare("UPDATE servicos SET cod_lcin = :cod_lcin, descricao = :descricao, custoUnit = :custoUnit, marca = :marca, observacoes = :observacoes where idServico = :idServico ");

     $query->bindValue(":cod_lcin", $postjson['cod_lcin']);
     $query->bindValue(":descricao", $postjson['descricao']);
     $postjson['custoUnit'] = str_replace(',','.',str_replace('.','',$postjson['custoUnit']));
     $query->bindValue(":marca", $postjson['marca']);
     $query->bindValue(":observacoes", $postjson['observacoes']);
     $query->bindValue(":idServico", $postjson['idServico']);
     $query->execute();

     $idServico = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'idServico'=>$idServico));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  

}else if($postjson['requisicao'] == 'excluir'){

   $query = $pdo->query("DELETE from servicos where idServico = '$postjson[idServico]' ");

   if($query){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
}



  ?>