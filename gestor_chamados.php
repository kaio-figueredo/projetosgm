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

    <nav class="navbar bg-black" >
  <div class="container-fluid">
    <a class="navbar-brand text-light">SGM Técnico | João Técnico</a>
    <form class="d-flex" role="search">
    
    <ul class="nav justify-content-end">
        <li class="nav-item">
    <a class="nav-link text-light p-2 " href="">Chamados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="">Locais</a>
</ul>

    <a class="btn btn-outline-light p-2 text-light" href="api/logout.php">Sair</a>
    
    </form>
  </div>
</nav>
</header>
<main>

<nav class="navbar" >
  <div class="container-fluid">
    <a class="navbar-brand text-dark p-2 m-2 fs-2">Todos os Chamados</a>

  </div>
</nav>

<div class="container">
    <button type="button" class="btn btn-outline-secondary">Todos</button>
<button type="button" class="btn btn-outline-primary">Abertos</button>
<button type="button" class="btn btn-outline-warning">Em Execução</button>
<button type="button" class="btn btn-outline-success">Em Execução</button>
</div>

<div class="container">

    <table class="table p-5 border shadow m-3 rounded">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Solicitante</th>
      <th scope="col">Local/Tipo</th>
      <th scope="col">Prioridade</th>
      <th scope="col">Técnico</th>
      <th scope="col">Status</th>
      <th scope="col">Ações</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">#1</th>
      <td>Maria Solicitante</td>
      <td>BLOCO 2</td>
      <td><i class="bi bi-circle-fill text-warning"></i> Alta</td>
      <td>João Técnico</td>
      <td>
        <span class="bg-secondary rounded text-light p-1">FECHADO</span>
     </td>
     <td>
        <span class="bg-primary rounded text-light p-1"><i class="bi bi-eye text-light"></i> Gerenciar</span>
     </td>
    </tr>
  </tbody>
</table>
</div>
</main>
</body>
</html>