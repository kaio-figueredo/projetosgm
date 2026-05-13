<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Gestão de Blocos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-purple: #6366f1;
            --bg-light: #f4f7fe;
            --sidebar-width: 260px;
            --text-dark: #2b3674;
            --danger-red: #ea5455;
            --warning-orange: #ff9f43;
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
            transition: 0.3s;
        }

        .nav-link.active, .nav-link:hover {
            background: var(--bg-light);
            color: var(--primary-purple);
        }

        /* Card de Tabela Estilo SaaS */
        .card-table {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            overflow: hidden;
            padding: 20px;
        }

        .btn-add {
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-add:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
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

        .table tbody td, .table tbody th {
            padding: 20px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f4f7fe;
        }

        /* Botões de Ação na Tabela */
        .action-btn {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: 0.3s;
            border: none;
            margin-right: 5px;
        }

        .btn-edit { background: rgba(255, 159, 67, 0.1); color: var(--warning-orange); }
        .btn-edit:hover { background: var(--warning-orange); color: white; }

        .btn-delete { background: rgba(234, 84, 85, 0.1); color: var(--danger-red); }
        .btn-delete:hover { background: var(--danger-red); color: white; }

        .id-badge {
            background: #f4f7fe;
            color: var(--primary-purple);
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <h4 class="fw-bold mb-5 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>SGM Gestão</h4>
    
    <div class="nav flex-column flex-grow-1">
        <a href="dashboard.php" class="nav-link "><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="gestor_chamados.php" class="nav-link"><i class="bi bi-ticket-perforated"></i> Chamados</a>
        <a href="gestor_blocos.php" class="nav-link active"><i class="bi bi-building"></i> Blocos</a>
        <a href="gestor_ambientes.php" class="nav-link"><i class="bi bi-geo-alt"></i> Ambientes</a>
        <a href="gestor_usuarios.php" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
        <a href="gestor_servicos.php" class="nav-link"><i class="bi bi-cpu"></i> Serviços</a>
    </div>

    <a href="logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <span class="text-muted small fw-bold">CONFIGURAÇÕES / INFRAESTRUTURA</span>
            <h2 class="fw-bold m-0 text-dark">Gestão de Blocos</h2>
        </div>
        <a href="gestor_adicionar_blocos.php" class="btn btn-add">
            <i class="bi bi-plus-lg me-2"></i> Adicionar Bloco
        </a>
    </div>

    <div class="card-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>NOME DO BLOCO</th>
                        <th class="text-center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="tabelaBlocos">
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    async function carregarBlocos() {
        try {
            const res = await fetch('api/bloco.php');
            const result = await res.json();
            const tbody = document.getElementById('tabelaBlocos');

            if (result.success && result.data) {
                tbody.innerHTML = result.data.map(bloco => `
                    <tr>
                        <td class="ps-4"><span class="id-badge">#${bloco.id_bloco}</span></td>
                        <td><span class="fw-bold text-dark">${bloco.nome}</span></td>
                        <td class="text-center">
                            <a href="gestor_atualizar_blocos.php?id=${bloco.id_bloco}" class="action-btn btn-edit" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="action-btn btn-delete" onclick="deletarBloco(${bloco.id_bloco})" title="Excluir">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center py-5 text-muted">Nenhum bloco encontrado.</td></tr>';
            }
        } catch (error) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center py-5 text-danger">Erro ao carregar dados.</td></tr>';
        }
    }

    async function deletarBloco(id) {
        if (confirm('Deseja realmente excluir este bloco? Isso afetará os ambientes vinculados.')) {
            try {
                const response = await fetch('api/bloco.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_bloco: id })
                });
                const result = await response.json();
                if (result.success) {
                    carregarBlocos();
                } else {
                    alert('Erro: ' + result.message);
                }
            } catch (error) {
                alert('Erro ao processar exclusão.');
            }
        }
    }

    window.onload = carregarBlocos;
</script>

</body>
</html>