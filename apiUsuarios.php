<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){


    if($postjson['textoBuscar'] == ''){
        $query = $pdo->query("SELECT * from usuarios order by id desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = $pdo->query("SELECT * from usuarios where nome LIKE '$busca' or usuario LIKE '$busca' order by id desc limit $postjson[start], $postjson[limit]");
    }


    $res = $query->fetchAll(PDO::FETCH_ASSOC);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
 		$dados[] = array(
 			'id' => $res[$i]['id'],
 			'nome' => $res[$i]['nome'],
			'usuario' => $res[$i]['usuario'],
      'senha' => $res[$i]['senha'],
            
        
 		);

 }

        if($query){
                $result = json_encode(array('success'=>true, 'result'=>$dados));

            }else{
                $result = json_encode(array('success'=>false));

            }
            echo $result;



}else if($postjson['requisicao'] == 'add'){

  $query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, usuario = :usuario, senha = :senha ");

     $query->bindValue(":nome", $postjson['nome']);
     $query->bindValue(":usuario", $postjson['usuario']);
     $query->bindValue(":senha", $postjson['senha']);
     $query->execute();

     $id = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'id'=>$id));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  




}else if($postjson['requisicao'] == 'editar'){

  $query = $pdo->prepare("UPDATE usuarios SET nome = :nome, usuario = :usuario, senha = :senha where id = :id ");

     $query->bindValue(":nome", $postjson['nome']);
     $query->bindValue(":usuario", $postjson['usuario']);
     $query->bindValue(":senha", $postjson['senha']);
     $query->bindValue(":id", $postjson['id']);
     $query->execute();

     $id = $pdo->lastInsertId();
     

    if($query){
    $result = json_encode(array('success'=>true, 'id'=>$id));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;
  

}else if($postjson['requisicao'] == 'excluir'){

   $query = $pdo->query("DELETE from usuarios where id = '$postjson[id]' ");

   if($query){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;




}else if($postjson['requisicao'] == 'login'){

   $query = $pdo->query("SELECT * from usuarios where usuario = '$postjson[usuario]' and senha = '$postjson[senha]'");

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $linhas = count($res);

  if($linhas > 0){
    $result = json_encode(array('success'=>true));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;


}

  ?>