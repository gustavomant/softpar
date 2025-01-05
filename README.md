# Softpar

## Descrição Geral

O projeto **Softpar** é composto por três módulos principais, cada um contendo um arquivo README com explicações detalhadas sobre seu funcionamento:

- **Backend**: Gerencia as regras de negócio e a API do sistema.
- **Frontend**: Interface do usuário desenvolvida com Quasar Framework.
- **Step_1_Database**: Contém documentação sobre o banco de dados.

---

## Requisitos de Instalação

Certifique-se de ter as seguintes ferramentas instaladas:

- **Docker**: v27.4.x
- **Docker Compose**: v1.29.x

---

## Instruções para Build do Projeto

Siga os passos abaixo para configurar e iniciar o projeto:

1. Copie o arquivo de configuração padrão do backend:
   ```bash
   cp backend/.env.example backend/.env
   ```

2. Execute o build e inicie os serviços com Docker Compose:
   ```bash
   docker-compose up --build -d
   ```
Após a execução dos comandos acima, acesse o projeto no seu navegador através do localhost:9000.

Atenção: Pode demorar um pouco até todos os serviços iniciarem corretamente. Durante o processo de inicialização, é possível que ocorra um erro de "cross-origin" (CORS), especialmente antes do serviço de rede estar totalmente funcional. Caso isso aconteça, aguarde alguns minutos e tente novamente. Eventualmente, o acesso será liberado.

---



Para mais detalhes, consulte os arquivos README individuais em cada módulo. Caso tenha dúvidas, entre em contato com a equipe de desenvolvimento.

