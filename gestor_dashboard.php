<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>gestor</title>
</head>
<body>

<header>

    <nav class="navbar bg-secondary">
  <div class="container-fluid">
    <a class="navbar-brand text-light">SGM|Gestão Administrativa</a>
    <form class="d-flex" role="search">
      <a class="btn btn-outline-light p-2 text-light" href="api/logout.php">Sair</a>
    </form>
  </div>
</nav>
</header>
    
    <main class="container ">

 <div class="row d-flex justify-content-center p-4">
  <div class="col-sm-3 mb-3 mb-sm-0 ">
    <div class="card bg-primary">
      <div class="card-body">
        <h5 class="card-title ">Novas solicitações</h5>
        <h2 class="card-text">0</h2>
       
      </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="card bg-warning">
      <div class="card-body ">
        <h5 class="card-title">Em Andamento</h5>
        <h2 class="card-text">0</h2>
      
      </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="card bg-danger">
      <div class="card-body">
        <h5 class="card-title">Críticos | Urgentes</h5>
        <h2 class="card-text">0</h2>
      
      </div>
    </div>
  </div>
</div>


<div class="row  p-4 d-flex justify-content-center">
    <button type="button" class="btn btn-secondary btn-lg col-4 m-5"><i class="bi bi-list"></i> Gerenciar os chamados</button>
    <button type="button" class="btn btn-ligth border-primary text-primary btn-lg col-3 m-5"><i class="bi bi-geo-alt"></i> Configurar os Ambientes</button>
</div>


    </main>

</body>
</html>