<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Nova Solicitação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            /* Paleta de cores oficial do seu sistema */
            --primary-dark: #212529;
            --accent-blue: #0d6efd;
            --bg-body: #f0f2f5;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #333;
        }

        /* Navbar com o gradiente dark que usamos nos outros */
        .navbar { 
            background: linear-gradient(135deg, #212529 0%, #343a40 100%) !important; 
            border-bottom: 3px solid var(--accent-blue);
            padding: 12px 0;
        }

        /* Card centralizado simples */
        .request-card {
            background: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 35px;
            margin-top: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        /* Títulos e Labels */
        .card-title { color: var(--primary-dark); font-weight: 700; }
        
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Inputs consistentes com o Dashboard */
        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            background-color: #f8f9fa;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
            background-color: #fff;
        }

        /* Botão Principal */
        .btn-enviar {
            background-color: var(--accent-blue);
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-enviar:hover {
            background-color: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 5px 10px rgba(13, 110, 253, 0.2);
        }

        /* Área de upload simples */
        .upload-section {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            background: #fbfbfb;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="solicitante_dashboard.php">
                <i class="bi bi-shield-check me-2 text-primary"></i> SGM Admin
            </a>
            <a href="solicitante_dashboard.php" class="btn btn-sm btn-outline-light rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="request-card">
                    <div class="mb-4">
                        <h4 class="card-title mb-1">Nova Solicitação</h4>
                        <p class="text-muted small">Informe os detalhes para a equipe de manutenção.</p>
                    </div>

                    <form id="formChamado">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Bloco / Setor</label>
                                <select id="selectBloco" class="form-select" required onchange="carregarAmbientes(this.value)">
                                    <option value="">Selecione o bloco</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Ambiente / Sala</label>
                                <select id="selectAmbiente" class="form-select" required>
                                    <option value="">Selecione o local</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoria</label>
                            <select id="selectTipo" class="form-select" required>
                                <option value="">O que precisa de reparo?</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição do Problema</label>
                            <textarea id="descricao" class="form-control" rows="4" required placeholder="Descreva aqui o que está acontecendo..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Evidência (Opcional)</label>
                            <div class="upload-section text-center">
                                <i class="bi bi-camera text-muted fs-3 mb-2 d-block"></i>
                                <input type="file" id="foto" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-enviar w-100 shadow-sm">
                            <i class="bi bi-send-fill me-2"></i> Confirmar e Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/solicitante_abrir_chamado.js"></script>

</body>
</html>