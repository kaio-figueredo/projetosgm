<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Registrar Serviço</title>
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

        /* Sidebar Pro */
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
            justify-content: center;
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

        /* Card de Registro */
        .registration-card {
            background: white;
            border-radius: 30px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
            overflow: hidden;
            border: none;
            height: fit-content;
        }

        .card-header-visual {
            background: linear-gradient(135deg, #2b3674 0%, #6366f1 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }

        .icon-badge {
            width: 65px; height: 65px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 15px; font-size: 1.8rem;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        /* Form Design */
        .form-padding { padding: 40px; }

        .form-label {
            font-size: 0.7rem; font-weight: 800; color: #A3AED0;
            text-transform: uppercase; letter-spacing: 1.2px; margin-left: 5px;
        }

        .custom-input {
            background: #F4F7FE;
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 14px 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            background: white;
            border-color: var(--primary-purple);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.08);
            outline: none;
        }

        .btn-submit-pro {
            background: var(--primary-purple);
            color: white; border: none;
            padding: 16px; border-radius: 15px;
            font-weight: 700; width: 100%;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-submit-pro:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-cancel-link {
            display: block; text-align: center; margin-top: 20px;
            color: #A3AED0; text-decoration: none; font-weight: 700; font-size: 0.85rem;
        }
        .btn-cancel-link:hover { color: #eb5757; }
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
    <div class="registration-card">
        <div class="card-header-visual">
            <div class="icon-badge">
                <i class="bi bi-tools"></i>
            </div>
            <h3 class="fw-bold m-0">Novo Tipo de Serviço</h3>
            <p class="small opacity-75 m-0">Configuração de categoria para chamados</p>
        </div>

        <div class="form-padding">
            <form id="formServico">
                <div class="mb-2">
                    <label class="form-label">Nome da Categoria</label>
                    <input type="text" name="nome" id="nome" class="form-control custom-input" required placeholder="Ex: Infraestrutura de TI">
                </div>

                <div class="mb-2">
                    <label class="form-label">Descrição da Atuação</label>
                    <textarea name="descricao" id="descricao" class="form-control custom-input" rows="4" required placeholder="Descreva quais problemas este serviço abrange..."></textarea>
                </div>

                <button type="submit" class="btn btn-submit-pro">
                    <i class="bi bi-cloud-check-fill me-2"></i> Finalizar Registro
                </button>
                
                <a href="./gestor_servicos.php" class="btn-cancel-link">
                    <i class="bi bi-arrow-left me-1"></i> Voltar para a lista
                </a>
            </form>
        </div>
    </div>
</main>

<script>
    document.getElementById('formServico').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);

        fetch('api/salvar_servico.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Feedback visual antes de redirecionar
                alert('✨ Sucesso! O novo tipo de serviço foi mapeado.');
                window.location.href = 'gestor_servicos.php';
            } else {
                alert('⚠️ Ops! Algo deu errado: ' + (data.error || 'Erro desconhecido'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('❌ Erro crítico de conexão com a API.');
        });
    });
</script>

</body>
</html>