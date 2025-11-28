# 🍽️ Quiosque Barramares: Sistema de Cardápio Digital

Este é um sistema completo de cardápio digital para quiosques ou restaurantes, desenvolvido como projeto universitário. O sistema permite que clientes naveguem pelo menu, façam pedidos em tempo real (identificando a mesa) e que o administrador gerencie os pratos e pedidos de forma segura.

## ✨ Funcionalidades Destaque

* **Menu Dinâmico:** Exibe os pratos puxados diretamente do banco de dados (menu.php).
* **Carrinho em Tempo Real:** Adição de itens, cálculo de subtotal, taxa de serviço (10%) e total usando JavaScript.
* **Identificação de Mesa:** O cliente informa o número da mesa via *prompt* na finalização do pedido.
* **Finalização Segura:** O pedido completo (itens, quantidades, totais e mesa) é salvo na base de dados via `fetch` (finalizar_pedido.php).
* **Painel de Administração (CRUD):** Acesso protegido para gerenciar o cardápio.
    * **Login Seguro:** Usa `password_verify` para autenticação (admin/login.php).
    * **Gerenciamento de Pratos:** Permite Adicionar (com upload de imagem), Editar e Apagar pratos (edit.php, delete.php).

## 💻 Tecnologia Utilizada

* **Backend:** PHP (Com Statements Preparados MySQLi)
* **Banco de Dados:** MySQL (`cardapio_db`)
* **Frontend:** HTML5, CSS3, JavaScript
* **Framework:** Bootstrap 5.3.x

## 🛠️ Guia de Instalação (Setup)

### 1. Preparação do Servidor

1.  Instale e inicie o **XAMPP** (ou WAMP).
2.  Copie toda a pasta do projeto (`MenuSystem`) para o diretório `htdocs` (ou `www`).

### 2. Configuração do Banco de Dados

Acesse o phpMyAdmin (`http://localhost/phpmyadmin`), crie o banco de dados chamado **`cardapio_db`** e execute o seguinte código SQL para criar as tabelas essenciais:

```sql
-- Tabela de Pratos (Itens do Cardápio)
CREATE TABLE pratos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10, 2) NOT NULL,
  imagem VARCHAR(255)
);

-- Tabela de Pedidos (Rastreia cada transação)
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mesa INT NOT NULL, /* Coluna para identificar a mesa */
  valor_subtotal DECIMAL(10, 2) NOT NULL,
  valor_taxa DECIMAL(10, 2) NOT NULL,
  valor_total DECIMAL(10, 2) NOT NULL,
  data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Itens de cada Pedido
CREATE TABLE pedido_itens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_pedido INT NOT NULL,
  nome_produto VARCHAR(255) NOT NULL,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (id_pedido) REFERENCES pedidos(id)
);

-- Tabela de Usuários Admin
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

```

## Criando o Primeiro Admin
Para poder acessar o Painel Admin, você deve inserir um usuário na tabela admins. Use um gerador de password_hash para criar o hash da sua senha.
````
-- Exemplo: Usuário 'admin' com Senha 'minhasenha123'
-- Insira aqui o hash da sua senha:
INSERT INTO admins (username, password_hash) VALUES 
('admin', '$2y$10$seu_hash_de_senha_aqui_para_a_senha_escolhida');
````
Acesso ao Sistema
   
Menu do Cliente: http://localhost/MenuSystem/
Painel Admin: http://localhost/MenuSystem/admin/login.php
