<?php
    session_start();
    if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {
        // Usuário não logado - exibir mensagem de erro e redirecionar
        echo '<script>alert("Faça login para acessar a página de favoritos."); window.location.href = "index.php";</script>';
        exit(); // Encerrar a execução para que o restante da página não seja exibido
    }
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - SISTEMA</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap-utilities.min.css">
</head>
<body>
    <header>
        <a href="index.php" class="nav-link px-2 link-secondary"><h5>Veste VC</h5></a>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 link-secondary">Favoritos</a></li>
                <?php
                if (isset($_SESSION['logado']) && $_SESSION['logado']) {
                    // Usuário logado
                    echo '
                    <li class="nav-item">
                        <a href="application/fazer-logout.php" class="nav-link px-2 link-secondary">Logout</a>
                    </li>
                    ';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php 
                        // SCRIPT PHP PARA SELECIONAR OS PRODUTOS NO BD E IMPRIMIR NO ALBUM

                        // CONEXÃO COM O BD
                        $strConnection = "mysql:host=localhost;dbname=saep";
                        $db_usuario = 'root';
                        $db_senha = 'senai';
                        $conexao = new PDO($strConnection, $db_usuario, $db_senha);

                        // SQL
                        $sql = "SELECT * FROM favorite";
                        
                        // EXECUNTADO O SQL NO BD
                        $sql = 'SELECT * FROM favorite';
                        $stmt = $conexao->prepare($sql); 
                        $stmt->execute();
                        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        // IMPRIMINDO OS DADOS NO ALBUM
                        if (!empty($dados)) {
                            foreach ($dados as $linha) {
                                echo "<div class='col'>
                                        <div class='card shadow-sm'>
                                            <div class='card-body'>
                                                <p class='card-text'>Produto: <strong>{$linha['idProduto']}</strong></p>
                                            </div>
                                        </div>
                                    </div>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div id="footer">
            <div class="comment">
                <h1 id="yay">VESTE VC</h1>
            </div>
            <hr>
            <p class="yay">&copy; 2023 - Todos os direitos reservados</p>
            <br><br><br>
        </div>
    </footer>
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="application/fazer-login.php" method="POST" onsubmit="return validateForm()">
                        <div id="errorAlert" class="alert alert-danger border border-danger" role="alert" style="display: none;"></div>
                        <div class="mb-3">
                            <label for="txtUsuario" class="form-label">E-mail:</label>
                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="E-mail">
                        </div>
                        <div class="mb-3">
                            <label for="txtSenha" class="form-label">Senha:</label>
                            <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="Senha">
                        </div>
                        <button type="button" class="btn btn-light text-dark" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="vendor/bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function validateForm() {
            const usuario = document.getElementById('txtUsuario').value;
            const senha = document.getElementById('txtSenha').value;

            if (usuario.trim() === '' || senha.trim() === '') {
                const errorAlert = document.getElementById('errorAlert');
                errorAlert.style.display = 'block';
                errorAlert.innerText = 'Por favor, preencha todos os campos.';
                return false;
            }
        }
    </script>
</body>
</html>