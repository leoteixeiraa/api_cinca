<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


//LISTAGEM DOS USUARIOS E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){

  if($postjson['textoBuscar'] == ''){
  $query = mysqli_query($mysqli, "select * from usuario order by idUser asc");
}else{
  $busca = $postjson['textoBuscar'] . '%';
  $query = mysqli_query($mysqli, "select * from usuario where nome LIKE '$busca' or login LIKE '$busca' order by idUser desc ");
}
  while($row = mysqli_fetch_array($query)){ 
    $dados2[] = array(
      'idUser' => $row['idUser'], 
      'nome' => $row['nome'],
      'login' => $row['login'],
      'senha' => $row['senha'],                   
    );

 }

        if($query){
                $result = json_encode(array('success'=>true, 'result'=>$dados2));

            }else{
                $result = json_encode(array('success'=>false));

            }
            echo $result;




  }else if($postjson['requisicao'] == 'add'){

     $query = mysqli_query($mysqli, "INSERT INTO usuario SET nome = '$postjson[nome]', login = '$postjson[login]', senha = '$postjson[senha]' ");

     $idUser = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'idUser'=>$idUser));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

   }else if($postjson['requisicao'] == 'editar'){

       $query = mysqli_query($mysqli, "UPDATE usuario SET nome = '$postjson[nome]', login = '$postjson[login]', senha = '$postjson[senha]' WHERE idUser = '$postjson[idUser]' ");

     $idUser = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'idUser'=>$idUser));

  }else{
    $result = json_encode(array('success'=>false));

  }
  echo $result;

  }else if($postjson['requisicao'] == 'excluir'){

   $query = mysqli_query($mysqli, "DELETE from usuario where idUser = '$postjson[idUser]' ");

   $idUser = mysqli_insert_id($mysqli);

    if($query){
    $result = json_encode(array('success'=>true, 'idUser'=>$idUser));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

   }else if($postjson['requisicao'] == 'login'){

    $query = mysqli_query($mysqli, "SELECT * from usuario where login = '$postjson[login]' and senha = '$postjson[senha]' ");

    $result = mysqli_num_rows($query);

  

     if($result > 0){
     $result = json_encode(array('success'=>true));

    }else{
     $result = json_encode(array('success'=>false));

    }
    echo $result;

       }