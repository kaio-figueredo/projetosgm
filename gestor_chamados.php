<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    header("Location: login.php");
    exit;
}
$nomeUsuario = $_SESSION['user_nome'] ?? 'Admin Gestor';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Gestão de Chamados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #212529 0%, #343a40 100%);
            --accent-color: #0d6efd;
        }

        body { background-color: #f8f9fa; font-family: 'Segoe UI', system-ui, sans-serif; }
        
        /* Navbar Padrão do Sistema */
        .navbar { 
            background: var(--primary-gradient) !important; 
            border-bottom: 3px solid var(--accent-color);
        }

        /* Filtros Modernos */
        .filter-container {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .btn-filter {
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.3s;
        }

        /* Tabela Administrativa */
        .main-card { border: none; border-radius: 15px; overflow: hidden; }
        .table thead th { 
            background-color: #f1f4f9; 
            color: #495057; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 1px;
            padding: 15px;
            border: none;
        }

        .status-badge { padding: 6px 12px; border-radius: 30px; font-size: 0.7rem; font-weight: 700; }
        
        .priority-indicator { font-size: 0.8rem; font-weight: 600; }

        .btn-gerenciar {
            border-radius: 8px;
            font-weight: 600;
            padding: 6px 15px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="gestor_dashboard.php">
                <i class="bi bi-shield-check me-2 text-primary"></i>
                <span class="fw-bold">SGM Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-content="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active fw-bold" href="gestor_chamados.php">Chamados</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestor_locais.php">Locais</a></li>
                    <li class="nav-item ms-lg-3">
                        <button onclick="confirmarSair()" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-box-arrow-right me-1"></i> Sair
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0 text-dark">Todos os Chamados</h2>
            <span class="badge bg-white text-dark shadow-sm border py-2 px-3 rounded-pill text-muted">
                Gestão Administrativa de Manutenção
            </span>
        </div>

        <div class="filter-container d-flex flex-wrap gap-2">
            <button class="btn btn-filter btn-outline-secondary" onclick="carregarChamados('')">
                <i class="bi bi-grid-fill me-1"></i> Todos
            </button>
            <button class="btn btn-filter btn-outline-primary" onclick="carregarChamados('aberto')">
                <i class="bi bi-plus-circle me-1"></i> Abertos
            </button>
            <button class="btn btn-filter btn-outline-warning text-dark" onclick="carregarChamados('em_execucao')">
                <i class="bi bi-play-circle me-1"></i> Em Execução
            </button>
            <button class="btn btn-filter btn-outline-success" onclick="carregarChamados('concluido')">
                <i class="bi bi-check-circle me-1"></i> Concluídos
            </button>
        </div>

        <div class="card main-card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Solicitante</th>
                            <th>Local / Tipo</th>
                            <th>Prioridade</th>
                            <th>Técnico Responsável</th>
                            <th>Status Atual</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaGeral">
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 text-muted mb-0">Buscando chamados no servidor...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const coresPrioridade = { 
            'urgente': 'text-danger', 
            'alta': 'text-warning', 
            'media': 'text-primary', 
            'baixa': 'text-secondary' 
        };
        
        const badgesStatus = { 
            'aberto': 'bg-secondary-subtle text-secondary border border-secondary', 
            'em_execucao': 'bg-warning-subtle text-warning-emphasis border border-warning', 
            'concluido': 'bg-success-subtle text-success border border-success', 
            'fechado': 'bg-dark-subtle text-dark border border-dark' 
        };

        function confirmarSair() {
            const nome = "<?= $nomeUsuario ?>";
            if (confirm(`Olá ${nome}, você realmente deseja encerrar sua sessão de gestor?`)) {
                window.location.href = "api/logout.php";
            }
        }

        async function carregarChamados(status = '') {
            const tbody = document.getElementById('tabelaGeral');
            try {
                const url = `api/gestor_chamados.php?status=${status}`;
                const res = await fetch(url);
                if (!res.ok) throw new Error("Erro na API");
                const chamados = await res.json();

                if (chamados.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5 text-muted">Nenhum chamado registrado nesta categoria.</td></tr>';
                    return;
                }

                tbody.innerHTML = chamados.map(c => {
                    const statusClass = badgesStatus[c.status] || 'bg-light text-dark';
                    const prioridadeClass = coresPrioridade[c.prioridade] || 'text-muted';
                    
                    return `
                    <tr>
                        <td class="ps-4 fw-bold text-muted small">#${c.id_chamado}</td>
                        <td>
                            <div class="fw-semibold text-dark">${c.solicitante_nome || 'N/A'}</div>
                        </td>
                        <td>
                            <small class="text-muted d-block">${c.bloco_nome || ''}</small>
                            <span class="fw-medium">${c.ambiente_nome || 'Não definido'}</span>
                        </td>
                        <td class="priority-indicator">
                            <i class="bi bi-circle-fill ${prioridadeClass} me-2 small"></i> 
                            ${(c.prioridade || 'baixa').toUpperCase()}
                        </td>
                        <td>
                            ${c.tecnico_nome ? `<span class="text-dark"><i class="bi bi-person me-1"></i>${c.tecnico_nome}</span>` : 
                            '<span class="text-muted italic small"><i class="bi bi-person-dash me-1"></i>Aguardando técnico</span>'}
                        </td>
                        <td>
                            <span class="status-badge ${statusClass}">
                                ${(c.status || 'aberto').replace('_', ' ').toUpperCase()}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="gestor_detalhes.php?id=${c.id_chamado}" class="btn btn-sm btn-primary btn-gerenciar shadow-sm">
                                <i class="bi bi-gear me-1"></i> Gerenciar
                            </a>
                        </td>
                    </tr>`;
                }).join('');

            } catch (error) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center py-5 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Erro ao carregar dados.</td></tr>`;
            }
        }

        window.onload = () => carregarChamados('');
    </script>
</body>
</html>