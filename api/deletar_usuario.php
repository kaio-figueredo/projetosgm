<?php
$host = 'localhost';
$db   = 'sgm_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Previne a exclusão do ID #1 (geralmente o administrador principal)
        if ($id == 1) {
            echo "<script>alert('Erro: O administrador principal não pode ser excluído!'); window.location.href='../gestor_usuarios.php';</script>";
            exit;
        }

        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$id])) {
            echo "<script>alert('Usuário removido com sucesso!'); window.location.href='../gestor_usuarios.php';</script>";
        } else {
            echo "<script>alert('Erro ao tentar excluir o usuário.'); window.history.back();</script>";
        }
    }
} catch (PDOException $e) {
    // Exibe erro caso haja restrição de chave estrangeira (ex: usuário tem chamados vinculados)
    echo "<script>alert('Erro técnico: Não é possível deletar este usuário pois ele possui registros vinculados ao sistema.'); window.history.back();</script>";
}
?>