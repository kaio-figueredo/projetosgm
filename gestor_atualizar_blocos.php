<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Atualizar Bloco</title>
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
        .form-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            padding: 40px;
            width: 100%;
            max-width: 600px;
        }

        .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #A3AED0;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #E0E5F2;
            padding: 12px 15px;
            font-weight: 500;
            color: var(--text-dark);
            background-color: #fff;
        }

        .form-control:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .id-badge {
            background: #f4f7fe;
            color: var(--primary-purple);
            padding: 5px 15px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .btn-save {
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-save:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .btn-back {
            color: #A3AED0;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px;
            transition: 0.2s;
        }

        .btn-back:hover { color: var(--primary-purple); }
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
    <div class="w-100 max-width-600">
        <a href="gestor_blocos.php" class="btn-back">
            <i class="bi bi-arrow-left"></i> Voltar para lista
        </a>
        
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="fw-bold m-0">Editar Bloco</h3>
                    <p class="text-muted small">Atualize as informações de infraestrutura</p>
                </div>
                <span class="id-badge">ID: <span id="displayId">--</span></span>
            </div>

            <form id="formAtualizarBloco">
                <div class="mb-3">
                    <label class="form-label">Nome do Bloco</label>
                    <input type="text" id="nome_bloco" class="form-control" placeholder="Ex: Bloco A - Administrativo" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Descrição Detalhada</label>
                    <textarea id="descricao_bloco" class="form-control" rows="4" placeholder="Descreva a finalidade deste bloco..." required></textarea>
                </div>

                <button type="submit" class="btn btn-save w-100">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Salvar Alterações
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const idBusca = urlParams.get('id');

    if (!idBusca) {
        window.location.href = './gestor_blocos.php';
    }

    document.getElementById('displayId').innerText = idBusca;

    async function carregarDados() {
        try {
            const response = await fetch('./api/bloco.php');
            const result = await response.json();

            if (result.success && Array.isArray(result.data)) {
                const bloco = result.data.find(b => b.id_bloco == idBusca);
                if (bloco) {
                    document.getElementById('nome_bloco').value = bloco.nome;
                    document.getElementById('descricao_bloco').value = bloco.descricao;
                } else {
                    alert('Bloco não encontrado!');
                    window.location.href = './gestor_blocos.php';
                }
            }
        } catch (error) {
            console.error('Erro ao carregar:', error);
        }
    }

    document.getElementById('formAtualizarBloco').addEventListener('submit', async (e) => {
        e.preventDefault();

        const dados = {
            id_bloco: idBusca,
            nome: document.getElementById('nome_bloco').value,
            descricao: document.getElementById('descricao_bloco').value
        };

        try {
            const response = await fetch('./api/bloco.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (result.success) {
                // Feedback visual antes de redirecionar (opcional)
                alert('Bloco atualizado com sucesso!');
                window.location.href = './gestor_blocos.php';
            } else {
                alert('Erro ao atualizar: ' + result.message);
            }
        } catch (error) {
            alert('Erro na conexão com o servidor.');
        }
    });

    carregarDados();
</script>

</body>
</html>