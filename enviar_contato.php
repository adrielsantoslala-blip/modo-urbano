<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $mensagem = trim($_POST["mensagem"] ?? "");

    if (!empty($nome) && !empty($email) && !empty($mensagem)) {
        try {
            $stmt = $conexao->prepare("INSERT INTO mensagens_contato (nome, email, mensagem) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $mensagem]);
            header("Location: contato.html?status=sucesso");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao enviar: " . $e->getMessage();
        }
    } else {
        echo "Preencha todos os campos!";
    }
}
?>