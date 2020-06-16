<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


//LISTAGEM DOS mandatos E PESQUISA PELO NOME E EMAIL

if($postjson['requisicao'] == 'listar'){

 if($postjson['textoBuscar'] == ''){
  $query = mysqli_query($mysqli, "select * from mandato order by idMandato asc");
}else{
  $busca = $postjson['textoBuscar'] . '%';
  $query = mysqli_query($mysqli, "select * from mandato where descricao LIKE '$busca' or idMandato LIKE '$busca' order by idMandato desc ");
}

while($row = mysqli_fetch_array($query)){ 
  $dados2[] = array(
    'idMandato' => $row['idMandato'], 
    'descricao' => $row['descricao'],
    'dataInicio' => $row['dataInicio'],
    'dataFinal' => $row['dataFinal'],       
  );

}

if($query){
  $result = json_encode(array('success'=>true, 'result'=>$dados2));

}else{
  $result = json_encode(array('success'=>false));

}
echo $result;




}else if($postjson['requisicao'] == 'add'){

 $query = mysqli_query($mysqli, "INSERT INTO mandato SET descricao = '$postjson[descricao]', dataInicio = '$postjson[dataInicio]', dataFinal = '$postjson[dataFinal]' ");

 $idMandato = mysqli_insert_id($mysqli);
 

 if($query){
  $result = json_encode(array('success'=>true, 'idMandato'=>$idMandato));

}else{
  $result = json_encode(array('success'=>false));

}
echo $result;

}else if($postjson['requisicao'] == 'editar'){

 $query = mysqli_query($mysqli, "UPDATE mandato SET descricao = '$postjson[descricao]', dataInicio = '$postjson[dataInicio]', dataFinal = '$postjson[dataFinal]' WHERE idMandato = '$postjson[idMandato]' ");

 $idMandato = mysqli_insert_id($mysqli);
 

 if($query){
  $result = json_encode(array('success'=>true, 'idMandato'=>$idMandato));

}else{
  $result = json_encode(array('success'=>false));

}
echo $result;

}else if($postjson['requisicao'] == 'excluir'){

 $query = mysqli_query($mysqli, "delete from mandato where idMandato = '$postjson[idMandato]' ");

 $idMandato = mysqli_insert_id($mysqli);
 

 if($query){
  $result = json_encode(array('success'=>true, 'idMandato'=>$idMandato));

}else{
  $result = json_encode(array('success'=>false));

}
echo $result;

}




