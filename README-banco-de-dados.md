# Banco de dados: Projetos

As tabelas da página **Projetos** do site, em MySQL. A origem é a "Tabela de
Projetos" passada pelo professor.

## Arquivo

| Arquivo | O que faz |
|---|---|
| `idtnpr_projetos_mysql.sql` | Cria as tabelas `projetos` e `descricao_projetos`. |

## Antes de começar

- Use um MySQL ou MariaDB **local**. Não rode este arquivo no banco remoto
  (DBaaS) sem o grupo liberar.
- O script não escolhe o banco (não tem `CREATE DATABASE` nem `USE`). Ele cria
  as tabelas no banco que você indicar no comando.
- Pode rodar mais de uma vez: se as tabelas já existem, não dá erro.

## Passo a passo (linha de comando)

Abra o terminal na pasta do projeto, onde está o arquivo `.sql`. Se o comando
`mysql` não for reconhecido, use o caminho completo. No XAMPP é
`C:/xampp/mysql/bin/mysql.exe`.

1. Ligue o banco local. No XAMPP, clique em **Start** no MySQL.

2. Crie o banco (só na primeira vez):

```bash
mysql -h 127.0.0.1 -u root -e "CREATE DATABASE IF NOT EXISTS site_institucional CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

3. Crie as tabelas:

```bash
mysql -h 127.0.0.1 -u root site_institucional -e "source idtnpr_projetos_mysql.sql"
```

Se o seu `root` tiver senha, acrescente `-p` ao comando.

## Pelo MySQL Workbench

1. Abra a conexão com o banco local (host `127.0.0.1`, porta `3306`, usuário `root`).
2. No painel **Schemas**, clique com o botão direito em `site_institucional` e escolha **Set as Default Schema**.
3. Menu **File > Open SQL Script** e escolha `idtnpr_projetos_mysql.sql`.
4. Clique no raio para executar.

## Conferir se deu certo

```sql
SHOW TABLES;
DESCRIBE projetos;
DESCRIBE descricao_projetos;
```

O esperado é ver as duas tabelas. Elas começam vazias, porque o script só cria
a estrutura.

## Como as tabelas se relacionam

Um projeto tem vários blocos de descrição (cada bloco é um título e um texto).
`descricao_projetos.projeto_id` aponta para `projetos.id`, e apagar um projeto
apaga os blocos dele (`ON DELETE CASCADE`).

- `IdProjeto`, da tabela do professor, virou `projeto_id`.
- `estagio` guarda `disponivel` ou `em_desenvolvimento` (padrão).
- As duas tabelas têm `created_at` e `updated_at`, que é o padrão do Laravel.

## Recomeçar do zero (só no banco local)

Isto apaga as tabelas e todos os dados delas:

```sql
DROP TABLE IF EXISTS descricao_projetos;
DROP TABLE IF EXISTS projetos;
```

## Para o grupo combinar

- O deploy no Render só cria tabelas por migration (`php artisan migrate`), então
  este `.sql` não roda lá. Quem ligar as tabelas ao site vai precisar de uma
  migration equivalente.
- Este script é MySQL. O `render.yaml` hoje aponta para PostgreSQL, então
  falta combinar qual banco será o de produção.
- O site mostra também "Para quem", "Desenvolvimento/Execução" e "Caminho de
  contratação" em cada projeto. Essas informações não têm coluna nas duas
  tabelas do professor, e o grupo precisa decidir onde guardar.
