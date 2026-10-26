# Deploy no servidor do professor

Site: http://systemluz.com.br/idtnpr/ · painel: http://systemluz.com.br/idtnpr/login-adm

## Como o servidor funciona

- **nginx + PHP 8.3** (FPM). O nginx **não lê `.htaccess`**: regras de URL ficam no vhost, que é com o professor.
- O FTP já cai **dentro da pasta pública** (`/idtnpr`). Não existe pasta "por fora" para guardar o código.
- Usuário do FTP é **todo em minúsculas** (com maiúsculas dá `530 Login incorrect`). Usuário e senha: pedir pro grupo, **nunca** colocar no Git.

Por isso o pacote fica assim:

```
/idtnpr/              <- raiz do FTP (pública)
  index.php           <- aponta pra laravel/
  css/ js/ assets/ favicon.ico ...
  laravel/            <- resto do projeto, bloqueado no nginx (403)
    app/ config/ vendor/ storage/ .env ...
```

## Regras do nginx (já aplicadas pelo professor)

```nginx
location /idtnpr/ {
    try_files $uri $uri/ /idtnpr/index.php?$query_string;
}

location ^~ /idtnpr/laravel/ {
    deny all;
}
```

A primeira faz as URLs amigáveis funcionarem (`/idtnpr/contato`, `/idtnpr/adm`...). A segunda bloqueia o acesso pelo navegador à pasta do código, onde fica o `.env` com a senha do banco.

## Subir uma versão nova

1. `main` atualizada e testes passando.
2. Montar o pacote (precisa do Docker aberto):
   ```bash
   sh scripts/montar-pacote-servidor.sh
   ```
   Sai em `../deploy-idtnpr/site`.
3. **Primeira vez:** preencher `DB_PASSWORD` em `site/laravel/.env`.
   **Atualizações:** não mandar o `.env` de novo (o do servidor já está certo e a `APP_KEY` dele não deve mudar).
4. Enviar por FTP. Com o `lftp` (sem instalar nada):
   ```bash
   docker run --rm -it -v "$PWD/../deploy-idtnpr":/d alpine sh -c "apk add -q lftp && lftp -e 'set ssl:verify-certificate no; mirror -R --parallel=6 --exclude laravel/.env /d/site/ ./; bye' -u USUARIO_FTP 108.174.151.237"
   ```
   O `mirror -R` só manda o que mudou.
5. Migrations novas: o servidor não tem terminal, então rodar a partir de um computador que alcance o MySQL, ou passar o SQL pra equipe de banco.

## Banco

O site precisa das tabelas das migrations (`database/migrations`). Sem elas todas as páginas dão erro 500, porque a sessão fica na tabela `sessions`.

## Versões

- **PHP 8.3** no servidor; `config.platform.php` do `composer.json` travado em 8.3.35.
- **Laravel 8**, mantido de propósito (atualizar o framework mudaria muita coisa).

### Alertas de segurança conhecidos do Laravel 8

O Laravel 8 não recebe mais correções desde 2023. Os alertas abaixo só foram corrigidos no Laravel 12 ou 13:

| Alerta | Situação no site |
|---|---|
| CRLF injection na regra `email` | **Tratado**: contato, ouvidoria e usuários recusam `\r` e `\n` no e-mail |
| Burla na validação de arquivo enviado | Baixo risco: só usuário logado no painel envia arquivo |
| XSS na página de debug | Não se aplica: `APP_DEBUG=false` em produção |
| Login por token de API (TokenGuard) | Não se aplica: o site não usa |
| URL assinada temporária | Não se aplica: o site não usa |
| Flysystem: normalização de caminho | Não se aplica: nenhum caminho de arquivo vem do usuário |

Para ver a lista atualizada: `composer audit`. Atualizar para o Laravel 12 resolve todos, mas é uma tarefa grande à parte.
