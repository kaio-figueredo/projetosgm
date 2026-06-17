<?php
// Conexão segura e busca de dados
$conn = new mysqli("localhost", "root", "", "sgm_db");
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? 0;

// Busca os dados usando Prepared Statements
$stmt_busca = $conn->prepare("SELECT * FROM tipos_servico WHERE id_tipo = ?");
$stmt_busca->bind_param("i", $id);
$stmt_busca->execute();
$result = $stmt_busca->get_result();
$servico = $result->fetch_assoc();

if (!$servico) {
    die("Serviço não encontrado!");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Atualizar Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
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
            min-height: 100vh;
            margin: 0;
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

        /* Container Principal */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        /* Layout em Duas Colunas (Estilo Imagem) */
        .split-card {
            background: white;
            border-radius: 30px;
            display: flex;
            width: 100%;
            max-width: 900px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }

        /* Lado Esquerdo - Visual */
        .card-left {
            flex: 1;
            background: #f8faff;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-right: 1px solid #f0f2f5;
        }

        .illustration-box {
            width: 180px;
            margin-bottom: 30px;
        }

        .card-left h2 { color: var(--text-dark); font-weight: 700; margin-bottom: 15px; }
        .card-left p { color: #A3AED0; font-size: 0.95rem; line-height: 1.6; }

        /* Lado Direito - Formulário */
        .card-right {
            flex: 1.2;
            padding: 60px;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }

        .custom-input {
            background: #F4F7FE;
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 15px 20px;
            width: 100%;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 25px;
            transition: 0.3s;
        }

        .custom-input:focus {
            background: white;
            border-color: var(--primary-purple);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.05);
            outline: none;
        }

        .btn-confirm {
            background: var(--primary-purple);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 15px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-confirm:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
            filter: brightness(1.1);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #A3AED0;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
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
    <div class="split-card">
        <div class="card-left">
            <div class="illustration-box">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#6366f1" opacity="0.1" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.6,90,-16.3,88.5,-0.9C86.9,14.5,81.2,29.1,72.6,41.4C64,53.7,52.5,63.7,39.4,71.3C26.3,78.9,13.1,84.1,-0.8,85.5C-14.7,86.9,-29.4,84.4,-42.1,76.5C-54.8,68.6,-65.4,55.3,-73,41.1C-80.5,26.9,-84.9,11.8,-84.1,-2.9C-83.3,-17.7,-77.2,-32.1,-68,-44.1C-58.8,-56.1,-46.5,-65.7,-33.2,-73.4C-19.9,-81.1,-10,-86.9,2.4,-91C14.7,-95.1,29.4,-97.5,44.7,-76.4Z" transform="translate(100 100)" />
                    <rect x="60" y="70" width="80" height="60" rx="10" fill="#6366f1" />
                    <path d="M60 80L100 105L140 80" stroke="white" stroke-width="5" fill="none" stroke-linecap="round"/>
                </svg>
            </div>
            <h2>Atualizar Serviço</h2>
            <p>Edite os detalhes desta categoria para manter o catálogo de chamados atualizado.</p>
        </div>

        <div class="card-right">
            <form id="formAtualizar">
                <input type="hidden" name="id_tipo" value="<?php echo $servico['id_tipo']; ?>">

                <label class="form-label">Nome da Categoria</label>
                <input type="text" name="nome" class="custom-input" placeholder="Ex: Manutenção Elétrica" required value="<?php echo htmlspecialchars($servico['nome']); ?>">

                <label class="form-label">Descrição da Atuação</label>
                <textarea name="descricao" class="custom-input" rows="5" placeholder="Descreva as atividades deste serviço..." required><?php echo htmlspecialchars($servico['descricao']); ?></textarea>

                <button type="submit" class="btn-confirm">
                    Confirmar e Enviar
                </button>

                <a href="gestor_servicos.php" class="back-link">
                    <i class="bi bi-arrow-left me-1"></i> Voltar para a lista
                </a>
            </form>
        </div>
    </div>
</main>

<script>
document.getElementById('formAtualizar').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('api/atualizar_servico.php', {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        const text = await response.text();
        try {
            return JSON.parse(text);
        } catch (err) {
            throw new Error('Erro no servidor: ' + text);
        }
    })
    .then(data => {
        if(data.success) {
            alert('✅ Perfil do serviço atualizado!');
            window.location.href = 'gestor_servicos.php';
        } else {
            alert('❌ Erro: ' + data.error);
        }
    })
    .catch(error => {
        alert('Falha crítica: ' + error.message);
    });
});
</script>

</body>
</html>