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
    <title>SGM - Minhas Solicitações</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --bg-body: #f4f7fe;
            --brand-blue: #5d87ff;
            --brand-dark: #2a3547;
            --sidebar-width: 260px;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--brand-dark);
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        /* Sidebar - Estilo igual às imagens enviadas */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 2rem 1.5rem;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .brand {
            font-weight: 700;
            color: var(--brand-blue);
            font-size: 1.25rem;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            color: #64748b;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-weight: 600;
        }

        .nav-link:hover, .nav-link.active {
            background: #f1f5f9;
            color: var(--brand-blue);
        }

        .nav-link.active {
            background: rgba(93, 135, 255, 0.1);
        }

        /* Conteúdo Principal */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem 3rem;
            width: calc(100% - var(--sidebar-width));
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 8px 16px;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            font-weight: 600;
            color: var(--brand-blue);
        }

        .btn-logout-top {
            background: #fff5f5;
            color: #ff4560;
            border: 1px solid #ffebeb;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-logout-top:hover {
            background: #ff4560;
            color: white;
        }

        /* Estilo da Tabela e Card */
        .main-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .card-header-custom {
            background: white;
            border-bottom: 1px solid #f1f3f9;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-nova-solicitacao {
            background: var(--brand-blue);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(93, 135, 255, 0.3);
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-nova-solicitacao:hover {
            background: #4570e6;
            color: white;
            transform: translateY(-2px);
        }

        .mini-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 10px;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand">
            <i class="bi bi-shield-check"></i> SGM SOLICITANTE
        </div>
        <nav>
            <a href="solicitante_dashboard.php" class="nav-link active">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="solicitante_abrir_chamado.php" class="nav-link">
                <i class="bi bi-plus-square-fill"></i> Nova Solicitação
            </a>
            </nav>
        
        <div class="mt-auto">
            <a href="javascript:void(0)" onclick="confirmarSair()" class="nav-link text-danger">
                <i class="bi bi-box-arrow-left"></i> Sair do Sistema
            </a>
        </div>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div>
                <h2 class="fw-bold mb-0">Olá, <?= explode(' ', $nomeUsuario)[0] ?>! </h2>
                <p class="text-muted mb-0">Acompanhe o andamento dos seus chamados.</p>
            </div>
            
            <div class="d-flex gap-3 align-items-center">
                <div class="user-profile">
                    <i class="bi bi-person-circle"></i>
                    <?= $nomeUsuario ?>
                
        </header>

        <div class="card main-card">
            <div class="card-header-custom">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                    <i class="bi bi-clipboard-data text-primary fs-5"></i>
                </div>
                <h5 class="m-0 fw-bold">Minhas Solicitações</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>FOTO</th>
                            <th>LOCALIZAÇÃO</th>
                            <th>DESCRIÇÃO</th>
                            <th>DATA</th>
                            <th class="text-center">STATUS</th>
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
                    <img src="" id="imgModal" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const configStatus = { 
            'aberto': { classe: 'bg-info-subtle text-info', label: 'Aberto' }, 
            'agendado': { classe: 'bg-primary-subtle text-primary', label: 'Agendado' }, 
            'em_execucao': { classe: 'bg-warning-subtle text-warning-emphasis', label: 'Em Execução' }, 
            'concluido': { classe: 'bg-success-subtle text-success', label: 'Concluído' }, 
            'fechado': { classe: 'bg-dark-subtle text-dark', label: 'Fechado' } 
        };

        function confirmarSair() {
            if (confirm(`Tem certeza que deseja sair do sistema?`)) {
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

                if (!chamados || chamados.length === 0) {
                    lista.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted">Nenhum chamado aberto ainda.</td></tr>';
                    return;
                }

                const rows = await Promise.all(chamados.map(async c => {
                    const resAnexos = await fetch(`api/anexos.php?id_chamado=${c.id_chamado}`);
                    const anexos = await resAnexos.json();
                    
                    const thumbHtml = (anexos && anexos.length > 0) ?
                        `<img src="${anexos[0].caminho_arquivo}" class="mini-thumb cursor-pointer" onclick="verFoto('${anexos[0].caminho_arquivo}')">` :
                        `<div class="bg-light d-flex align-items-center justify-content-center rounded" style="width:48px; height:48px;"><i class="bi bi-camera text-muted"></i></div>`;

                    const statusObj = configStatus[c.status] || { classe: 'bg-light text-dark', label: c.status };

                    return `
                        <tr>
                            <td class="ps-4 text-muted fw-bold">#${c.id_chamado}</td>
                            <td>${thumbHtml}</td>
                            <td>
                                <div class="fw-bold text-dark">${c.ambiente_nome || 'N/A'}</div>
                                <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>${c.bloco_nome || 'N/A'}</small>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;" title="${c.descricao_problema}">
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
                console.error(error);
                document.getElementById('tabelaChamados').innerHTML = '<tr><td colspan="6" class="text-center py-5 text-danger">Falha ao carregar dados.</td></tr>';
            }
        }

        carregarChamados();
    </script>
</body>
</html>