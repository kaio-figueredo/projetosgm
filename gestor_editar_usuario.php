<?php
// Configurações de conexão (Mantendo sua lógica PHP)
$host = 'localhost';
$db   = 'sgm_db';
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['id'])) {
        header("Location: gestor_usuarios.php");
        exit;
    }

    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='gestor_usuarios.php';</script>";
        exit;
    }
} catch (PDOException $e) {
    die("Erro técnico: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Intelligence Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    
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
            display: flex;
            justify-content: center;
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

        .nav-link.active { background: var(--bg-light); color: var(--primary-purple); }

        /* Card Intelligence */
        .intelligence-card {
            background: white;
            border-radius: 30px;
            width: 100%;
            max-width: 650px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
            overflow: hidden;
            border: none;
        }

        .header-visual {
            background: linear-gradient(135deg, #2b3674 0%, #6366f1 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }

        .morph-avatar {
            width: 90px; height: 90px;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.4);
            margin: 0 auto 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 6s ease-in-out infinite;
        }

        @keyframes morph {
            0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            50% { border-radius: 50% 50% 30% 70% / 50% 50% 70% 30%; }
        }

        /* Form Estilizado */
        .form-body { padding: 40px; }

        .form-label {
            font-size: 0.7rem; font-weight: 800; color: #A3AED0;
            text-transform: uppercase; letter-spacing: 1px; margin-left: 5px;
        }

        .custom-input {
            background: #F4F7FE;
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 12px 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .custom-input:focus {
            background: white;
            border-color: var(--primary-purple);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .btn-update {
            background: var(--primary-purple);
            border: none; color: white;
            padding: 15px; border-radius: 15px;
            font-weight: 700; width: 100%;
            transition: 0.3s;
        }

        .btn-update:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3); }

        .btn-revoke {
            background: #FFF5F5; color: #E31A1A;
            border: none; padding: 12px; border-radius: 15px;
            font-weight: 700; font-size: 0.85rem; width: 100%;
            margin-top: 15px; transition: 0.2s;
        }

        .btn-revoke:hover { background: #E31A1A; color: white; }
    </style>
</head>
<body>

<aside class="sidebar">
    <h4 class="fw-bold mb-5 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>SGM Gestão</h4>
    
    <div class="nav flex-column flex-grow-1">
        <a href="dashboard.php" class="nav-link "><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="gestor_chamados.php" class="nav-link"><i class="bi bi-ticket-perforated"></i> Chamados</a>
        <a href="gestor_blocos.php" class="nav-link"><i class="bi bi-building"></i> Blocos</a>
        <a href="gestor_ambientes.php" class="nav-link"><i class="bi bi-geo-alt"></i> Ambientes</a>
        <a href="gestor_usuarios.php" class="nav-link active"><i class="bi bi-people"></i> Usuários</a>
        <a href="gestor_servicos.php" class="nav-link"><i class="bi bi-cpu"></i> Serviços</a>
    </div>

    <a href="logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="intelligence-card">
        <div class="header-visual">
            <div class="morph-avatar">
                <i class="bi bi-fingerprint"></i>
            </div>
            <h3 class="fw-bold mb-1"><?php echo htmlspecialchars($usuario['nome']); ?></h3>
            <span class="badge rounded-pill bg-white bg-opacity-25 small">ID: #US-<?php echo $usuario['id_usuario']; ?></span>
        </div>

        <div class="form-body">
            <form action="api/atualizar_usuario.php" method="POST">
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="nome" class="form-control custom-input" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Endereço de E-mail</label>
                        <input type="email" name="email" class="form-control custom-input" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nível de Acesso</label>
                        <select name="perfil" class="form-select custom-input">
                            <option value="Solicitante" <?php echo ($usuario['perfil'] == 'Solicitante') ? 'selected' : ''; ?>>Solicitante</option>
                            <option value="Tecnico" <?php echo ($usuario['perfil'] == 'Tecnico') ? 'selected' : ''; ?>>Técnico</option>
                            <option value="Gestor" <?php echo ($usuario['perfil'] == 'Gestor') ? 'selected' : ''; ?>>Gestor</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status da Conta</label>
                        <select name="ativo" class="form-select custom-input">
                            <option value="1" <?php echo ($usuario['ativo'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                            <option value="0" <?php echo ($usuario['ativo'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-update">
                        <i class="bi bi-shield-check me-2"></i> Salvar Protocolo
                    </button>
                    
                    <button type="button" class="btn btn-revoke" onclick="confirmarExclusao(<?php echo $usuario['id_usuario']; ?>)">
                        <i class="bi bi-trash3 me-2"></i> Excluir Usuário do Sistema
                    </button>
                </div>

                <a href="gestor_usuarios.php" class="d-block text-center mt-4 text-muted text-decoration-none small fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Voltar sem salvar
                </a>
            </form>
        </div>
    </div>
</main>

<script>
function confirmarExclusao(id) {
    if (confirm("⚠️ AÇÃO IRREVERSÍVEL\n\nTodos os dados deste usuário serão apagados. Deseja continuar?")) {
        window.location.href = "api/deletar_usuario.php?id=" + id;
    }
}
</script>

</body>
</html>