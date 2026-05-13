<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --brand-main: #34b3e4;
            --brand-light: #76d7ea;
            --brand-dark: #0077b6;
            --text-muted: #8e99a3;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-wrapper {
            width: 100%;
            max-width: 550px; 
            padding: 40px;
            text-align: center;
            z-index: 10;
            margin-top: -80px; 
        }

        .logo-box {
            margin-bottom: 50px;
            display: inline-block;
        }

        .logo-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo-icon-wrapper i.bi-gear-fill {
            font-size: 5rem; 
            background: linear-gradient(135deg, var(--brand-light), var(--brand-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-icon-wrapper i.bi-wrench-adjustable {
            position: absolute;
            top: -10px;
            right: -15px;
            font-size: 2.5rem; 
            color: var(--brand-light);
            transform: rotate(15deg);
        }

        .logo-text {
            font-size: 3rem; 
            font-weight: 800;
            background: linear-gradient(to right, #0077b6, #48d1cc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
            line-height: 1;
        }

        .logo-subtext {
            color: var(--text-muted);
            font-size: 1.1rem; 
            font-weight: 500;
            margin-top: 5px;
        }

        .input-group-modern {
            position: relative;
            margin-bottom: 35px;
            border-bottom: 2px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .input-group-modern:focus-within {
            border-bottom-color: var(--brand-main);
        }

        .input-group-modern i {
            position: absolute;
            left: 5px;
            top: 12px;
            font-size: 1.5rem; 
            color: var(--brand-main);
            opacity: 0.7;
        }

        .input-group-modern input {
            width: 100%;
            border: none;
            padding: 15px 10px 15px 50px; 
            outline: none;
            font-size: 1.25rem; 
            color: #444;
            background: transparent;
        }

        .btn-sgm {
            background-color: transparent;
            border: none;
            color: var(--brand-main);
            font-weight: 700;
            font-size: 1.3rem; 
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            width: 100%;
            margin-top: 30px;
            padding: 15px;
            cursor: pointer;
        }

        .play-circle {
            width: 50px; 
            height: 50px; 
            background-color: var(--brand-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 15px rgba(118, 215, 234, 0.4);
        }

        .wave-container {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 250px;
            overflow: hidden;
        }

        .waves {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .parallax > use {
            animation: wave-animation 25s cubic-bezier(.55, .5, .45, .5) infinite;
        }
        .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
        .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
        .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
        .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }

        @keyframes wave-animation {
            0% { transform: translate3d(-90px, 0, 0); }
            100% { transform: translate3d(85px, 0, 0); }
        }

        .footer-content {
            position: absolute;
            bottom: 30px;
            width: 100%;
            text-align: center;
            color: white;
            z-index: 30;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="logo-box">
            <div class="logo-icon-wrapper">
                <i class="bi bi-gear-fill"></i>
                <i class="bi bi-wrench-adjustable"></i>
            </div>
            <div class="logo-text">SGM</div>
            <div class="logo-subtext">Gestão de Manutenção</div>
        </div>

        <form id="loginForm">
            <div class="input-group-modern">
                <i class="bi bi-person-fill"></i>
                <input type="email" id="email" placeholder="nome@exemplo.com" required>
            </div>

            <div class="input-group-modern">
                <i class="bi bi-key-fill" style="transform: rotate(-45deg);"></i>
                <input type="password" id="senha" placeholder="Sua senha" required>
            </div>

            <button type="submit" class="btn-sgm">
                <div class="play-circle">
                    <i class="bi bi-play-fill"></i>
                </div>
                LOGIN
            </button>
        </form>
    </div>

    <div class="wave-container">
        <svg class="waves" viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(118, 215, 234, 0.4)" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(72, 209, 204, 0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(0, 119, 182, 0.2)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#34b3e4" />
            </g>
        </svg>
        <div class="footer-content">Desenvolvido por &copy Kaiox</div>
    </div>

    <script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;

        // IMPORTANTE: Verifique se o nome do seu arquivo PHP na pasta API é "login.php"
        // De acordo com sua imagem, há um "login.php" dentro da pasta "api".
        const url_processamento = 'api/login.php'; 

        try {
            const response = await fetch(url_processamento, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email: email, senha: senha })
            });

            // Se o servidor retornar erro 404 ou 500, cai aqui
            if (!response.ok) {
                throw new Error('Arquivo não encontrado ou erro no servidor');
            }

            const result = await response.json();

            if (result.success) {
                // Caminhos baseados na sua imagem da pasta raiz
                if (result.perfil === 'gestor') {
                    window.location.href = 'gestor_dashboard.php';
                } else if (result.perfil === 'tecnico') {
                    window.location.href = 'tecnico_minhas_tarefas.php';
                } else {
                    window.location.href = 'solicitante_dashboard.php';
                }
            } else {
                alert(result.message || 'Credenciais inválidas.');
            }
        } catch (error) {
            console.error('Erro detalhado:', error);
            alert('Erro ao conectar com o servidor. Verifique se o arquivo api/login.php existe.');
        }
    });
    </script>
</body>
</html>