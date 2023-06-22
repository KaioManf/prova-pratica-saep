<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro de Produto - SISTEMA</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/home.css">

  <!-- Boostrap -->
  <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="vendor/bootstrap-5.3.0-dist/css/bootstrap-utilities.min.css">
</head>
<body class="bg-body-tertiary">
  <div class="container">
    <main>
      <div class="py-5 text-center">
        <h2>CADASTRO DE PRODUTO</h2>
      </div>

      <div class="row g-5">
        <div class="col-md-12">
          <form action="application/inserir-produto.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="txtID" class="form-label">ID</label>
                <input type="text" class="form-control" id="txtID" name="txtID" readonly value="NOVO">
              </div>

              <div class="col-sm-6">
                <label for="txtNome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="txtNome" name="txtNome">
              </div>

              <div class="col-12">
                <label for="fileFotoProduto" class="form-label">Foto do Produto</label>
                <input type="file" class="form-control" id="fileFotoProduto" name="fileFotoProduto">
              </div>

              <hr class="my-4">

              <div class="col-sm-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">Salvar</button>
              </div>

              <div class="col-sm-4">
                <button class="w-100 btn btn-secondary btn-lg" type="reset">Cancelar</button>
              </div>

              <div class="col-sm-4">
                <a class="w-100 btn btn-danger btn-lg" href="application/fazer-logout.php">Sair</a>
              </div>
          </form>
        </div>
      </div>
    </main>

    <footer class="my-5 pt-5 text-body-secondary text-center text-small">
      <p class="mb-1">Projeto SA</p>
    </footer>
  </div>
  
    <!-- Scripts -->
    <!-- JQuery -->
    <script type="text/javascript" src="vendor/jquery-3.7.0/jquery-3.7.0.min.js"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="vendor/bootstrap-5.3.0-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="vendor/bootstrap-5.3.0-dist/js/bootstrap-esm.min.js"></script>
    <script type="text/javascript" src="vendor/bootstrap-5.3.0-dist/js/bootstrap-bundle.min.js"></script>
</body>
</html>