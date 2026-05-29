<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM Técnico | Minha Fila</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <?php
        session_start();
        require_once 'config/database.php'; // Verifique se o caminho está correto

        // Proteção
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        $id_tecnico = $_SESSION['user_id'];
        $nome_tecnico = $_SESSION['user_nome'] ?? 'Técnico';

        // Busca apenas os chamados atribuídos a este técnico
        $sql = "SELECT c.*, a.nome as ambiente_nome, b.nome as bloco_nome 
                FROM chamados c 
                LEFT JOIN ambientes a ON c.id_ambiente = a.id_ambiente 
                LEFT JOIN blocos b ON a.id_bloco = b.id_bloco 
                WHERE c.id_tecnico = ? 
                ORDER BY c.data_abertura DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_tecnico);
        $stmt->execute();
        $result = $stmt->get_result();
        $tarefas = $result->fetch_all(MYSQLI_ASSOC);
        ?>
    
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

        /* Navbar Estilizada */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 30px;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--brand-blue) !important;
            letter-spacing: -0.5px;
        }

        .user-badge {
            background: rgba(93, 135, 255, 0.1);
            color: var(--brand-blue);
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 15px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout {
            border: 1px solid #ff4560;
            color: #ff4560;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #ff4560;
            color: white;
        }

        /* Layout Principal */
        main {
            padding: 40px 20px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .dashboard-header h2 {
            font-weight: 700;
            font-size: 1.8rem;
        }

        /* Card de Tarefas */
        .card-tasks {
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

        .header-icon {
            width: 45px;
            height: 45px;
            background: var(--brand-blue);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 5px 15px rgba(93, 135, 255, 0.3);
        }

        .card-body-custom {
            padding: 25px;
        }

        /* Tabela Estilizada */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f9fbff;
            color: #7c8fac;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f9;
            font-size: 0.9rem;
        }

        /* Badge de Status */
        .status-pill {
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .status-open { background: rgba(93, 135, 255, 0.1); color: var(--brand-blue); }
        .status-progress { background: rgba(255, 174, 31, 0.1); color: #ffae1f; }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-gear-wide-connected me-2"></i>SGM TÉCNICO
            </a>
            
            <div class="d-flex align-items-center">
                <div class="user-badge">
                    <i class="bi bi-person-circle"></i>
                    João Técnico
                </div>
                <a class="btn btn-logout px-3 py-2" href="api/logout.php">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </a>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="dashboard-header">
        <h2>Olá, João! </h2>
        <p class="text-muted">Aqui estão as manutenções atribuídas a você hoje.</p>
    </div>

    <div class="card card-tasks">
        <div class="card-header-custom">
            <div class="header-icon">
                <i class="bi bi-list-task"></i>
            </div>
            <h5 class="m-0" style="font-weight: 700;">Minha Fila de Trabalho</h5>
        </div>
        
        <div class="card-body-custom">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Equipamento</th>
                            <th>Problema</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php if (empty($tarefas)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Nenhuma manutenção atribuída a você no momento.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tarefas as $t): ?>
                                    <tr>
                                        <td><strong>#<?= $t['id_chamado'] ?></strong></td>
                                        <td><?= htmlspecialchars($t['bloco_nome'] . ' - ' . $t['ambiente_nome']) ?></td>
                                        <td><?= htmlspecialchars($t['descricao_problema']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($t['data_abertura'])) ?></td>
                                        
                                        <td>
                                            <?php 
                                                // Cor da pílula baseada no status
                                                $corStatus = 'status-open'; // azul padrão
                                                if ($t['status'] === 'em_andamento') $corStatus = 'status-progress'; // amarelo
                                                if ($t['status'] === 'concluido') $corStatus = 'bg-success text-white'; // verde
                                            ?>
                                            <span class="status-pill <?= $corStatus ?>">
                                                <?= strtoupper(str_replace('_', ' ', $t['status'] ?? 'AGUARDANDO')) ?>
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <?php if ($t['status'] === 'aberto' || $t['status'] === 'aguardando'): ?>
                                                <button class="btn btn-sm btn-primary" onclick="iniciarChamado(<?= $t['id_chamado'] ?>)">Iniciar</button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline-primary" onclick="verDetalhes(<?= $t['id_chamado'] ?>)">Detalhes</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>
    // Função para apenas abrir a página de detalhes
    function verDetalhes(idChamado) {
        window.location.href = `tecnico_detalhes.php?id=${idChamado}`;
    }

    // Função para mudar o status e depois abrir os detalhes
    async function iniciarChamado(idChamado) {
        if (confirm("Tem certeza que deseja iniciar o atendimento deste chamado?")) {
            try {
                const response = await fetch('api/atualizar_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    // Envia o ID e o novo status desejado
                    body: JSON.stringify({ 
                        id_chamado: idChamado, 
                        status: 'em_andamento' 
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Se deu certo, redireciona o técnico para a página de detalhes daquele chamado
                    window.location.href = `tecnico_detalhes.php?id=${idChamado}`;
                } else {
                    alert("Erro: " + result.message);
                }
            } catch (error) {
                console.error("Erro na requisição:", error);
                alert("Erro crítico ao tentar comunicar com o servidor.");
            }
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>