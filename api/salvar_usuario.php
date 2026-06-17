<?php
// Configurações de conexão
$host = 'localhost';
$db   = 'sgm_db';
$user = 'root';
// Corrigido: No XAMPP a senha padrão é vazia. 
// O erro 'Access denied' nas suas fotos acontece porque você definiu 'sgm_db' aqui.
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome   = $_POST['nome'];
        $email  = $_POST['email'];
        $perfil = $_POST['perfil'];
        // Usando password_hash para salvar na coluna 'senha_hash'
        $senha  = password_hash($_POST['senha'], PASSWORD_DEFAULT); 
        $ativo  = 1; // Valor para a coluna 'ativo'

        // 1. VERIFICAÇÃO DE EMAIL DUPLICADO
        $checkEmail = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $checkEmail->execute([$email]);

        if ($checkEmail->rowCount() > 0) {
            // Se encontrar o e-mail, exibe o alerta e para a execução
            echo "<script>
                    alert('Erro: Este e-mail já está cadastrado no sistema!');
                    window.history.back(); 
                  </script>";
            exit; 
        }

        // 2. CADASTRO NO BANCO DE DADOS
        // Note: As colunas devem ser exatamente idênticas ao seu banco: nome, email, senha_hash, perfil, ativo
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'usuario')";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nome, $email, $perfil, $senha, $ativo])) {
            echo "<script>
                    alert('Usuário cadastrado com sucesso!');
                    window.location.href='../gestor_usuarios.php';
                  </script>";
        }
    }
} catch (PDOException $e) {
    // Exibe o erro caso a conexão falhe (como o erro de senha que você teve)
    echo "Erro técnico: " . $e->getMessage();
}
?>