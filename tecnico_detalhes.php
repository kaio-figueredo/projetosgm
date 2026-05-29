<?php
session_start();
require_once 'config/database.php';

// Proteção: Garante que o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Pega o ID do chamado pela URL
$id_chamado = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Busca as informações do chamado no banco
$sql = "SELECT c.*, a.nome as ambiente_nome, b.nome as bloco_nome, u.nome as solicitante_nome 
        FROM chamados c 
        LEFT JOIN ambientes a ON c.id_ambiente = a.id_ambiente 
        LEFT JOIN blocos b ON a.id_bloco = b.id_bloco 
        LEFT JOIN usuarios u ON c.id_solicitante = u.id_usuario 
        WHERE c.id_chamado = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_chamado);
$stmt->execute();
$result = $stmt->get_result();
$chamado = $result->fetch_assoc();

if (!$chamado) {
    die("Chamado não encontrado ou você não tem permissão para acessá-lo.");
}

// Pega o status atual formatado em minúsculas para facilitar as verificações
$status_atual = strtolower($chamado['status'] ?? 'aberto');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM Técnico | Detalhes do Chamado #<?= $chamado['id_chamado'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --bg-body: #f4f7fe;
            --brand-blue: #5d87ff;
            --brand-dark: #2a3547;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--brand-dark);
        }

        .navbar { background: white !important; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 15px 30px; }
        .navbar-brand { font-weight: 700; color: var(--brand-blue) !important; }

        main { padding: 40px 20px; max-width: 1000px; margin: 0 auto; }

        .btn-back { margin-bottom: 20px; font-weight: 600; color: #7c8fac; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-back:hover { color: var(--brand-blue); }

        .card-custom {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 30px;
            margin-bottom: 20px;
        }

        .info-label { font-size: 0.8rem; font-weight: 700; color: #7c8fac; text-transform: uppercase; margin-bottom: 5px; }
        .info-value { font-size: 1.1rem; font-weight: 600; color: var(--brand-dark); margin-bottom: 20px; }
        .desc-box { background: #f9fbff; padding: 20px; border-radius: 12px; border: 1px solid #e5eaef; font-size: 0.95rem; }

        .status-pill { padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; display: inline-block; }
        .status-em_andamento { background: rgba(255, 174, 31, 0.1); color: #ffae1f; }
        .status-em_execucao { background: rgba(255, 174, 31, 0.1); color: #ffae1f; } /* Adicionado para suportar em_execucao do banco */
        .status-aberto { background: rgba(93, 135, 255, 0.1); color: var(--brand-blue); }
        .status-aguardando { background: rgba(93, 135, 255, 0.1); color: var(--brand-blue); }
        .status-concluido { background: rgba(19, 222, 185, 0.1); color: #13deb9; }

        .btn-action { width: 100%; padding: 15px; font-weight: 700; border-radius: 12px; font-size: 1.1rem; }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="tecnico_minhas_tarefas.php">
                <i class="bi bi-gear-wide-connected me-2"></i>SGM TÉCNICO
            </a>
        </div>
    </nav>
</header>

<main>
    <a href="tecnico_minhas_tarefas.php" class="btn-back">
        <i class="bi bi-arrow-left"></i> Voltar para a Fila
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-weight: 700;">Detalhes do Chamado #<?= $chamado['id_chamado'] ?></h2>
        
        <span class="status-pill status-<?= $status_atual ?>">
            <?= strtoupper(str_replace('_', ' ', $chamado['status'] ?? 'ABERTO')) ?>
        </span>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card-custom">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-label">Localização</div>
                        <div class="info-value">
                            <i class="bi bi-geo-alt me-1 text-primary"></i> 
                            <?= $chamado['bloco_nome'] ?? 'Bloco Desconhecido' ?> - <?= $chamado['ambiente_nome'] ?? 'Ambiente Desconhecido' ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Solicitante</div>
                        <div class="info-value">
                            <i class="bi bi-person me-1 text-primary"></i> 
                            <?= $chamado['solicitante_nome'] ?? 'Não informado' ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Data de Abertura</div>
                        <div class="info-value">
                            <i class="bi bi-calendar3 me-1 text-primary"></i> 
                            <?= date('d/m/Y \à\s H:i', strtotime($chamado['data_abertura'])) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Prioridade</div>
                        <div class="info-value" style="text-transform: capitalize;">
                            <i class="bi bi-flag me-1 text-primary"></i> 
                            <?= $chamado['prioridade'] ?? 'Baixa' ?>
                        </div>
                    </div>
                </div>

                <div class="info-label mt-3">Descrição do Problema</div>
                <div class="desc-box">
                    <?= nl2br(htmlspecialchars($chamado['descricao_problema'])) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-custom text-center">
                <i class="bi bi-tools" style="font-size: 3rem; color: var(--brand-blue);"></i>
                <h5 class="mt-3" style="font-weight: 700;">Ações da Tarefa</h5>
                <p class="text-muted" style="font-size: 0.9rem;">Gerencie o andamento deste chamado.</p>
                
                <hr style="border-color: #e5eaef; margin: 20px 0;">

                <?php if ($status_atual === 'em_andamento' || $status_atual === 'em_execucao'): ?>
                    <button class="btn btn-success btn-action mb-2" onclick="concluirChamado(<?= $chamado['id_chamado'] ?>)">
                        <i class="bi bi-check-circle me-2"></i> Concluir Serviço
                    </button>
                    <small class="text-muted">Aperte apenas quando a manutenção for finalizada.</small>
                
                <?php elseif ($status_atual === 'aberto' || $status_atual === 'aguardando'): ?>
                    <button class="btn btn-primary btn-action mb-2" onclick="iniciarDaPagina(<?= $chamado['id_chamado'] ?>)">
                        <i class="bi bi-play-circle me-2"></i> Iniciar Agora
                    </button>
                    <small class="text-muted">Você ainda não iniciou este serviço.</small>

                <?php elseif ($status_atual === 'concluido'): ?>
                    <div class="alert alert-success mt-3 mb-0" style="font-weight: 600; border-radius: 12px;">
                        <i class="bi bi-check-all me-2"></i> Serviço Concluído
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Função para iniciar o chamado por dentro da página de detalhes
    async function iniciarDaPagina(idChamado) {
        if(confirm("Deseja iniciar esta manutenção agora?")) {
            // Se no seu banco você usa 'em_execucao', troque 'em_andamento' aqui se necessário.
            await atualizarStatus(idChamado, 'em_andamento');
        }
    }

    // Função para concluir o chamado
    async function concluirChamado(idChamado) {
        if(confirm("Tem certeza que deseja marcar este serviço como concluído?")) {
            await atualizarStatus(idChamado, 'concluido');
        }
    }

    // Função central que faz o POST para sua API (reaproveitada)
    async function atualizarStatus(idChamado, novoStatus) {
        try {
            const response = await fetch('api/atualizar_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_chamado: idChamado, status: novoStatus })
            });

            const result = await response.json();

            if (result.success) {
                // Atualiza a página para refletir o novo status visualmente
                location.reload(); 
            } else {
                alert("Erro: " + result.message);
            }
        } catch (error) {
            console.error(error);
            alert("Erro ao conectar com o servidor.");
        }
    }
</script>

</body>
</html>