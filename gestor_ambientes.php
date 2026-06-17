<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Gestão de Ambientes</title>
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

        /* Sidebar */
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
            transition: 0.3s;
        }

        .nav-link.active, .nav-link:hover {
            background: var(--bg-light);
            color: var(--primary-purple);
        }

        /* Card de Tabela */
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

        /* Estilização da Tabela */
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
            border-bottom: 1px solid #f4f7fe;
        }

        .id-badge {
            background: #f4f7fe;
            color: var(--primary-purple);
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .bloco-badge {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-purple);
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Botões de Ação */
        .action-btn {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: 0.3s;
            border: none;
            text-decoration: none;
        }

        .btn-edit { background: rgba(255, 159, 67, 0.1); color: var(--warning-orange); }
        .btn-edit:hover { background: var(--warning-orange); color: white; }

        .btn-delete { background: rgba(234, 84, 85, 0.1); color: var(--danger-red); }
        .btn-delete:hover { background: var(--danger-red); color: white; }
    </style>
</head>
<body>

<aside class="sidebar">
    <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>SGM Gestão</h4>
    <div class="nav flex-column flex-grow-1">
        <a href="dashboard.php" class="nav-link"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="gestor_chamados.php" class="nav-link"><i class="bi bi-ticket-perforated"></i> Chamados</a>
        <a href="gestor_blocos.php" class="nav-link"><i class="bi bi-building"></i> Blocos</a>
        <a href="gestor_ambientes.php" class="nav-link active"><i class="bi bi-geo-alt"></i> Ambientes</a>
        <a href="gestor_servicos.php" class="nav-link"><i class="bi bi-cpu"></i> Serviços</a>
        <hr class="text-secondary my-3 opacity-25">
        <small class="text-muted fw-bold mb-2 px-3" style="font-size: 0.7rem; letter-spacing: 1px;">GESTÃO DE PESSOAS</small>

        <a href="add_usuario.php" class="nav-link "><i class="bi bi-person-plus"></i> Add Usuário</a>
        <a href="add_tecnico.php" class="nav-link"><i class="bi bi-person-gear"></i> Add Técnico</a>
    </div>
    <a href="logout.php" class="nav-link text-danger mt-4"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <span class="text-muted small fw-bold">CONFIGURAÇÕES / ESPAÇOS</span>
            <h2 class="fw-bold m-0 text-dark">Gestão de Ambientes</h2>
        </div>
        <a href="gestor_adicionar_ambientes.php" class="btn btn-add shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Adicionar Ambiente
        </a>
    </div>

    <div class="card-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>BLOCO</th>
                        <th>NOME DO AMBIENTE</th>
                        <th class="text-center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="tabelaAmbientes">
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    async function carregarAmbientes() {
        try {
            const res = await fetch('api/ambiente.php');
            const result = await res.json();
            const tbody = document.getElementById('tabelaAmbientes');

            if (result.success && result.data) {
                tbody.innerHTML = result.data.map(a => `
                    <tr>
                        <td class="ps-4"><span class="id-badge">#${a.id_ambiente}</span></td>
                        <td><span class="bloco-badge">${a.nome_bloco || 'Sem Bloco'}</span></td>
                        <td><span class="fw-bold text-dark">${a.nome}</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="./gestor_atualizar_ambientes.php?id=${a.id_ambiente}" class="action-btn btn-edit" title="Gerenciar">
                                    <i class="bi bi-gear-fill"></i>
                                </a>
                                <button class="action-btn btn-delete" onclick="deletarAmbiente(${a.id_ambiente})" title="Excluir">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center py-5 text-muted">Nenhum ambiente encontrado.</td></tr>';
            }
        } catch (error) {
            console.error("Erro ao carregar:", error);
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-5 text-danger">Erro técnico na conexão.</td></tr>';
        }
    }

    async function deletarAmbiente(id) {
        if (!confirm('Tem certeza que deseja deletar este ambiente? Esta ação é irreversível.')) return;

        try {
            const res = await fetch('api/ambiente.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_ambiente: id })
            });

            const result = await res.json();

            if (result.success) {
                alert('Excluído com sucesso!');
                carregarAmbientes(); 
            } else {
                alert('Erro ao excluir: ' + (result.message || 'Verifique as dependências.'));
            }
        } catch (error) {
            alert('Erro técnico na conexão.');
        }
    }

    window.onload = carregarAmbientes;
</script>
</body>
</html>