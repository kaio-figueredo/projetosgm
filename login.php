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
            --primary-gradient: linear-gradient(135deg, #212529 0%, #343a40 100%);
            --accent-color: #0d6efd;
        }

        body { 
            background: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 15px;
        }

        .login-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .login-header {
            background: var(--primary-gradient);
            padding: 40px 20px;
            text-align: center;
            color: white;
            border-bottom: 4px solid var(--accent-color);
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 10px;
            display: block;
            color: var(--accent-color);
        }

        .form-content {
            padding: 40px 30px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: #adb5bd;
            border-radius: 12px 0 0 12px;
        }

        .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
            padding: 12px;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            background-color: #fff;
            box-shadow: none;
            border-color: #dee2e6;
        }

        .btn-login {
            background: var(--accent-color);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
            background: #0b5ed7;
        }

        #mensagem {
            min-height: 24px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="bi bi-shield-lock-fill"></i>
                <h3 class="fw-bold m-0">SGM ACESSO</h3>
                <p class="small opacity-75 m-0 mt-1">Sistema de Gestão de Manutenção</p>
            </div>

            <div class="form-content">
                <form id="formLogin">
                    <div class="mb-4">
                        <label class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Senha</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" id="senha" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100">
                        Entrar no Sistema
                    </button>

                    <div id="mensagem" class="mt-3 text-center text-danger small"></div>
                </form>
            </div>
        </div>
        
        <p class="text-center mt-4 text-muted small">
            &copy; 2026 SGM - Todos os direitos reservados a &copy; Kaiox
        </p>
    </div>

    <script src="assets/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>