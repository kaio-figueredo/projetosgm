<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGM - Gerenciar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-dark: #212529; --accent-blue: #0d6efd; --bg-body: #f0f2f5; }
        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }
        
        .navbar { 
            background: linear-gradient(135deg, #212529 0%, #343a40 100%) !important; 
            border-bottom: 3px solid var(--accent-blue);
            padding: 12px 0;
        }

        .profile-container { 
            max-width: 500px; margin: 40px auto; background: #fff; 
            border-radius: 30px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
        }

        .profile-header { 
            background: linear-gradient(180deg, #164ca0 0%, #0d6efd 100%); 
            padding: 40px 20px; text-align: center; color: white; 
        }

        .user-icon-circle { 
            width: 80px; height: 80px; background: rgba(255,255,255,0.2); 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            margin: 0 auto 15px; font-size: 2rem; backdrop-filter: blur(5px); 
        }

        .form-section { padding: 30px; }
        .form-label { 
            font-weight: 700; font-size: 0.75rem; color: #adb5bd; 
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; 
        }

        .custom-input { 
            border: none; background: #f8f9fa; border-radius: 12px; 
            padding: 12px 15px; margin-bottom: 20px; width: 100%; font-weight: 500; 
        }

        .btn-update { 
            background: var(--accent-blue); color: white; border: none; 
            width: 100%; padding: 15px; border-radius: 15px; font-weight: 700; 
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3); transition: 0.3s; 
        }

        .btn-delete {
            background: #dc3545; color: white; border: none;
            width: 100%; padding: 12px; border-radius: 15px;
            font-weight: 600; margin-top: 10px; opacity: 0.8; transition: 0.3s;
        }

        .btn-delete:hover { opacity: 1; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="gestor_usuarios.php">
                <i class="bi bi-shield-check me-2 text-primary"></i> SGM | Gestão Administrativa
            </a>
            <div class="d-flex align-items-center">
                <span class="text-light me-3 small opacity-75">Olá, Admin Gestor</span>
                <a href="api/logout.php" class="btn btn-sm btn-outline-danger rounded-pill px-3">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <div class="user-icon-circle"><i class="bi bi-person-gear"></i></div>
                <h2 class="fw-bold">Editar Perfil</h2>
                <p class="m-0 opacity-75">ID: #<?php echo $_GET['id']; ?></p>
            </div>

            <div class="form-section">
                <form action="api/atualizar_usuario.php" method="POST">
                    <input type="hidden" name="id_usuario" value="<?php echo $_GET['id']; ?>">
                    
                    <label class="form-label">Nome Completo</label>
                    <input type="text" name="nome" class="custom-input" value="Luma" required>

                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="custom-input" value="luma@email.com" required>

                    <label class="form-label">Status da Conta</label>
                    <select name="ativo" class="custom-input">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>

                    <button type="submit" class="btn btn-update">Salvar Alterações</button>
                    
                    <button type="button" class="btn btn-delete" onclick="confirmarExclusao()">
                        <i class="bi bi-trash me-1"></i> Excluir Usuário
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmarExclusao() {
            if(confirm('Tem certeza que deseja remover este usuário permanentemente?')) {
                // Lógica de exclusão aqui
            }
        }
    </script>
</body>
</html>