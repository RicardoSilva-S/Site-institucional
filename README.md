# Site Institucional — Backend MVC PHP 7.4

Estrutura MVC manual em PHP 7.4 com PDO + MySQL.

## Estrutura de pastas

```
site-institucional/
├── app/
│   ├── Controllers/   # Lógica de cada página
│   ├── Core/          # Router, Request, Database, Sessao, Autoload
│   ├── Models/        # Acesso ao banco via PDO
│   └── Views/         # HTML das páginas
├── config/
│   └── database.php   # Configuração do banco (lê do .env)
├── public/
│   ├── index.php      # Front controller — tudo passa por aqui
│   └── .htaccess      # Redireciona URLs pro index.php
├── routes/
│   └── web.php        # Definição de todas as rotas
└── .env               # Credenciais (não commitar!)
```

## Como rodar localmente

1. Clone o repositório
2. Copie `.env.example` para `.env` e preencha com seus dados
3. Importe o SQL do banco (pasta `database/`)
4. Aponte o servidor web (XAMPP/Laragon) para a pasta `public/`
5. Acesse `http://localhost/`

## Requisitos

- PHP 7.4
- MySQL 8 / MariaDB
- Apache com mod_rewrite ativo (XAMPP já tem)

## Painel admin (teste)

- URL: `/admin/login`
- E-mail: `admin@site.com`
- Senha: `admin123`

> ⚠️ Usuário de teste fixo no código. Substituir pelo Model\Usuario após o banco estar pronto.
