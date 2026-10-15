<?php
require_once "conexao.php";

// EXCLUIR MENSAGEM
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $stmt = $conexao->prepare("DELETE FROM mensagens_contato WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

// ATUALIZAR MENSAGEM (EDITAR)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar_id'])) {
    $id = intval($_POST['editar_id']);
    $mensagem = trim($_POST['mensagem']);
    $stmt = $conexao->prepare("UPDATE mensagens_contato SET mensagem = ? WHERE id = ?");
    $stmt->execute([$mensagem, $id]);
    header("Location: admin.php");
    exit;
}

// LISTAR MENSAGENS
$stmt = $conexao->prepare("SELECT * FROM mensagens_contato ORDER BY data_envio DESC");
$stmt->execute();
$mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin — Modo Urbano</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.html" class="logo">MODO <span>URBANO</span></a>
        <nav>
            <a href="index.html">Início</a>
            <a href="produtos.html">Produtos</a>
            <a href="contato.html">Contato</a>
            <a href="admin.php"><b>Painel Admin</b></a>
        </nav>
    </header>

    <main class="page">
        <section class="section-title">
            <p class="eyebrow">PAINEL ADMINISTRATIVO</p>
            <h1>Gerenciar Mensagens (CRUD)</h1>
        </section>

        <div style="max-width:800px; margin:auto;">
            <?php if (empty($mensagens)): ?>
                <p style="text-align:center;">Nenhuma mensagem cadastrada no banco.</p>
            <?php else: ?>
                <?php foreach ($mensagens as $msg): ?>
                    <div style="background:white; border:1px solid #cbd5e1; padding:20px; border-radius:8px; margin-bottom:15px;">
                        <p><strong>Nome:</strong> <?= htmlspecialchars($msg['nome']) ?> (<?= htmlspecialchars($msg['email']) ?>)</p>
                        <p style="font-size:12px; color:#64748b; margin-bottom:10px;">Data: <?= $msg['data_envio'] ?></p>
                        
                        <form method="POST" style="margin-bottom:10px;">
                            <input type="hidden" name="editar_id" value="<?= $msg['id'] ?>">
                            <textarea name="mensagem" style="width:100%; padding:8px;" rows="3" required><?= htmlspecialchars($msg['mensagem']) ?></textarea>
                            <button type="submit" class="btn" style="padding:6px 12px; font-size:12px; margin-top:5px;">Salvar Edição</button>
                        </form>

                        <a href="admin.php?excluir=<?= $msg['id'] ?>" onclick="return confirm('Deseja excluir?')" style="color:#e63946; font-weight:bold; font-size:13px;">[ Excluir Mensagem ]</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer><p>© 2026 Modo Urbano</p></footer>
</body>
</html>