<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>gestor</title>
</head>
<body>

<header>

    <nav class="navbar bg-secondary" >
  <div class="container-fluid">
    <a class="navbar-brand text-light">SGM Técnico | João Técnico</a>
    <form class="d-flex" role="search">

    <a class="btn btn-outline-light p-2 text-light" href="api/logout.php">Sair</a>
    
    </form>
  </div>
</nav>
</header>
<main>

<nav class="navbar" >
  <div class="container-fluid">
    <a class="navbar-brand text-dark p-2 m-2 fs-2">Minhas Solicitações</a>
    <form class="d-flex" role="search">
      <button class="btn btn-outline-success p-2 m-4 text-success" type="submit"> + Novas Solicitações</button>
    </form>
  </div>
</nav>

<div class="container">

    <table class="table p-5 border shadow m-3 rounded">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Foto</th>
      <th scope="col">Local</th>
      <th scope="col">Descrição</th>
      <th scope="col">Data</th>
      <th scope="col">Status</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">#1</th>
      <td></td>
      <td>Bloco ADM - Recepção</td>
      <td>Vazamento de água na lampada</td>
      <td>04/02/2026</td>
      <td>
        <span class="bg-secondary rounded text-light p-1">FECHADO</span>
     </td>
    </tr>
  </tbody>
</table>
</div>
</main>
</body>
</html>