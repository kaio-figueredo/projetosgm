<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    header("Location: login.php"); exit;
}
$id = $_GET['id'] ?? 0;
$nomeUsuario = $_SESSION['user_nome'] ?? 'Admin Gestor';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Gerenciar Chamado #<?= $id ?></title>
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
        }

        .nav-link.active, .nav-link:hover {
            background: var(--bg-light);
            color: var(--primary-purple);
        }

        /* Cards e Layout */
        .card-pro {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            padding: 25px;
            margin-bottom: 25px;
        }

        .info-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #A3AED0;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .description-box {
            background: #f8faff;
            border-radius: 15px;
            padding: 20px;
            border-left: 5px solid var(--primary-purple);
            font-weight: 500;
        }

        /* Formulários */
        .form-select, .form-control {
            border-radius: 12px;
            border: 1px solid #E0E5F2;
            padding: 12px;
            font-weight: 500;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 0.25 mil rgba(99, 102, 241, 0.1);
        }

        .btn-confirm {
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-confirm:hover {
            background: #4f46e5;
            transform: translateY(-2px);
        }

        /* Galeria de Fotos */
        .thumb-wrapper {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            cursor: pointer;
            transition: 0.3s;
            height: 100px;
        }

        .thumb-wrapper:hover { transform: scale(1.05); }

        .thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-pill {
            padding: 6px 15px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #E0E5F2;
            color: #2b3674;
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
        <a href="gestor_servicos.php" class="nav-link"><i class="bi bi-cpu"></i> Serviços</a>
    </div>

    <a href="logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <a href="gestor_chamados.php" class="btn btn-light rounded-circle shadow-sm"><i class="bi bi-arrow-left"></i></a>
            <div>
                <span class="text-muted small fw-bold">CHAMADO / #<?= $id ?></span>
                <h2 class="fw-bold m-0">Triagem Técnica</h2>
            </div>
        </div>
        <div id="badgeStatusContainer"></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-pro">
                <h5 class="fw-bold mb-4"><i class="bi bi-info-circle me-2 text-primary"></i>Informações do Chamado</h5>
                
                <div id="detalhesChamado">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                    </div>
                </div>

                <div id="fotosContainer" class="mt-4 border-top pt-4"></div>
            </div>

            <div id="areaFechamento"></div>
        </div>

        <div class="col-lg-5">
            <div class="card-pro border-top border-primary border-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-person-plus me-2 text-primary"></i>Designar Técnico</h5>
                
                <form id="formAtribuir">
                    <div class="mb-4">
                        <label class="info-label">Técnico Responsável</label>
                        <select id="selectTecnico" class="form-select shadow-sm" required></select>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="info-label">Prioridade</label>
                            <select id="prioridade" class="form-select shadow-sm">
                                <option value="baixa">Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="info-label">Previsão</label>
                            <input type="date" id="data_prevista" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-confirm w-100 mt-4 shadow-lg">
                        Confirmar e Notificar Técnico
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img src="" id="imgModal" class="img-fluid rounded-4 shadow-lg" style="max-height: 80vh;">
                <div class="mt-4">
                    <button type="button" class="btn btn-blur px-5 rounded-pill text-white" data-bs-dismiss="modal" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    async function carregarDados() {
        try {
            // Carregar Técnicos
            const resTec = await fetch('api/usuarios.php');
            const tecnicos = await resTec.json();
            const select = document.getElementById('selectTecnico');
            select.innerHTML = '<option value="">Selecione o profissional...</option>';
            tecnicos.forEach(t => { select.innerHTML += `<option value="${t.id_usuario}">${t.nome}</option>`; });

            // Carregar Detalhes do Chamado
            const resChamado = await fetch(`api/chamados.php?id=<?= $id ?>`);
            const c = await resChamado.json();

            if (c.error) {
                document.getElementById('detalhesChamado').innerHTML = '<div class="alert alert-danger">Chamado não encontrado.</div>';
                return;
            }

            // Renderizar Status no Header
            document.getElementById('badgeStatusContainer').innerHTML = `
                <span class="status-pill">${(c.status || 'aberto').toUpperCase()}</span>
            `;

            // Renderizar Detalhes
            document.getElementById('detalhesChamado').innerHTML = `
                <div class="info-label">Descrição da Solicitação</div>
                <div class="description-box mb-4">${c.descricao_problema || 'Nenhuma descrição fornecida.'}</div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-label">Localização</div>
                        <div class="info-value"><i class="bi bi-geo-alt me-2 text-primary"></i>${c.bloco_nome} - ${c.ambiente_nome}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Solicitante</div>
                        <div class="info-value"><i class="bi bi-person me-2 text-primary"></i>${c.solicitante_nome}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-label">Abertura</div>
                        <div class="info-value"><i class="bi bi-calendar3 me-2 text-primary"></i>${new Date(c.data_abertura).toLocaleString()}</div>
                    </div>
                </div>
            `;

            // Lógica de Formulário
            if(c.id_tecnico) select.value = c.id_tecnico;
            if(c.prioridade) document.getElementById('prioridade').value = c.prioridade;
            if(c.data_previsao_conclusao) document.getElementById('data_prevista').value = c.data_previsao_conclusao;

            // Carregar Fotos
            const resAnexos = await fetch(`api/anexos.php?id_chamado=<?= $id ?>`);
            const anexos = await resAnexos.json();
            if(anexos.length > 0) {
                let htmlFotos = '<h6 class="fw-bold mb-3 small text-muted">ANEXOS / EVIDÊNCIAS</h6><div class="row g-2">';
                anexos.forEach(arq => {
                    const caminho = arq.caminho_arquivo.startsWith('assets') ? arq.caminho_arquivo : `./assets/uploads/${arq.caminho_arquivo}`;
                    htmlFotos += `
                        <div class="col-3">
                            <div class="thumb-wrapper shadow-sm" onclick="verFoto('${caminho}')">
                                <img src="${caminho}" class="thumb-img">
                            </div>
                        </div>`;
                });
                document.getElementById('fotosContainer').innerHTML = htmlFotos + '</div>';
            }

            // Ações de Fechamento (estilizadas)
            const area = document.getElementById('areaFechamento');
            if (c.status === 'concluido') {
                area.innerHTML = `
                    <div class="card-pro border-success border-start border-4 bg-white">
                        <h6 class="fw-bold text-success mb-2">Relatório do Técnico:</h6>
                        <p class="small mb-3">${c.solucao_tecnica || 'Solução não detalhada.'}</p>
                        <button onclick="alterarStatusOS(<?= $id ?>, 'fechar')" class="btn btn-success w-100 rounded-pill fw-bold py-3 shadow">Aprovar e Finalizar</button>
                    </div>`;
            }

        } catch (e) { console.error(e); }
    }

    function verFoto(url) {
        document.getElementById('imgModal').src = url;
        new bootstrap.Modal(document.getElementById('modalFoto')).show();
    }

    function confirmarSair() {
        if (confirm("Deseja realmente sair?")) window.location.href = "api/logout.php";
    }

    // O Submit e outras ações permanecem as mesmas que você já tinha...
    document.getElementById('formAtribuir').onsubmit = async (e) => {
        e.preventDefault();
        const res = await fetch('api/atribuir_chamado.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id_chamado: <?= $id ?>,
                id_tecnico: document.getElementById('selectTecnico').value,
                prioridade: document.getElementById('prioridade').value,
                data_prevista: document.getElementById('data_prevista').value
            })
        });
        const result = await res.json();
        if(result.success) window.location.href = 'gestor_chamados.php';
        else alert("Erro: " + result.message);
    };

    carregarDados();
</script>
</body>
</html>