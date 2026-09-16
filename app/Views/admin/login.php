<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel — Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; width: 100%; max-width: 380px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { font-size: 1.3rem; margin-bottom: 1.5rem; color: #333; }
        label { display: block; font-size: .875rem; color: #555; margin-bottom: .25rem; }
        input { width: 100%; padding: .6rem .75rem; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; margin-bottom: 1rem; }
        button { width: 100%; padding: .75rem; background: #1a56db; color: #fff; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #1648c0; }
        .erro { background: #fee2e2; color: #b91c1c; padding: .6rem .75rem; border-radius: 4px; margin-bottom: 1rem; font-size: .875rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Painel Administrativo</h1>

        <?php if (!empty($erro)): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="/Site-institucional/public/admin/login">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf ?? '') ?>">

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required autofocus>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
