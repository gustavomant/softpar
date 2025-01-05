# Softpar Frontend

## Versões dos Softwares

- **Node.js**: 22.0.0
- **Yarn**: 1.22.2
- **Quasar CLI**: 2.4.1

## Estrutura de Páginas

### **Home** `/`
Exibe uma lista de tarefas cadastradas no sistema. Nesta página, o usuário pode visualizar todas as tarefas disponíveis.

### **Detalhes da Tarefa** `/{id}`
Exibe os detalhes de uma tarefa específica. A página é dividida em quatro seções principais:

1. **Dados da Tarefa**
   - Exibe as informações detalhadas da tarefa.
   - Permite a edição de campos relacionados à tarefa.

2. **Adicionar Usuário**
   - Permite adicionar usuários com diferentes níveis de permissão:
     - **Leitura**: Apenas visualiza a tarefa.
     - **Escrita**: Pode editar a tarefa (também inclui permissão de leitura).

3. **Listagem de Subtarefas**
   - Exibe todas as subtarefas associadas à tarefa principal.
   - Funções disponíveis:
     - Marcar subtarefas como concluídas.
     - Excluir subtarefas.

4. **Adicionar Subtarefas**
   - Permite criar novas subtarefas vinculadas à tarefa principal.

### **Login** `/login`
Página de autenticação para usuários registrados acessarem o sistema.

### **Registro** `/register`
Página para novos usuários se registrarem no sistema.
