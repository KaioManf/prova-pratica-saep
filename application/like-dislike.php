<?php
// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Recuperar os dados enviados
  $idProduto = $_POST['id_produto'];
  $idUsuario = $_POST['id_usuario'];
  $action = $_POST['action'];

  // Realizar as operações necessárias no banco de dados com os dados fornecidos

  // Dados de conexão com o banco de dados
  $strConnection = "mysql:host=localhost;dbname=db_produtos";
  $username = "root";
  $password = "senai";

  try {
    // Criar uma nova conexão PDO
    $conexao = new PDO($strConnection, $username, $password);

    // Definir o modo de erro do PDO para exceções
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o usuário já registrou o like ou dislike para o produto
    $sqlVerificaAcao = "SELECT * FROM review WHERE id_produto = :idProduto AND id_usuario = :idUsuario";
    $stmtVerificaAcao = $conexao->prepare($sqlVerificaAcao);
    $stmtVerificaAcao->bindParam(':idProduto', $idProduto);
    $stmtVerificaAcao->bindParam(':idUsuario', $idUsuario);
    $stmtVerificaAcao->execute();
    $resultAcao = $stmtVerificaAcao->fetch(PDO::FETCH_ASSOC);

    if ($resultAcao) {
      // O usuário já registrou o like ou dislike anteriormente, então atualizamos o registro existente
      if ($action === 'like' && $resultAcao['likes'] == 0) {
        $sqlUpdate = "UPDATE review SET likes = 1, dislikes = 0 WHERE id_produto = :idProduto AND id_usuario = :idUsuario";
        $increment = 1;
      } elseif ($action === 'dislike' && $resultAcao['dislikes'] == 0) {
        $sqlUpdate = "UPDATE review SET likes = 0, dislikes = 1 WHERE id_produto = :idProduto AND id_usuario = :idUsuario";
        $increment = 1;
      } else {
        $sqlUpdate = "UPDATE review SET likes = 0, dislikes = 0 WHERE id_produto = :idProduto AND id_usuario = :idUsuario";
        $increment = -1;
      }

      // Preparar a query de atualização
      $stmtUpdate = $conexao->prepare($sqlUpdate);
      $stmtUpdate->bindParam(':idProduto', $idProduto);
      $stmtUpdate->bindParam(':idUsuario', $idUsuario);
      $stmtUpdate->execute();

      // Verificar se a operação foi realizada com sucesso
      if ($stmtUpdate->rowCount() > 0) {
        // Ação atualizada com sucesso
        echo json_encode(array('success' => true, 'increment' => $increment));
      } else {
        // Nenhum registro foi afetado (erro ao atualizar)
        echo json_encode(array('success' => false));
      }
    } else {
      // O usuário ainda não registrou o like ou dislike, então inserimos um novo registro
      if ($action === 'like') {
        $sqlInsert = "INSERT INTO review (id_produto, id_usuario, likes, dislikes) VALUES (:idProduto, :idUsuario, 1, 0)";
        $increment = 1;
      } elseif ($action === 'dislike') {
        $sqlInsert = "INSERT INTO review (id_produto, id_usuario, likes, dislikes) VALUES (:idProduto, :idUsuario, 0, 1)";
        $increment = 1;
      } else {
        $sqlInsert = "INSERT INTO review (id_produto, id_usuario, likes, dislikes) VALUES (:idProduto, :idUsuario, 0, 0)";
        $increment = -1;
      }

      // Preparar a query de inserção
      $stmtInsert = $conexao->prepare($sqlInsert);
      $stmtInsert->bindParam(':idProduto', $idProduto);
      $stmtInsert->bindParam(':idUsuario', $idUsuario);
      $stmtInsert->execute();

      // Verificar se a operação foi realizada com sucesso
      if ($stmtInsert->rowCount() > 0) {
        // Ação registrada com sucesso
        echo json_encode(array('success' => true, 'increment' => $increment));
      } else {
        // Nenhum registro foi afetado (erro ao inserir)
        echo json_encode(array('success' => false));
      }
    }
  } catch (PDOException $e) {
    // Ocorreu um erro ao conectar ou executar a query
    echo json_encode(array('success' => false));
  }
} else {
  // Método de requisição inválido
  echo json_encode(array('success' => false));
}
?>