<?php
$host = "localhost";
$db   = "sgm_db";
$user = "root";
$pass = "";

$mensagem = "";
$statusMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Verifica se o e-mail já existe
            $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
            $stmtCheck->execute([$email]);
            
            if ($stmtCheck->fetchColumn() > 0) {
                $mensagem = "Este e-mail já está cadastrado!";
                $statusMsg = "danger";
            } else {
                // Criptografa a senha por segurança
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                
                // CORREÇÃO AQUI: Ajustado para usar as colunas corretas (senha_hash, perfil, ativo)
                $sql = "INSERT INTO usuarios (nome, email, senha_hash, perfil, ativo) VALUES (?, ?, ?, 'Tecnico', 1)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $email, $senhaHash]);

                $mensagem = "Técnico cadastrado com sucesso!";
                $statusMsg = "success";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro no banco de dados: " . $e->getMessage();
            $statusMsg = "danger";
        }
    } else {
        $mensagem = "Preencha todos os campos!";
        $statusMsg = "warning";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Adicionar Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-purple: #6366f1; --bg-light: #f4f7fe; --sidebar-width: 260px; }
        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; }
        .sidebar { width: var(--sidebar-width); background: white; height: 100vh; position: fixed; border-right: 1px solid #e9ecef; padding: 25px; display: flex; flex-direction: column; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 40px; }
        .nav-link { color: #A3AED0; font-weight: 500; padding: 12px 15px; border-radius: 12px; margin-bottom: 5px; display: flex; align-items: center; gap: 10px; text-decoration: none;}
        .nav-link.active, .nav-link:hover { background: var(--bg-light); color: var(--primary-purple); }
        .card-form { background: white; border-radius: 20px; border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
        .btn-primary-mod { background: #0d6efd; color: white; border: none; border-radius: 12px; padding: 12px 25px; font-weight: 600; transition: 0.3s; }
        .btn-primary-mod:hover { opacity: 0.9; transform: translateY(-2px); }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #e9ecef; }
        .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
    </style>
</head>
<body>

<aside class="sidebar">
    <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>SGM Gestão</h4>
    <div class="nav flex-column flex-grow-1">
        <a href="dashboard.php" class="nav-link"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="gestor_chamados.php" class="nav-link"><i class="bi bi-ticket-perforated"></i> Chamados</a>
        <a href="gestor_blocos.php" class="nav-link"><i class="bi bi-building"></i> Blocos</a>
        <a href="gestor_ambientes.php" class="nav-link"><i class="bi bi-geo-alt"></i> Ambientes</a>
        <a href="gestor_servicos.php" class="nav-link"><i class="bi bi-cpu"></i> Serviços</a>
        <hr class="text-secondary my-3 opacity-25">
        <small class="text-muted fw-bold mb-2 px-3" style="font-size: 0.7rem; letter-spacing: 1px;">GESTÃO DE PESSOAS</small>
        <a href="add_usuario.php" class="nav-link"><i class="bi bi-person-plus"></i> Add Usuário</a>
        <a href="add_tecnico.php" class="nav-link active"><i class="bi bi-person-gear"></i> Add Técnico</a>
    </div>
    <a href="logout.php" class="nav-link text-danger mt-4"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="mb-5">
        <span class="text-muted small fw-bold">SGM / TÉCNICOS</span>
        <h2 class="fw-bold m-0">Adicionar Novo Técnico</h2>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card card-form p-5">
                
                <?php if(!empty($mensagem)): ?>
                    <div class="alert alert-<?= $statusMsg ?> alert-dismissible fade show border-0 rounded-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> <?= $mensagem ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="add_tecnico.php" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Nome do Técnico</label>
                        <input type="text" name="nome" class="form-control" placeholder="Ex: Carlos Souza" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">E-mail Técnico</label>
                        <input type="email" name="email" class="form-control" placeholder="carlos.suporte@empresa.com" required>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-semibold text-secondary">Senha Provisória</label>
                        <input type="password" name="senha" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-primary-mod w-100"><i class="bi bi-person-gear me-2"></i>Cadastrar Técnico</button>
                </form>

            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>