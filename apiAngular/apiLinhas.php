<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


//LISTAGEM DOS linhas E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){

     if($postjson['textoBuscar'] == ''){
      $query = mysqli_query($mysqli, "select * from linhas order by id desc limit $postjson[start], $postjson[limit]");
    }else{
      $busca = $postjson['textoBuscar'] . '%';
      $query = mysqli_query($mysqli, "select * from linhas where cod_acesso LIKE '$busca' or num_conta LIKE '$busca' order by id desc limit $postjson[start], $postjson[limit]");
    }
   
  while($row = mysqli_fetch_array($query)){ 
    $dados2[] = array(
      'id' => $row['id'], 
      'operadora' => $row['operadora'],
      'cod_acesso' => $row['cod_acesso'],
      'num_conta' => $row['num_conta'],
      'localizacao' => $row['localizacao'],                   
    );

 }

        if($query){
                $result = json_encode(array('success'=>true, 'result'=>$dados2));

            }else{
                $result = json_encode(array('success'=>false));

            }
            echo $result;




  }else if($postjson['requisicao'] == 'add'){

       $query = mysqli_query($mysqli, "INSERT INTO linhas SET operadora = '$postjson[operadora]', cod_acesso = '$postjson[cod_acesso]', num_conta = '$postjson[num_conta]', localizacao = '$postjson[localizacao]' ");

     $id = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'id'=>$id));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

   }else if($postjson['requisicao'] == 'editar'){

       $query = mysqli_query($mysqli, "UPDATE linhas SET operadora = '$postjson[operadora]', cod_acesso = '$postjson[cod_acesso]', num_conta = '$postjson[num_conta]', localizacao = '$postjson[localizacao]' WHERE id = '$postjson[id]' ");

     $id = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'id'=>$id));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

    }else if($postjson['requisicao'] == 'excluir'){

       $query = mysqli_query($mysqli, "delete from linhas where id = '$postjson[id]' ");

     $id = mysqli_insert_id($mysqli);
     

    if($query){
    $result = json_encode(array('success'=>true, 'id'=>$id));

  }else{
    $result = json_encode(array('success'=>false));

  }
   echo $result;

   }

   
       

