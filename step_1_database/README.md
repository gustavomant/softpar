# Step 1: Database

Este projeto inclui suporte para colaboração múltipla de usuários e a criação de subtarefas. A seguir, estão descritas as tabelas e relações do banco de dados utilizadas.

## Tabelas do Banco de Dados

### `users`
- **name**: Nome do usuário.
- **email**: Endereço de e-mail único.
- **password**: Senha do usuário.

A autenticação e os tokens são gerenciados pelo Laravel com a biblioteca `laravel-sanctum`. A tabela `personal_access_tokens` é criada automaticamente e pode ser encontrada nas migrations do backend.

### `tasks`
- **title**: Título da tarefa.
- **subtitle**: Subtítulo da tarefa.
- **description**: Descrição da tarefa.
- **status**: Enum (`pending`, `done`, `removed`).
- **due_date**: Data de vencimento.
- **created_by_user_id**: Foreign key que referencia a coluna `id` da tabela `users`.

### `user_task_accesses`
Esta tabela controla quais usuários têm permissão para manipular uma tarefa e suas subtarefas.
- **user_id**: Referencia o usuário.
- **task_id**: Referencia a tarefa.
- **access_type**: Enum (`read`, `write`).

### `subtasks`
Semelhante à tabela `tasks`, mas com algumas diferenças:
- **title**: Título da subtarefa.
- **subtitle**: Subtítulo da subtarefa.
- **description**: Descrição da subtarefa.
- **status**: Enum (`pending`, `done`, `removed`).
- **created_by_user_id**: Foreign key que referencia a coluna `id` da tabela `users`.
- **task_id**: Foreign key que referencia a tarefa principal na tabela `tasks`.

> Observação: A subtarefa não possui o campo `due_date`, pois a data de vencimento já é gerenciada pela tarefa principal. Essa decisão simplifica o design, mas é possível adicionar o campo futuramente, caso necessário.

## Relações do Banco de Dados

- **Usuário → Tarefa** (`created_by_user_id`): Relacionamento de um para muitos.
- **Usuário → Subtarefa** (`created_by_user_id`): Relacionamento de um para muitos.
- **Tarefa → Subtarefa** (`task_id`): Relacionamento de um para muitos.
- **Usuário → Tarefa** (via `user_task_accesses`): Relacionamento de muitos para muitos.

## Regras de Permissão

Sempre que um usuário tenta ler ou alterar uma tarefa/subtarefa, é verificado se existe um registro na tabela `user_task_accesses` que contenha o ID do usuário e o ID da tarefa correspondente. No caso das subtarefas, verifica-se a chave estrangeira `task_id`.

## Decisões de Design

- Diferenciei as tabelas `tasks` e `subtasks` para evitar confusões. A subtarefa não possui o atributo `due_date`, já que essa informação é gerenciada pela tarefa principal.
- Poderia ter sido utilizada uma única tabela (`tasks`) com um campo `parent_id` nullable para indicar relações hierárquicas. No entanto, prefiro evitar foreign keys nulas, optando por um design mais explícito e simples.

Esse design simples expressa claramente as regras de permissão e facilita sua implementação no backend por meio de policies e gates.

