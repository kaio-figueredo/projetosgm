<?php
// Configurações de conexão
$host = "localhost";
$db   = "sgm_db";
$user = "root";
$pass = "";

// Inicializa arrays para o gráfico com segurança
$labelsGrafico = [];
$dadosGrafico = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultas para os contadores: Blocos, Ambientes e Usuários
    $resBlocos    = $pdo->query("SELECT COUNT(*) as total FROM blocos")->fetch();
    $resAmbientes = $pdo->query("SELECT COUNT(*) as total FROM ambientes")->fetch();
    $resUsuarios  = $pdo->query("SELECT COUNT(*) as total FROM usuarios")->fetch();

    // Consultas para os contadores: Status dos Chamados
    $resRecusados  = $pdo->query("SELECT COUNT(*) as total FROM chamados WHERE status = 'Recusado'")->fetch();
    $resAndamento  = $pdo->query("SELECT COUNT(*) as total FROM chamados WHERE status = 'Em andamento' OR status = 'Em Curso'")->fetch();
    $resConcluidos = $pdo->query("SELECT COUNT(*) as total FROM chamados WHERE status = 'Concluído'")->fetch();

    // ==========================================
    // LÓGICA DO GRÁFICO (Últimos 7 dias)
    // ==========================================
    $ultimos7Dias = [];
    for ($i = 6; $i >= 0; $i--) {
        $data = date('Y-m-d', strtotime("-$i days"));
        $ultimos7Dias[$data] = 0; 
    }

    $sqlGrafico = "SELECT DATE(data_abertura) as data_chamado, COUNT(*) as total 
                   FROM chamados 
                   WHERE data_abertura >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                   GROUP BY DATE(data_abertura)";
    
    $queryGrafico = $pdo->query($sqlGrafico);

    while ($row = $queryGrafico->fetch(PDO::FETCH_ASSOC)) {
        $data = $row['data_chamado'];
        if (isset($ultimos7Dias[$data])) {
            $ultimos7Dias[$data] = (int)$row['total'];
        }
    }

    $diasSemanaPT = ['Sun' => 'Dom', 'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb'];
    
    foreach ($ultimos7Dias as $data => $total) {
        $diaIngles = date('D', strtotime($data));
        $labelsGrafico[] = $diasSemanaPT[$diaIngles] . ' (' . date('d/m', strtotime($data)) . ')';
        $dadosGrafico[] = $total;
    }

} catch (PDOException $e) {
    $resBlocos = $resAmbientes = $resUsuarios = $resRecusados = $resAndamento = $resConcluidos = ['total' => 0];
    $labelsGrafico = ['Erro'];
    $dadosGrafico = [0];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM | Dashboard Corporativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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

        /* Sidebar - Padronizada e Idêntica */
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

        /* Links da Sidebar */
        .nav-link {
            color: #A3AED0;
            font-weight: 600;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            text-decoration: none;
        }

        .nav-link.active, .nav-link:hover {
            background: var(--bg-light);
            color: var(--primary-purple);
        }

        /* Cards de Dados */
        .card-stat {
            background: white;
            border-radius: 20px;
            padding: 20px;
            border: none;
            box-shadow: 0 10px 20px rgba(0,0,0,0.02);
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .card-stat:hover { transform: translateY(-5px); }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .btn-action {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: #2b3674;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-action:hover {
            border-color: var(--primary-purple);
            color: var(--primary-purple);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.1);
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>SGM Gestão</h4>
    
    <div class="nav flex-column flex-grow-1">
        <a href="dashboard.php" class="nav-link active"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="gestor_chamados.php" class="nav-link"><i class="bi bi-ticket-perforated"></i> Chamados</a>
        <a href="gestor_blocos.php" class="nav-link"><i class="bi bi-building"></i> Blocos</a>
        <a href="gestor_ambientes.php" class="nav-link"><i class="bi bi-geo-alt"></i> Ambientes</a>
        <a href="gestor_servicos.php" class="nav-link"><i class="bi bi-cpu"></i> Serviços</a>
        
        <hr class="text-secondary my-3 opacity-25">
        <small class="text-muted fw-bold mb-2 px-3" style="font-size: 0.7rem; letter-spacing: 1px;">GESTÃO DE PESSOAS</small>
        
        <a href="add_usuario.php" class="nav-link"><i class="bi bi-person-plus"></i> Add Usuário</a>
        <a href="add_tecnico.php" class="nav-link"><i class="bi bi-person-gear"></i> Add Técnico</a>
    </div>

    <a href="#" onclick="confirmarSair()" class="nav-link text-danger mt-4"><i class="bi bi-box-arrow-right"></i> Sair</a>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <span class="text-muted small fw-bold">SGM / DASHBOARD</span>
            <h2 class="fw-bold m-0">Painel de Controle</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <p class="m-0 fw-bold small">Admin Gestor</p>
                <p class="m-0 text-muted extra-small" style="font-size: 10px;"><?php echo date('d M, Y'); ?></p>
            </div>
            <img src="https://ui-avatars.com/api/?name=Admin+Gestor&background=6366f1&color=fff" class="rounded-circle" width="40">
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-dark bg-opacity-10 text-dark"><i class="bi bi-building"></i></div>
                <div>
                    <p class="text-muted small mb-0">Total de Blocos</p>
                    <h4 class="fw-bold mb-0"><?php echo $resBlocos['total']; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-geo"></i></div>
                <div>
                    <p class="text-muted small mb-0">Ambientes Cadastrados</p>
                    <h4 class="fw-bold mb-0"><?php echo $resAmbientes['total']; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-primary bg-opacity-10 text-primary"><i class="bi bi-people"></i></div>
                <div>
                    <p class="text-muted small mb-0">Usuários Ativos</p>
                    <h4 class="fw-bold mb-0"><?php echo $resUsuarios['total']; ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-danger bg-opacity-10 text-danger"><i class="bi bi-x-octagon"></i></div>
                <div>
                    <p class="text-muted small mb-0">Recusados</p>
                    <h4 class="fw-bold mb-0"><?php echo $resRecusados['total']; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-warning bg-opacity-10 text-warning"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <p class="text-muted small mb-0">Em Andamento</p>
                    <h4 class="fw-bold mb-0"><?php echo $resAndamento['total']; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-success bg-opacity-10 text-success"><i class="bi bi-check2-circle"></i></div>
                <div>
                    <p class="text-muted small mb-0">Concluídos</p>
                    <h4 class="fw-bold mb-0"><?php echo $resConcluidos['total']; ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4 border-0 rounded-4 shadow-sm">
                <h5 class="fw-bold mb-4">Volume de Chamados (Últimos 7 dias)</h5>
                <canvas id="chartVol" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="fw-bold mb-3">Gestão Rápida</h5>
            <div class="d-flex flex-column gap-3">
                <a href="add_usuario.php" class="btn-action d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-person-plus me-2"></i> Novo Usuário</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="add_gestor.php" class="btn-action d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-person-badge me-2"></i> Novo Gestor</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="gestor_ambientes.php" class="btn-action d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-geo-alt me-2"></i> Ambientes</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</main>

<script>
    const chartLabels = <?= json_encode($labelsGrafico) ?>;
    const chartData = <?= json_encode($dadosGrafico) ?>;

    const ctx = document.getElementById('chartVol').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Chamados Abertos',
                data: chartData,
                backgroundColor: '#6366f1',
                borderRadius: 8
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    grid: { display: false }, 
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                },
                x: { grid: { display: false } }
            }
        }
    });

    function confirmarSair() {
        if (confirm("Deseja realmente sair?")) window.location.href = "logout.php";
    }
</script>

</body>
</html>