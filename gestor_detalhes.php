<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    header("Location: login.php"); exit;
}
$id = $_GET['id'] ?? 0;
$nomeUsuario = $_SESSION['user_nome'] ?? 'Gestor';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Gerenciar Chamado #<?= $id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #212529 0%, #343a40 100%);
            --accent-blue: #0d6efd;
        }

        body { background-color: #f0f2f5; font-family: 'Segoe UI', system-ui, sans-serif; }
        
        /* Navbar Consistente */
        .navbar { background: var(--primary-gradient) !important; border-bottom: 3px solid var(--accent-blue); }

        /* Estilo dos Cards */
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .card-header { background: white; border-bottom: 1px solid #edf2f9; padding: 20px; border-radius: 15px 15px 0 0 !important; }
        
        /* Seção de Atribuição (Destaque) */
        .card-triagem { border-top: 5px solid var(--accent-blue); }
        .card-triagem .card-header { background-color: #f8f9ff; }

        /* Miniaturas de Fotos */
        .thumb-container { position: relative; overflow: hidden; border-radius: 10px; transition: 0.3s; border: 2px solid transparent; }
        .thumb-container:hover { transform: scale(1.05); border-color: var(--accent-blue); }
        .thumb-img { width: 100%; height: 100px; object-fit: cover; cursor: pointer; }
        
        .info-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 700; margin-bottom: 2px; }
        .info-value { font-size: 1rem; color: #2d3748; margin-bottom: 15px; }

        #imgModal { max-height: 85vh; border-radius: 8px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="gestor_dashboard.php">
                <i class="bi bi-shield-check me-2 text-primary"></i>SGM Admin
            </a>
            <button onclick="confirmarSair()" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                <i class="bi bi-box-arrow-right me-1"></i> Sair
            </button>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="d-flex align-items-center mb-4">
            <a href="gestor_chamados.php" class="btn btn-white shadow-sm rounded-circle me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h3 class="fw-bold m-0">Gerenciar Chamado</h3>
                <span class="text-muted">Protocolo: <?= $id ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold m-0"><i class="bi bi-file-earmark-text me-2"></i>Dados da Solicitação</h5>
                        <div id="badgeStatus"></div>
                    </div>
                    <div id="detalhesChamado" class="card-body p-4 text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Carregando informações...</p>
                    </div>
                </div>

                <div id="areaFechamento"></div>
            </div>

            <div class="col-md-5">
                <div class="card card-triagem shadow">
                    <div class="card-header">
                        <h5 class="fw-bold m-0 text-primary"><i class="bi bi-person-gear me-2"></i>Triagem e Atribuição</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="formAtribuir">
                            <input type="hidden" id="id_chamado" value="<?= $id ?>">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small">TÉCNICO RESPONSÁVEL</label>
                                <select id="selectTecnico" class="form-select form-select-lg shadow-sm" required></select>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small">PRIORIDADE</label>
                                        <select id="prioridade" class="form-select shadow-sm">
                                            <option value="baixa">Baixa</option>
                                            <option value="media">Média</option>
                                            <option value="alta">Alta</option>
                                            <option value="urgente">Urgente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small">DATA PREVISTA</label>
                                        <input type="date" id="data_prevista" class="form-control shadow-sm" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow">
                                <i class="bi bi-check-lg me-2"></i>Confirmar Atribuição
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <img src="" id="imgModal" class="img-fluid shadow-lg">
                    <div class="mt-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Fechar Visualização</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarSair() {
            if (confirm("Olá <?= $nomeUsuario ?>, tem certeza que deseja encerrar sua sessão?")) {
                window.location.href = "api/logout.php";
            }
        }

        function verFoto(url) {
            document.getElementById('imgModal').src = url;
            new bootstrap.Modal(document.getElementById('modalFoto')).show();
        }

        async function carregarDados() {
            try {
                // 1. Carrega Técnicos
                const resTec = await fetch('api/usuarios.php');
                const tecnicos = await resTec.json();
                const select = document.getElementById('selectTecnico');
                select.innerHTML = '<option value="">Selecione um técnico profissional...</option>';
                tecnicos.forEach(t => {
                    select.innerHTML += `<option value="${t.id_usuario}">${t.nome}</option>`;
                });

                // 2. Carrega Dados do Chamado
                const resChamado = await fetch(`api/chamados.php?id=<?= $id ?>`);
                const c = await resChamado.json();

                if (!c || c.error) {
                    document.getElementById('detalhesChamado').innerHTML = '<div class="alert alert-danger">Erro: Chamado não encontrado.</div>';
                    return;
                }

                // Renderiza Detalhes com Labels Modernos
                document.getElementById('detalhesChamado').innerHTML = `
                    <div class="row text-start">
                        <div class="col-12">
                            <div class="info-label">Descrição do Problema</div>
                            <div class="info-value bg-light p-3 rounded border-start border-primary border-4">
                                ${c.descricao_problema || 'Sem descrição detalhada.'}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Local da Ocorrência</div>
                            <div class="info-value"><strong>${c.bloco_nome || 'N/A'}</strong> - ${c.ambiente_nome || 'N/A'}</div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="info-label">Solicitante</div>
                            <div class="info-value">${c.solicitante_nome || 'Desconhecido'}</div>
                        </div>
                        <div class="col-12">
                            <div class="info-label">Data e Hora de Abertura</div>
                            <div class="info-value"><i class="bi bi-clock me-2"></i>${c.data_abertura ? new Date(c.data_abertura).toLocaleString() : '---'}</div>
                        </div>
                    </div>
                    <div id="fotosContainer" class="mt-4 border-top pt-4"></div>
                `;

                // Badge de Status Dinâmico
                document.getElementById('badgeStatus').innerHTML = `<span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill">${(c.status || 'ABERTO').toUpperCase()}</span>`;

                // Preenche Formulário
                if(c.id_tecnico) select.value = c.id_tecnico;
                if(c.prioridade) document.getElementById('prioridade').value = c.prioridade;
                if(c.data_previsao_conclusao) document.getElementById('data_prevista').value = c.data_previsao_conclusao;

                // Lógica de Fechamento/Reabertura
                const area = document.getElementById('areaFechamento');
                if (c.status === 'concluido') {
                    area.innerHTML = `
                        <div class="card border-success bg-success-subtle shadow mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-success"><i class="bi bi-check2-circle me-2"></i>Solução Técnica Enviada:</h6>
                                <p class="mb-3 text-dark">${c.solucao_tecnica || 'Nenhuma solução informada.'}</p>
                                <button onclick="alterarStatusOS(<?= $id ?>, 'fechar')" class="btn btn-success btn-lg w-100 shadow-sm">Aprovar e Fechar Definitivamente</button>
                            </div>
                        </div>`;
                } else if (c.status === 'fechado') {
                    area.innerHTML = `<button onclick="alterarStatusOS(<?= $id ?>, 'reabrir')" class="btn btn-warning btn-lg w-100 shadow-sm fw-bold"><i class="bi bi-arrow-counterclockwise me-2"></i>Reabrir Chamado para Revisão</button>`;
                }

                // 3. Carrega Fotos com Galeria Moderna
                const resAnexos = await fetch(`api/anexos.php?id_chamado=<?= $id ?>`);
                const anexos = await resAnexos.json();
                if(anexos && anexos.length > 0) {
                    let htmlFotos = '<h6 class="text-start fw-bold mb-3"><i class="bi bi-images me-2 text-primary"></i>Evidências em Anexo:</h6><div class="row g-2">';
                    anexos.forEach(arq => {
                        const caminho = arq.caminho_arquivo.startsWith('assets') ? arq.caminho_arquivo : `./assets/uploads/${arq.caminho_arquivo}`;
                        htmlFotos += `
                            <div class="col-4 col-md-3">
                                <div class="thumb-container shadow-sm">
                                    <img src="${caminho}" class="thumb-img" onclick="verFoto('${caminho}')" title="Clique para ampliar">
                                    <div class="p-1 bg-white text-center"><small class="text-muted text-capitalize" style="font-size: 0.6rem;">${arq.tipo_anexo}</small></div>
                                </div>
                            </div>`;
                    });
                    document.getElementById('fotosContainer').innerHTML = htmlFotos + '</div>';
                } else {
                    document.getElementById('fotosContainer').innerHTML = '<p class="text-muted small italic">Nenhuma evidência fotográfica anexada.</p>';
                }

            } catch (error) {
                console.error("Erro fatal:", error);
                document.getElementById('detalhesChamado').innerHTML = '<div class="alert alert-danger">Erro de conexão com o servidor.</div>';
            }
        }

        // Funções de Ação (POST) seguindo sua lógica original
        async function alterarStatusOS(id, acao) {
            if(!confirm(`Deseja realmente ${acao} este chamado?`)) return;
            const res = await fetch('api/gestor_acoes.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id_chamado: id, acao: acao })
            });
            const result = await res.json();
            if(result.success) location.reload();
            else alert("Erro: " + result.message);
        }

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
            else alert("Erro ao atribuir: " + result.message);
        };

        carregarDados();
    </script>
</body>
</html>