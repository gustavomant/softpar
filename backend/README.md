# SOFTPAR BACKEND

## Versões de Software
- PHP: 8.4.1
- Laravel: 11.31

## Rotas da Aplicação

### POST /signup
**Registro de usuário**
Retorna um `access_token`.

#### Payload:
```json
{
  "name": "Jane Doe",
  "email": "janedoe@example.com",
  "password": "securepassword"
}
```

#### Retorno:
```json
{
  "access_token": "1|Abc123Xyz456",
  "token_type": "Bearer",
  "user": {
    "name": "Jane",
    "email": "janedoe@example.com",
    "updated_at": "2025-01-01T12:00:00.000000Z",
    "created_at": "2025-01-01T12:00:00.000000Z",
    "id": 1
  }
}
```

### POST /signin
**Login**
Retorna um `access_token`.

#### Payload:
```json
{
  "email": "janedoe@example.com",
  "password": "securepassword"
}
```

#### Retorno:
```json
{
  "access_token": "1|Def456Ghi789",
  "token_type": "Bearer",
  "user": {
    "name": "Jane",
    "email": "janedoe@example.com",
    "updated_at": "2025-01-01T12:00:00.000000Z",
    "created_at": "2025-01-01T12:00:00.000000Z",
    "id": 1
  }
}
```

### GET /task
**Retorna todas as tasks do usuário.**

#### Header:
```
Authorization: Bearer $token
```

#### Retorno:
```json
[
  {
    "id": 1,
    "title": "Sample Task 1",
    "subtitle": "Subtitle 1",
    "description": "Description 1",
    "status": "pending",
    "due_date": "2025-12-31",
    "created_by_user_id": 1,
    "created_at": "2025-01-01T12:00:00.000000Z",
    "updated_at": "2025-01-01T13:00:00.000000Z"
  },
  {
    "id": 2,
    "title": "Sample Task 2",
    "subtitle": "Subtitle 2",
    "description": "Description 2",
    "status": "pending",
    "due_date": "2025-12-31",
    "created_by_user_id": 1,
    "created_at": "2025-01-01T12:00:00.000000Z",
    "updated_at": "2025-01-01T13:00:00.000000Z"
  }
]
```

### GET /task/{taskId}
**Retorna os detalhes de uma task.**

#### Header:
```
Authorization: Bearer $token
```

#### Retorno:
```json
{
  "id": 1,
  "title": "Sample Task 1",
  "subtitle": "Subtitle 1",
  "description": "Description 1",
  "status": "pending",
  "due_date": "2025-12-31",
  "created_by_user_id": 1,
  "created_at": "2025-01-01T12:00:00.000000Z",
  "updated_at": "2025-01-01T13:00:00.000000Z"
}
```

### POST /task
**Salva uma task.**

#### Payload:
```json
{
  "title": "New Task",
  "subtitle": "Task Subtitle",
  "description": "Task Description",
  "due_date": "2025-01-31"
}
```

#### Header:
```
Authorization: Bearer $token
```

#### Retorno:
```json
{
  "title": "New Task",
  "subtitle": "Task Subtitle",
  "description": "Task Description",
  "due_date": "2025-01-31"
}
```

### PUT /task
**Modifica uma task (título, subtítulo, descrição ou status).**

#### Payload:
```json
{
  "task_id": 1,
  "title": "Updated Task",
  "subtitle": "Updated Subtitle",
  "description": "Updated Description",
  "due_date": "2025-02-01",
  "status": "done"
}
```

#### Header:
```
Authorization: Bearer $token
```

#### Retorno:
```json
{
  "title": "Updated Task",
  "subtitle": "Updated Subtitle",
  "description": "Updated Description",
  "due_date": "2025-02-01"
}
```

### POST /subtask
**Cria uma subtask vinculada a uma task principal.**

#### Payload:
```json
{
  "title": "New Subtask",
  "subtitle": "Subtask Subtitle",
  "description": "Subtask Description",
  "task_id": 1
}
```

#### Header:
```
Authorization: Bearer $token
```

#### Retorno:
```json
{
  "title": "New Subtask",
  "subtitle": "Subtask Subtitle",
  "description": "Subtask Description",
  "task_id": 1
}
```

### PUT /subtask
**Modifica o estado de uma subtask.**

#### Payload:
```json
{
  "subtask_id": 1,
  "title": "Updated Subtask",
  "subtitle": "Updated Subtitle",
  "description": "Updated Description",
  "status": "done"
}
```

#### Header:
```
Authorization: Bearer $token
```

#### Retorno:
```json
{
  "title": "Updated Subtask",
  "subtitle": "Updated Subtitle",
  "description": "Updated Description",
  "task_id": 1
}
```

### POST /user-task-access
**Cria uma permissão para um usuário acessar uma task (modo leitura ou escrita).**

#### Payload:
```json
{
  "task_id": 1,
  "user_id": 2,
  "access_type": "read"
}
```

#### Header:
```
Authorization: Bearer $token
```

#### Retorno:
```json
{
  "task_id": 1,
  "user_id": 2,
  "access_type": "read",
  "updated_at": "2025-01-01T12:00:00.000000Z",
  "created_at": "2025-01-01T12:00:00.000000Z",
  "id": 1
}
```

---

**Nota:** Não foi adicionado um endpoint de delete para os recursos task e subtask, pois a coluna `status` (enum) suporta o valor `REMOVED`. Quando este valor está setado, o recurso não aparece em consultas.

A aplicação utiliza uma camada de serviços para interagir com a ORM do Laravel. Policies e gateways são aplicados em trechos críticos do código para garantir que usuários não acessem recursos indevidos.
