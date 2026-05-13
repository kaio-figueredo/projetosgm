<?php
$host = 'localhost';
$db   = 'sgm_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id     = $_POST['id_usuario'];
        $nome   = $_POST['nome'];
        $email  = $_POST['email'];
        $perfil = $_POST['perfil'];
        $ativo  = $_POST['ativo'];

        // Verifica se o e-mail já existe em OUTRO usuário
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ? AND id_usuario != ?");
        $stmt->execute([$email, $id]);

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Erro: Este e-mail já está sendo usado por outro usuário!'); window.history.back();</script>";
            exit;
        }

        // Atualiza os dados
        $sql = "UPDATE usuarios SET nome = ?, email = ?, perfil = ?, ativo = ? WHERE id_usuario = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nome, $email, $perfil, $ativo, $id])) {
            echo "<script>alert('Dados atualizados com sucesso!'); window.location.href='../gestor_usuarios.php';</script>";
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>