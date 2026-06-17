<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Novo Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            flex-direction: column;
            align-items: center;
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

        /* Card do Formulário */
        .registration-card {
            background: white;
            border-radius: 30px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
            width: 100%;
            max-width: 550px;
            overflow: hidden;
        }

        .card-header-visual {
            background: linear-gradient(135deg, #4318FF 0%, #6366f1 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }

        .icon-box {
            width: 60px; height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 15px; font-size: 1.5rem;
            backdrop-filter: blur(5px);
        }

        .form-padding { padding: 40px; }

        .form-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #A3AED0;
            font-weight: 800;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .custom-input {
            border-radius: 15px;
            border: 2px solid transparent;
            background: #F4F7FE;
            padding: 12px 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .custom-input:focus {
            background: white;
            border-color: var(--primary-purple);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.05);
            outline: none;
        }

        .btn-submit {
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 16px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #A3AED0;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
        }
        
        .btn-cancel:hover { color: #eb5757; }
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

        <a href="add_usuario.php" class="nav-link active"><i class="bi bi-person-plus"></i> Add Usuário</a>
        <a href="add_tecnico.php" class="nav-link"><i class="bi bi-person-gear"></i> Add Técnico</a>
    </div>
    <a href="logout.php" class="nav-link text-danger mt-4"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="registration-card">
        <div class="card-header-visual">
            <div class="icon-box">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h3 class="fw-bold m-0">Novo Usuário</h3>
            <p class="small opacity-75 m-0">Provisionamento de credenciais</p>
        </div>

        <div class="form-padding">
            <form action="api/salvar_usuario.php" method="POST">
                <div class="mb-1">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" name="nome" class="form-control custom-input" placeholder="Ex: Richard Feynman" required>
                </div>

                <div class="mb-1">
                    <label class="form-label">Endereço de E-mail</label>
                    <input type="email" name="email" class="form-control custom-input" placeholder="nome@empresa.com" required>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Perfil de Acesso</label>
                        <select name="perfil" class="form-select custom-input">
                            <option value="Solicitante">Solicitante</option>
                            <option value="Tecnico">Técnico</option>
                            <option value="Gestor">Gestor</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha Temporária</label>
                    <input type="password" name="senha" class="form-control custom-input" placeholder="••••••••" required>
                    <div class="text-muted" style="font-size: 0.7rem; margin-top: -15px; margin-left: 5px;">
                        <i class="bi bi-info-circle me-1"></i> O usuário poderá alterar após o primeiro acesso.
                    </div>
                </div>

                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-person-check-fill me-2"></i> Criar Conta Master
                </button>
                
                <a href="gestor_usuarios.php" class="btn-cancel">
                    <i class="bi bi-x-circle me-1"></i> Cancelar Operação
                </a>
            </form>
        </div>
    </div>
</main>

</body>
</html>