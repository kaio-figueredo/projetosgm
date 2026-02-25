<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Gestão Administrativa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-dark: #212529;
            --accent-blue: #0d6efd;
            --accent-yellow: #ffc107;
            --accent-red: #dc3545;
            --bg-body: #f8f9fa;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        /* Topo Premium conforme as imagens anteriores */
        .navbar { 
            background: linear-gradient(135deg, #212529 0%, #343a40 100%) !important; 
            border-bottom: 3px solid var(--accent-blue);
            padding: 12px 0;
        }

        /* Seção de Título */
        .page-header {
            padding: 40px 0 20px 0;
        }

        .page-title {
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.5px;
        }

        /* --- NOVOS CARDS DE ESTATÍSTICA --- */
        .stat-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        /* Linha de acento lateral para cor sutil */
        .stat-accent {
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            border-radius: 0 4px 4px 0;
        }

        .accent-blue { background-color: var(--accent-blue); }
        .accent-yellow { background-color: var(--accent-yellow); }
        .accent-red { background-color: var(--accent-red); }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        /* Cores suaves para os ícones */
        .bg-light-blue { background: rgba(13, 110, 253, 0.1); color: var(--accent-blue); }
        .bg-light-yellow { background: rgba(255, 193, 7, 0.1); color: var(--accent-yellow); }
        .bg-light-red { background: rgba(220, 53, 69, 0.1); color: var(--accent-red); }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 8px;
            color: var(--primary-dark);
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* --- BOTÕES DE AÇÃO --- */
        .action-area {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 30px;
            margin-top: 20px;
        }

        .btn-action {
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary-custom {
            background-color: var(--primary-dark);
            color: white;
            border: none;
        }

        .btn-primary-custom:hover {
            background-color: #000;
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid var(--accent-blue);
            color: var(--accent-blue);
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: var(--accent-blue);
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
                <i class="bi bi-shield-check me-2 text-primary"></i> SGM | Gestão Administrativa
            </a>
            <div class="d-flex align-items-center">
                <span class="text-light me-3 small opacity-75">Olá, Admin Gestor</span>
                <a href="logout.php" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </a>
            </div>
        </div>
    </nav>

    <main class="container">
        <header class="page-header text-center">
            <h2 class="page-title">Visão Geral do Sistema</h2>
            <p class="text-muted">Acompanhe o status das manutenções em tempo real.</p>
        </header>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-accent accent-blue"></div>
                    <div class="stat-icon bg-light-blue">
                        <i class="bi bi-envelope-plus"></i>
                    </div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Novas Solicitações</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-accent accent-yellow"></div>
                    <div class="stat-icon bg-light-yellow">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Em Atendimento</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-accent accent-red"></div>
                    <div class="stat-icon bg-light-red">
                        <i class="bi bi-exclamation-octagon"></i>
                    </div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Críticos / Urgentes</div>
                </div>
            </div>
        </div>

        <div class="action-area text-center shadow-sm">
            
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="gestor_chamados.php" class="btn btn-action btn-primary-custom">
                    <i class="bi bi-list-task"></i> Gerenciar Chamados
                </a>
                <a href="configurar_ambientes.php" class="btn btn-action btn-outline-custom">
                    <i class="bi bi-gear"></i> Configurar Ambientes
                </a>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>