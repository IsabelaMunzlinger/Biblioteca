# 📚 Lizard Books - Gestão de Biblioteca

Sistema focado no gerenciamento completo de uma biblioteca, integrando controle de acervo, usuários e regras de negócio para empréstimos.

## 📋 Entidades do Sistema
O projeto foi estruturado com base em 4 entidades principais:
*   **Livros:** Controle de títulos, autores, estoque e capas.
*   **Leitores:** Cadastro de usuários com validação de identidade.
*   **Empréstimos:** Gestão de transações e prazos entre leitores e livros.
*   **Endereços:** Dados de localização vinculados aos leitores.

## ⚖️ Regras de Negócio

*   **Limite de Empréstimos:** Um leitor pode possuir, no máximo, **3 exemplares ativos** simultaneamente.
*   **Integridade Referencial (Leitores):** Bloqueio de exclusão para leitores com empréstimos pendentes.
*   **Integridade Referencial (Livros):** Bloqueio de exclusão para livros com histórico de movimentação (utiliza-se a função de **Inativar** para remover de circulação).
*   **Validação de Identidade:** Cadastro impedido em caso de **CPF duplicado**.
*   **Campos Obrigatórios:** Validação no backend para impedir registros incompletos.
*   **Filtro de Exibição:** Apenas livros **Ativos** e com **Estoque** disponível aparecem para novos empréstimos e no carrossel da Home.

## 🛠️ Requisitos
*   **Git**
*   **Docker Desktop** (em execução)
*   **Editor de Código** (Recomendado: VS Code)

## 🚀 Como Executar o Projeto

1. **Clonar o repositório:**
   ```bash
   git clone <URL_DO_REPOSITORIO>
   cd <PASTA_DO_PROJETO>

2. Criar o arquivo de ambiente
  ```bash
  cp .env.example .env
  ```

3. Configurar o arquivo .env
Abra o arquivo .env na raiz do seu projeto e ajuste as credenciais do banco de dados. Isso é essencial para que o Laravel consiga se comunicar com o container do MySQL:
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=lizard_books
    DB_USERNAME=root
    DB_PASSWORD=password
  
4. Subir os Containers
Utilize o Docker Compose para construir e iniciar o ambiente:
  ```bash
    docker compose up -d --build
 ```

5. Finalizar Configuração do Laravel
Com os containers rodando, execute os comandos internos para instalar dependências e preparar o banco de dados:
  ```bash
# 1. Instalar as dependências do PHP (Composer)
docker compose exec app composer install

# 2. Gerar a chave única da aplicação
docker compose exec app php artisan key:generate

# 3. Rodar as migrações para criar as tabelas no banco
docker compose exec app php artisan migrate

# 4. Criar o link simbólico para as capas dos livros funcionarem
docker compose exec app php artisan storage:link


