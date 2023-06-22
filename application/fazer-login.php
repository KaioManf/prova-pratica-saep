<?php
    // Validação de dados
    $email = isset($_POST['txtUsuario']) ? $_POST['txtUsuario'] : '';
    $senha = isset($_POST['txtSenha']) ? $_POST['txtSenha'] : '';

    if (empty($email) || empty($senha)) {
        header('LOCATION: ../index.php');
        exit;
    }

    // Se passou pela validação, continua a partir daqui

    // Conexão com Banco de Dados
    $strConnection = "mysql:host=localhost;dbname=saep";
    $db_usuario = 'root';
    $db_senha = 'senai';
    $conexao = new PDO($strConnection, $db_usuario, $db_senha);

    // Executar consulta no BD
    $sql = 'SELECT * FROM usuarios WHERE email=:user AND senha=:pass';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':user', $email);
    $stmt->bindParam(':pass', $senha);
    $stmt->execute();

    // Verificar se a consulta no BD retornou pelo menos uma linha
    if ($stmt->rowCount() > 0) {
        // Abrindo uma sessão
        session_start();
        $_SESSION['logado'] = TRUE;

        // Encaminhando usuário para o Sistema
        header('LOCATION: ../index.php');
    } else {
        echo '<script> 
                alert("Usuário ou senha inválidos. Verifique!");
                window.location = "../index.php";
        </script>';
    }