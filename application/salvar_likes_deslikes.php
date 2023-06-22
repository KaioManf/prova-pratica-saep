<?php
session_start();

// Função para realizar a conexão com o banco de dados
function conectarBancoDados() {
    $strConnection = "mysql:host=localhost;dbname=saep";
    $db_usuario = 'root';
    $db_senha = 'senai';
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);
    return $conexao;
}

// Função para salvar o like
function salvarLike($produto_id, $usuario_id, $conexao) {
    $sql = "INSERT INTO likes (idUsuario, idProduto) VALUES (:usuario_id, :produto_id)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':produto_id', $produto_id);
    $stmt->execute();
}

// Função para salvar o deslike
function salvarDeslike($produto_id, $usuario_id, $conexao) {
    $sql = "INSERT INTO dislike (idUsuario, idProduto) VALUES (:usuario_id, :produto_id)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':produto_id', $produto_id);
    $stmt->execute();
}

// Verificar se os dados foram enviados corretamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o botão de like foi clicado
    if (isset($_POST['like'])) {
        $produto_id = $_POST['produto_id'];
        $usuario_id = $_SESSION['usuario_id']; // OU OUTRA FORMA DE OBTER O ID DO USUÁRIO
        $conexao = conectarBancoDados();
        salvarLike($produto_id, $usuario_id, $conexao);
    }
    // Verificar se o botão de deslike foi clicado
    elseif (isset($_POST['deslike'])) {
        $produto_id = $_POST['produto_id'];
        $usuario_id = $_SESSION['usuario_id']; // OU OUTRA FORMA DE OBTER O ID DO USUÁRIO
        $conexao = conectarBancoDados();
        salvarDeslike($produto_id, $usuario_id, $conexao);
    }
}

// Consulta para obter os produtos e suas informações
$sql = 'SELECT * FROM produtos';
$conexao = conectarBancoDados();
$stmt = $conexao->prepare($sql); 
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Imprimindo os dados no álbum
if (!empty($dados)) {
    foreach ($dados as $linha) {
        $produto_id = $linha['idProduto'];
        $count_likes = 0;
        $count_deslikes = 0;

        // Consulta para obter a contagem de likes
        $sql_likes = "SELECT COUNT(*) as count_likes FROM likes WHERE idProduto = :produto_id";
        $stmt_likes = $conexao->prepare($sql_likes);
        $stmt_likes->bindParam(':produto_id', $produto_id);
        $stmt_likes->execute();
        $count_likes = $stmt_likes->fetchColumn();

        // Consulta para obter a contagem de deslikes
        $sql_deslikes = "SELECT COUNT(*) as count_deslikes FROM dislike WHERE idProduto = :produto.id";
        $stmt_deslikes = $conexao->prepare($sql_deslikes);
        $stmt_deslikes->bindParam(':produto_id', $produto_id);
        $stmt_deslikes->execute();
        $count_deslikes = $stmt_deslikes->fetchColumn();
            // Imprimir as informações do produto
        echo "Produto: " . $linha['nome'] . "<br>";
        echo "Descrição: " . $linha['descricao'] . "<br>";
        echo "Likes: " . $count_likes . "<br>";
        echo "Deslikes: " . $count_deslikes . "<br>";

        // Botões de like e deslike
        echo "<form method='POST'>";
        echo "<input type='hidden' name='produto_id' value='" . $produto_id . "'>";
        echo "<input type='submit' name='like' value='Like'>";
        echo "<input type='submit' name='deslike' value='Deslike'>";
        echo "</form>";

        echo "<br>";
        }
    } else {
        echo "Nenhum produto encontrado.";
    }
?>