<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Atualizar Ambiente</title>
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

        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #E0E5F2;
            padding: 12px 15px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-submit {
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .btn-cancel {
            color: #A3AED0;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px;
            transition: 0.2s;
        }

        .btn-cancel:hover { color: #ea5455; }

        .id-indicator {
            background: #f4f7fe;
            color: var(--primary-purple);
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            margin-left: 10px;
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

        <a href="add_usuario.php" class="nav-link active"><i class="bi bi-person-plus"></i> Add Usuário</a>
        <a href="add_tecnico.php" class="nav-link"><i class="bi bi-person-gear"></i> Add Técnico</a>
    </div>
    <a href="logout.php" class="nav-link text-danger mt-4"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="w-100" style="max-width: 600px;">
        <a href="gestor_ambientes.php" class="btn-cancel">
            <i class="bi bi-arrow-left"></i> Cancelar e voltar
        </a>
        
        <div class="form-card">
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="fw-bold m-0 text-dark">Editar Ambiente</h3>
                    <p class="text-muted small m-0">Atualize as informações do espaço</p>
                </div>
                <span id="labelID" class="id-indicator">ID: --</span>
            </div>

            <form id="formAtualizarAmbiente">
                <div class="mb-3">
                    <label class="form-label">Bloco / Setor</label>
                    <select id="selectBloco" class="form-select" required>
                        <option value="">Carregando blocos...</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Nome do Ambiente</label>
                    <input type="text" id="nomeAmbiente" class="form-control" required placeholder="Digite o nome do ambiente">
                </div>

                <button type="submit" class="btn btn-submit w-100">
                    <i class="bi bi-save2-fill me-2"></i> Salvar Alterações
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const idAmbiente = urlParams.get('id');

    document.addEventListener('DOMContentLoaded', async () => {
        if (!idAmbiente) {
            alert("ID do ambiente não encontrado!");
            window.location.href = './gestor_ambientes.php';
            return;
        }

        document.getElementById('labelID').textContent = `ID: ${idAmbiente}`;

        try {
            // 1. Carregar Blocos
            const resBlocos = await fetch('./api/bloco.php');
            const blocosData = await resBlocos.json();
            const selectBloco = document.getElementById('selectBloco');
            
            selectBloco.innerHTML = '<option value="">Selecione o bloco</option>';
            blocosData.data.forEach(bloco => {
                selectBloco.innerHTML += `<option value="${bloco.id_bloco}">${bloco.nome}</option>`;
            });

            // 2. Buscar dados atuais
            const resAmbientes = await fetch('./api/ambiente.php');
            const ambientesData = await resAmbientes.json();
            const ambienteParaEditar = ambientesData.data.find(a => a.id_ambiente == idAmbiente);

            if (ambienteParaEditar) {
                selectBloco.value = ambienteParaEditar.id_bloco;
                document.getElementById('nomeAmbiente').value = ambienteParaEditar.nome;
            } else {
                alert("Ambiente não encontrado!");
                window.location.href = './gestor_ambientes.php';
            }

        } catch (error) {
            console.error("Erro:", error);
            alert("Erro ao conectar com o servidor.");
        }
    });

    // Enviar Atualização (PUT)
    document.getElementById('formAtualizarAmbiente').addEventListener('submit', async (e) => {
        e.preventDefault();

        const dadosAtualizados = {
            id_ambiente: parseInt(idAmbiente),
            id_bloco: parseInt(document.getElementById('selectBloco').value),
            nome: document.getElementById('nomeAmbiente').value
        };

        try {
            const response = await fetch('./api/ambiente.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dadosAtualizados)
            });

            const result = await response.json();

            if (result.success) {
                alert("Ambiente atualizado com sucesso!");
                window.location.href = './gestor_ambientes.php';
            } else {
                alert("Erro: " + result.message);
            }
        } catch (error) {
            alert("Erro ao enviar dados.");
        }
    });
</script>

</body>
</html>