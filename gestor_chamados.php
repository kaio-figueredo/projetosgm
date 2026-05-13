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
    <title>SGM | Gestão de Chamados</title>
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
        }

        /* Sidebar (Mantendo o padrão do Dashboard) */
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
            transition: 0.3s;
        }

        .nav-link.active, .nav-link:hover {
            background: var(--bg-light);
            color: var(--primary-purple);
        }

        /* Tabela e Filtros Estilo SaaS */
        .card-table {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            overflow: hidden;
            padding: 20px;
        }

        .filter-pill {
            border: none;
            background: #f4f7fe;
            color: #A3AED0;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .filter-pill.active, .filter-pill:hover {
            background: var(--primary-purple);
            color: white;
        }

        .table thead th {
            background: transparent;
            color: #A3AED0;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            font-weight: 800;
            border-bottom: 1px solid #f4f7fe;
            padding: 15px;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f4f7fe;
        }

        /* Status Badges */
        .status-pill {
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-aberto { background: #E2E8F0; color: #475569; }
        .status-execucao { background: #FFF3E0; color: #FF9800; }
        .status-concluido { background: #E8F5E9; color: #2E7D32; }

        .btn-manage {
            background: #F4F7FE;
            color: var(--primary-purple);
            border: none;
            font-weight: 700;
            border-radius: 12px;
            padding: 8px 16px;
            transition: 0.3s;
        }

        .btn-manage:hover {
            background: var(--primary-purple);
            color: white;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <h4 class="fw-bold mb-5 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>SGM Gestão</h4>
    
    <div class="nav flex-column flex-grow-1">
        <a href="dashboard.php" class="nav-link"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="gestor_chamados.php" class="nav-link active"><i class="bi bi-ticket-perforated"></i> Chamados</a>
        <a href="gestor_blocos.php" class="nav-link"><i class="bi bi-building"></i> Blocos</a>
        <a href="gestor_ambientes.php" class="nav-link"><i class="bi bi-geo-alt"></i> Ambientes</a>
        <a href="gestor_usuarios.php" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
        <a href="gestor_servicos.php" class="nav-link"><i class="bi bi-cpu"></i> Serviços</a>
    </div>

    <a href="logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <span class="text-muted small fw-bold">SGM / CHAMADOS</span>
            <h2 class="fw-bold m-0">Lista de Solicitações</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <p class="m-0 fw-bold small"><?= $nomeUsuario ?></p>
                <p class="m-0 text-muted" style="font-size: 11px;">Acesso Gestor</p>
            </div>
            <img src="https://ui-avatars.com/api/?name=<?= $nomeUsuario ?>&background=6366f1&color=fff" class="rounded-circle" width="40">
        </div>
    </div>

    <div class="d-flex gap-2 mb-4">
        <button class="filter-pill active" onclick="carregarChamados('')">Todos</button>
        <button class="filter-pill" onclick="carregarChamados('aberto')">Abertos</button>
        <button class="filter-pill" onclick="carregarChamados('em_execucao')">Em Execução</button>
        <button class="filter-pill" onclick="carregarChamados('concluido')">Concluídos</button>
    </div>

    <div class="card-table shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Solicitante</th>
                        <th>Localização</th>
                        <th>Prioridade</th>
                        <th>Técnico</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ação</th>
                    </tr>
                </thead>
                <tbody id="tabelaGeral">
                    </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    const badgesStatus = { 
        'aberto': 'status-aberto', 
        'em_execucao': 'status-execucao', 
        'concluido': 'status-concluido', 
        'fechado': 'status-aberto' 
    };

    const coresPrioridade = { 
        'urgente': '#ef4444', 
        'alta': '#f59e0b', 
        'media': '#6366f1', 
        'baixa': '#A3AED0' 
    };

    async function carregarChamados(status = '') {
        const tbody = document.getElementById('tabelaGeral');
        // Adiciona efeito visual de seleção nos filtros
        document.querySelectorAll('.filter-pill').forEach(btn => {
            btn.classList.remove('active');
            if(btn.innerText.toLowerCase().includes(status.replace('_', ' ')) || (status === '' && btn.innerText === 'Todos')) {
                btn.classList.add('active');
            }
        });

        try {
            const res = await fetch(`api/gestor_chamados.php?status=${status}`);
            const chamados = await res.json();

            if (chamados.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5 text-muted">Nenhum chamado encontrado.</td></tr>';
                return;
            }

            tbody.innerHTML = chamados.map(c => `
                <tr>
                    <td class="ps-4 fw-bold text-muted" style="font-size: 0.85rem;">#${c.id_chamado}</td>
                    <td>
                        <div class="fw-bold">${c.solicitante_nome}</div>
                        <div class="text-muted small" style="font-size: 11px;">${c.data_abertura || 'Recente'}</div>
                    </td>
                    <td>
                        <div class="fw-semibold">${c.ambiente_nome}</div>
                        <div class="small text-muted">${c.bloco_nome}</div>
                    </td>
                    <td>
                        <span class="d-flex align-items-center gap-2 fw-bold" style="font-size: 0.8rem; color: ${coresPrioridade[c.prioridade] || '#A3AED0'}">
                            <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                            ${(c.prioridade || 'baixa').toUpperCase()}
                        </span>
                    </td>
                    <td class="small fw-medium">
                        ${c.tecnico_nome ? `<span><i class="bi bi-person-check me-1"></i>${c.tecnico_nome}</span>` : '<span class="text-muted">-</span>'}
                    </td>
                    <td>
                        <span class="status-pill ${badgesStatus[c.status] || 'status-aberto'}">
                            ${(c.status || 'aberto').replace('_', ' ')}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="gestor_detalhes.php?id=${c.id_chamado}" class="btn-manage">
                            Gerenciar
                        </a>
                    </td>
                </tr>
            `).join('');

        } catch (error) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5 text-danger">Erro ao carregar dados.</td></tr>';
        }
    }

    function confirmarSair() {
        if (confirm("Deseja realmente sair?")) window.location.href = "api/logout.php";
    }

    window.onload = () => carregarChamados('');
</script>

</body>
</html>