# Banco de dados: Projetos

As tabelas da página **Projetos** do site. A origem é a "Tabela de Projetos"
passada pelo professor.

## Duas formas de criar as tabelas

**Com o Laravel (o caminho normal).** `php artisan migrate` cria tudo, inclusive
estas tabelas. Elas vêm destas migrations:

| Migration | O que faz |
|---|---|
| `2026_10_15_120000_create_projetos_table` | Cria `projetos`. |
| `2026_10_15_130000_add_problema_to_projetos_table` | Acrescenta a coluna `problema`. |
| `2026_10_15_130100_create_descricao_projetos_table` | Cria `descricao_projetos`. |

**Sem o Laravel.** Use `sql/idtnpr_projetos_mysql.sql`, que cria as mesmas duas
tabelas direto no MySQL. Não misture as duas formas no mesmo banco. Se uma
migration mudar, o `.sql` precisa ser atualizado.

## Rodar o `.sql` (sem o Laravel)

- Use um MySQL ou MariaDB **local**. Não rode este arquivo no banco remoto
  (DBaaS) sem o grupo liberar.
- O script não escolhe o banco (não tem `CREATE DATABASE` nem `USE`). Ele cria
  as tabelas no banco que você indicar no comando.
- Pode rodar mais de uma vez: se as tabelas já existem, não dá erro.

Abra o terminal na pasta do projeto. Se o comando `mysql` não for reconhecido,
use o caminho completo. No XAMPP é `C:/xampp/mysql/bin/mysql.exe`.

1. Ligue o banco local. No XAMPP, clique em **Start** no MySQL.

2. Crie o banco (só na primeira vez):

```bash
mysql -h 127.0.0.1 -u root -e "CREATE DATABASE IF NOT EXISTS site_institucional CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

3. Crie as tabelas:

```bash
mysql -h 127.0.0.1 -u root site_institucional -e "source sql/idtnpr_projetos_mysql.sql"
```

Se o seu `root` tiver senha, acrescente `-p` ao comando.

### Pelo MySQL Workbench

1. Abra a conexão com o banco local (host `127.0.0.1`, porta `3306`, usuário `root`).
2. No painel **Schemas**, clique com o botão direito em `site_institucional` e escolha **Set as Default Schema**.
3. Menu **File > Open SQL Script** e escolha `sql/idtnpr_projetos_mysql.sql`.
4. Clique no raio para executar.

### Conferir se deu certo

```sql
SHOW TABLES;
DESCRIBE projetos;
DESCRIBE descricao_projetos;
```

## Como as tabelas se relacionam

Um projeto tem vários blocos de descrição (cada bloco é um título e um texto).
`descricao_projetos.projeto_id` aponta para `projetos.id`, e apagar um projeto
apaga os blocos dele (`ON DELETE CASCADE`).

- `IdProjeto`, da tabela do professor, virou `projeto_id`.
- `projetos` já era usada pela página `/projetos` e pelo painel, por isso tem
  também `tecnologia`, `link_rotulo`, `link_destino` e `ordem`.
- `estagio` guarda `implementado`, `expansao`, `consultoria`, `piloto` ou
  `desenvolvimento` (padrão).
- `problema` é opcional, porque já existem projetos cadastrados e o painel
  ainda não preenche esse campo.
- As duas tabelas têm `created_at` e `updated_at`, que é o padrão do Laravel.

## Recomeçar do zero (só no banco local, sem o Laravel)

Isto apaga as tabelas e todos os dados delas:

```sql
DROP TABLE IF EXISTS descricao_projetos;
DROP TABLE IF EXISTS projetos;
```

## Pendente

O painel e a página `/projetos` ainda não usam `problema` nem
`descricao_projetos`. Falta o grupo decidir como isso aparece no site.
