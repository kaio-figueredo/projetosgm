<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Nova Solicitação</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary: #5d87ff; /* Azul da marca conforme imagens */
            --bg-light: #f4f7fe;
            --sidebar-width: 260px;
            --text-main: #2a3547;
            --text-muted: #7c8fac;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            min-height: 100vh;
            color: var(--text-main);
        }

        /* Sidebar - Alinhamento e Estilo */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 2rem 1.2rem;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .brand {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 10px;
        }

        .nav-link {
            color: #5a6a85;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(93, 135, 255, 0.1);
            color: var(--primary);
        }

        /* Área Principal */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2.5rem 4rem;
            display: flex;
            flex-direction: column;
            align-items: center; /* Centraliza o card horizontalmente */
        }

        .content-container {
            width: 100%;
            max-width: 850px;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            width: 100%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 10px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            color: var(--primary);
            font-weight: 700;
        }

        /* Card de Formulário */
        .modern-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f3f9;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }

        .form-control, .form-select {
            border: 1.5px solid #dfe5ef;
            background: #fff;
            padding: 14px 18px;
            border-radius: 12px;
            color: var(--text-main);
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(93, 135, 255, 0.1);
            outline: none;
        }

        /* Área de Upload Estilizada */
        .upload-area {
            border: 2px dashed #cbd5e1;
            background: #f8fafc;
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: rgba(93, 135, 255, 0.02);
        }

        .upload-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 15px;
            color: var(--primary);
            font-size: 1.5rem;
        }

        .btn-submit {
            background: var(--primary);
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            color: white;
            box-shadow: 0 8px 20px rgba(93, 135, 255, 0.25);
            transition: all 0.3s;
            margin-top: 15px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(93, 135, 255, 0.35);
            filter: brightness(1.1);
        }

        .btn-back {
            background: transparent;
            color: var(--text-muted);
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .btn-back:hover {
            background: #f1f5f9;
            color: var(--text-main);
        }

        #file-name {
            display: inline-block;
            margin-top: 10px;
            font-size: 0.85rem;
            padding: 5px 12px;
            background: #eef2ff;
            border-radius: 20px;
            color: var(--primary);
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand">
            <i class="bi bi-shield-lock-fill"></i> SGM SOLICITANTE
        </div>
        <nav>
            <a href="solicitante_dashboard.php" class="nav-link">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="#" class="nav-link active">
                <i class="bi bi-plus-circle-fill"></i> Nova Solicitação
            </a>
        </nav>
        
        <div class="mt-auto">
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-power"></i> Sair do Sistema
            </a>
        </div>
    </aside>

    <main class="main-content">
        <div class="content-container">
            <header class="top-header">
                <div>
                    <h2 class="fw-bold mb-1">Nova Solicitação 👋</h2>
                    <p class="text-muted mb-0">Informe os detalhes para a equipe de manutenção.</p>
                </div>
                <div class="user-profile">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span>Maria Solicitante</span>
                </div>
            </header>

            <div class="modern-card">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h5 class="fw-bold m-0" style="color: #4a5568;">Informações do Chamado</h5>
                    <a href="solicitante_dashboard.php" class="btn-back">
                        <i class="bi bi-chevron-left me-1"></i> Voltar
                    </a>
                </div>

                <form id="formChamado">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Bloco / Setor</label>
                            <select class="form-select" id="selectBloco" required>
                                <option value="">Selecione o bloco</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ambiente / Sala</label>
                            <select class="form-select" id="selectAmbiente" required>
                                <option value="">Selecione o local</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Categoria do Reparo</label>
                            <select class="form-select" id="selectTipo" required>
                                <option value="">Selecione o tipo de problema...</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Descrição Detalhada</label>
                            <textarea class="form-control" id="descricao" rows="4" 
                                placeholder="Explique brevemente o que aconteceu para agilizar o suporte..." required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Evidência Visual (Foto)</label>
                            <div class="upload-area" onclick="document.getElementById('foto').click()">
                                <div class="upload-icon">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Anexar uma foto do problema</h6>
                                <p class="text-muted small mb-0">Tamanho máximo: 5MB (PNG, JPG)</p>
                                <input type="file" id="foto" class="d-none" accept="image/*">
                                <div id="file-name" class="d-none"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn w-100 btn-submit">
                                <i class="bi bi-send-fill me-2"></i> Enviar Solicitação
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('foto').onchange = function() {
            const fileNameDiv = document.getElementById('file-name');
            if(this.files.length > 0) {
                fileNameDiv.classList.remove('d-none');
                fileNameDiv.innerHTML = '<i class="bi bi-image me-1"></i> ' + this.files[0].name;
            } else {
                fileNameDiv.classList.add('d-none');
            }
        };
    </script>

    <script src="./assets/js/solicitante_abrir_chamado.js"></script>
</body>
</html>