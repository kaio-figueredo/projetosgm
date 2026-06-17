<?php
// Configurações de conexão
$host = 'localhost';
$db   = 'sgm_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id_usuario, nome, email, perfil, ativo FROM usuarios";
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao conectar com o banco: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Gestão de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-purple: #6366f1;
            --bg-light: #f4f7fe;
            --sidebar-width: 260px;
            --text-dark: #2b3674;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Sidebar Consistente */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            height: 100vh;
            position: fixed;
            border-right: 1px solid #e9ecef;
            padding: 25px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            padding: 40px;
        }

        .nav-link {
            color: #A3AED0;
            font-weight: 600;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-link.active, .nav-link:hover {
            background: var(--bg-light);
            color: var(--primary-purple);
        }

        /* Tabela Pro */
        .table-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: none;
        }

        .table thead th {
            background: transparent;
            color: #A3AED0;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            border-bottom: 1px solid #F4F7FE;
            padding: 15px;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #F4F7FE;
            color: var(--text-dark);
            font-weight: 500;
        }

        /* Avatares e Badges */
        .user-avatar { 
            width: 40px; height: 40px; 
            background: #E0E5F2; color: var(--primary-purple); 
            border-radius: 12px; display: flex; align-items: center; justify-content: center; 
            font-weight: 700; font-size: 0.85rem;
        }

        .badge-role {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .role-solicitante { background: #E1E9FF; color: #4318FF; }
        .role-tecnico { background: #FFF3E0; color: #FFB547; }
        .role-gestor { background: #E2F9EF; color: #05CD99; }

        .status-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .btn-action {
            background: #F4F7FE;
            border: none;
            color: var(--primary-purple);
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.8rem;
            transition: 0.3s;
        }
        .btn-action:hover {
            background: var(--primary-purple);
            color: white;
        }
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
        <a href="add_tecnico.php" class="nav-link"><i class="bi bi-person-gear"></i> Add Técnico</a>
    </div>
    <a href="logout.php" class="nav-link text-danger mt-4"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <header class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold m-0">Gestão de Usuários</h2>
            <p class="text-muted m-0 small">Controle de acessos e permissões do sistema</p>
        </div>
        <a href="gestor_adicionar_usuario.php" class="btn btn-primary rounded-4 px-4 py-2 fw-bold shadow-sm" style="background: var(--primary-purple); border: none;">
            <i class="bi bi-person-plus-fill me-2"></i> Novo Usuário
        </a>
    </header>

    <div class="table-card">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($usuarios) > 0): ?>
                    <?php foreach ($usuarios as $user): 
                        $iniciais = strtoupper(substr($user['nome'], 0, 2));
                        $perfilClass = 'role-' . strtolower($user['perfil']);
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar"><?php echo $iniciais; ?></div>
                                <div>
                                    <div class="fw-bold"><?php echo htmlspecialchars($user['nome']); ?></div>
                                    <div class="text-muted small" style="font-size: 0.7rem;">ID #<?php echo $user['id_usuario']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-muted small"><?php echo htmlspecialchars($user['email']); ?></span></td>
                        <td>
                            <span class="badge-role <?php echo $perfilClass; ?>">
                                <?php echo $user['perfil']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['ativo'] == 1): ?>
                                <span class="text-success small fw-bold d-flex align-items-center">
                                    <span class="status-dot bg-success"></span> Ativo
                                </span>
                            <?php else: ?>
                                <span class="text-danger small fw-bold d-flex align-items-center">
                                    <span class="status-dot bg-danger"></span> Inativo
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="gestor_editar_usuario.php?id=<?php echo $user['id_usuario']; ?>" class="btn-action">
                                <i class="bi bi-sliders me-1"></i> Ajustes
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people mb-2 d-block fs-2"></i>
                            Nenhum usuário cadastrado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>