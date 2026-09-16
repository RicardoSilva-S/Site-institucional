<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; background: #f0f2f5; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; max-width: 600px; margin: 0 auto; }
        h1 { color: #333; margin-bottom: 1rem; }
        a { color: #1a56db; }
    </style>
</head>
<body>
    <div class="card">
        <h1>✅ Bem-vindo ao painel, <?= htmlspecialchars($usuario ?? 'Admin') ?>!</h1>
        <p>Backend MVC funcionando com login e sessão.</p>
        <br>
        <a href="/Site-institucional/public/admin/sair">Sair</a>
    </div>
</body>
</html>