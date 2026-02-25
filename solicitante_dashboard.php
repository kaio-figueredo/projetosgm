<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== "solicitante"){
    header("Location: login.php");
    exit;
}
$nomeUsuario = $_SESSION['user_nome'] ?? 'Usuário';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>SGM - Minhas Solicitações</title>
    <style>
        :root {
            --primary-color: #0d6efd;
            --bg-light: #f8f9fa;
        }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: linear-gradient(135deg, #212529 0%, #343a40 100%) !important; border-bottom: 3px solid var(--primary-color); }
        .main-card { border: none; border-radius: 15px; overflow: hidden; }
        .table thead { background-color: #f1f4f9; }
        .table thead th { border: none; color: #495057; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; padding: 15px; }
        .mini-thumb {
            width: 50px; height: 50px; object-fit: cover; border-radius: 10px;
            transition: transform 0.2s; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .mini-thumb:hover { transform: scale(1.1); }
        .status-badge { padding: 6px 12px; border-radius: 30px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        #imgModal { max-height: 85vh; border-radius: 8px; }
        .modal-content { border-radius: 20px; }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-shield-check me-2 text-primary"></i>
                <span class="fw-bold">SGM <small class="fw-light opacity-75">| Solicitante</small></span>
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-block">Bem-vindo, <strong><?= $nomeUsuario ?></strong></span>
                <button onclick="confirmarSair()" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </button>
            </div>
        </div>
    </nav>
</header>

<main class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold m-0">Minhas Solicitações</h2>
            <p class="text-muted">Acompanhe o andamento dos seus chamados em tempo real.</p>
        </div>
        <div class="col-auto">
            <a href="solicitante_abrir_chamado.php" class="btn btn-primary btn-lg rounded-pill shadow-sm px-4">
                <i class="bi bi-plus-lg me-2"></i>Nova Solicitação
            </a>
        </div>
    </div>

    <div class="card main-card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Foto</th>
                        <th>Localização</th>
                        <th>Descrição do Problema</th>
                        <th>Data</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="tabelaChamados">
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted">Buscando seus chamados...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <img src="" id="imgModal" class="shadow-lg img-fluid">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const configStatus = { 
        'aberto': { classe: 'bg-secondary-subtle text-secondary', label: 'Aberto' }, 
        'agendado': { classe: 'bg-info-subtle text-info', label: 'Agendado' }, 
        'em_execucao': { classe: 'bg-warning-subtle text-warning-emphasis', label: 'Em Execução' }, 
        'concluido': { classe: 'bg-success-subtle text-success', label: 'Concluído' }, 
        'fechado': { classe: 'bg-dark-subtle text-dark', label: 'Fechado' } 
    };

    function confirmarSair() {
        const nome = "<?= $nomeUsuario ?>";
        if (confirm(`Olá ${nome}, tem certeza que deseja sair do sistema?`)) {
            window.location.href = "api/logout.php";
        }
    }

    function verFoto(url) {
        document.getElementById('imgModal').src = url;
        new bootstrap.Modal(document.getElementById('modalFoto')).show();
    }

    async function carregarChamados() {
        try {
            const res = await fetch('api/chamados.php');
            const chamados = await res.json();
            const lista = document.getElementById('tabelaChamados');

            if (chamados.length === 0) {
                lista.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted">Nenhum chamado aberto ainda.</td></tr>';
                return;
            }

            const rows = await Promise.all(chamados.map(async c => {
                const resAnexos = await fetch(`api/anexos.php?id_chamado=${c.id_chamado}`);
                const anexos = await resAnexos.json();
                
                const thumbHtml = (anexos && anexos.length > 0) ?
                    `<img src="${anexos[0].caminho_arquivo}" class="mini-thumb" onclick="verFoto('${anexos[0].caminho_arquivo}')">` :
                    `<div class="bg-light d-flex align-items-center justify-content-center rounded" style="width:50px; height:50px;"><i class="bi bi-camera text-muted"></i></div>`;

                const statusObj = configStatus[c.status] || { classe: 'bg-light text-dark', label: c.status };

                return `
                    <tr>
                        <td class="ps-4 text-muted fw-medium">#${c.id_chamado}</td>
                        <td>${thumbHtml}</td>
                        <td>
                            <div class="fw-bold text-dark">${c.ambiente_nome || 'N/A'}</div>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>${c.bloco_nome || 'N/A'}</small>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 300px;" title="${c.descricao_problema}">
                                ${c.descricao_problema || 'Sem descrição'}
                            </div>
                        </td>
                        <td class="text-muted small">${c.data_abertura ? new Date(c.data_abertura).toLocaleDateString('pt-BR') : '---'}</td>
                        <td class="text-center">
                            <span class="status-badge ${statusObj.classe}">
                                ${statusObj.label}
                            </span>
                        </td>
                    </tr>`;
            }));

            lista.innerHTML = rows.join('');
        } catch (error) {
            lista.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-danger">Falha na conexão com a API.</td></tr>';
        }
    }

    carregarChamados();
</script>

</body>
</html>