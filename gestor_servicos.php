<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Gestão de Serviços</title>
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

        /* Botões de Ação */
        .btn-manage {
            background: #F4F7FE;
            color: #ffb800;
            border: none;
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.75rem;
            transition: 0.3s;
        }
        .btn-manage:hover { background: #ffb800; color: white; }

        .btn-delete-pro {
            background: #FFF5F5;
            color: #E31A1A;
            border: none;
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.75rem;
            transition: 0.3s;
        }
        .btn-delete-pro:hover { background: #E31A1A; color: white; }

        .service-id {
            background: #f4f7fe;
            padding: 4px 10px;
            border-radius: 8px;
            font-family: monospace;
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
        <a href="gestor_blocos.php" class="nav-link"><i class="bi bi-building"></i> Blocos</a>
        <a href="gestor_ambientes.php" class="nav-link"><i class="bi bi-geo-alt"></i> Ambientes</a>
        <a href="gestor_usuarios.php" class="nav-link"><i class="bi bi-people"></i> Usuários</a>
        <a href="gestor_servicos.php" class="nav-link active"><i class="bi bi-cpu"></i> Serviços</a>
    </div>

    <a href="logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <header class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold m-0 text-dark">Tipos de Serviço</h2>
            <p class="text-muted m-0 small">Defina as categorias de atendimento do sistema</p>
        </div>
        <a href="gestor_adicionar_servicos.php" class="btn btn-primary rounded-4 px-4 py-2 fw-bold shadow-sm" style="background: var(--primary-purple); border: none;">
            <i class="bi bi-plus-lg me-1"></i> Novo Serviço
        </a>
    </header>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width: 10%">ID</th>
                        <th style="width: 25%">Nome do Serviço</th>
                        <th style="width: 35%">Descrição Detalhada</th>
                        <th class="text-center">Configurar</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody id="tabelaServicos">
                    </tbody>
            </table>
        </div>
    </div>
</main>

<script>
async function carregarServicos() {
    try {
        const res = await fetch('api/servico.php');
        const result = await res.json();
        const tbody = document.getElementById('tabelaServicos');
        
        if (result.success) {
            if (result.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted">Nenhum serviço mapeado.</td></tr>';
                return;
            }

            tbody.innerHTML = result.data.map(s => `
                <tr>
                    <td><span class="service-id">#${s.id_tipo}</span></td>
                    <td><span class="fw-bold text-dark">${s.nome}</span></td>
                    <td><span class="text-muted small">${s.descricao || '<em>Sem descrição informada</em>'}</span></td>
                    <td class="text-center">
                        <a href="gestor_atualizar_servicos.php?id=${s.id_tipo}" class="btn-manage">
                            <i class="bi bi-sliders me-1"></i> Ajustar
                        </a>
                    </td>
                    <td class="text-center">
                        <button class="btn-delete-pro" onclick="deletarServico(${s.id_tipo})">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }
    } catch (e) { 
        console.error("Erro na carga:", e); 
    }
}

async function deletarServico(id) {
    if (!confirm('⚠️ ALERTA DE INTEGRIDADE\n\nDeletar este serviço pode afetar o histórico de chamados. Confirmar exclusão?')) return;
    try {
        const res = await fetch('api/servico.php', {
            method: 'DELETE',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id_tipo: id })
        });
        const result = await res.json();
        if (result.success) { 
            carregarServicos(); 
        } else { 
            alert(result.message); 
        }
    } catch (e) { 
        alert("Erro de comunicação com o servidor."); 
    }
}

// Inicializa a carga
carregarServicos();
</script>

</body>
</html>