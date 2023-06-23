<?php
if (isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
} else {
    // Tratar caso a chave não esteja definida
}

if (isset($_POST['idProduto'])) {
    $idProduto = $_POST['idProduto'];
} else {
    // Tratar caso a chave não esteja definida
}

// Conectar ao banco de dados
$dbHost = 'localhost';
$dbName = 'saep';
$dbUser = 'root';
$dbPass = 'senai';
$db = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);

// Verificar se o produto já está favoritado pelo usuário
$stmt = $db->prepare('SELECT * FROM favorite WHERE idUsuario = :idUsuario AND idProduto = :idProduto');
$stmt->bindParam(':idUsuario', $idUsuario);
$stmt->bindParam(':idProduto', $idProduto);
$stmt->execute();
$existeFavorito = $stmt->rowCount() > 0;

if ($existeFavorito) {
    // Remover o produto dos favoritos do usuário
    $stmt = $db->prepare('DELETE FROM favorite WHERE idUsuario = :idUsuario AND idProduto = :idProduto');
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idProduto', $idProduto);
    $stmt->execute();
} else {
    // Adicionar o produto aos favoritos do usuário
    $stmt = $db->prepare('INSERT INTO favorite (idUsuario, idProduto) VALUES (:idUsuario, :idProduto)');
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':idProduto', $idProduto);
    $stmt->execute();
}

// Responder à requisição AJAX com sucesso
http_response_code(200);
?>
