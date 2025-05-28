# 📘 Documentação Técnica - Sistema de Contatos com WhatsApp (PHP + MySQL)

Este projeto é um sistema completo para cadastro, listagem, edição e envio de mensagens via WhatsApp. Utiliza PHP moderno com PDO, banco de dados MySQL, estrutura MVC simplificada e interface responsiva com Bootstrap 5. Ele permite ao usuário gerenciar contatos com filtros avançados, paginação e ações rápidas.

---

## 📁 Estrutura Geral do Projeto

```plaintext
raiz-do-projeto/
├── config/
│   └── database2.php              # Conexão com o banco de dados
│
├── controller/
│   ├── ContatoController.php      # Lógica de salvar e excluir contatos
│   └── excluir.php                # Script para exclusão com confirmação
│
├── model/
│   └── Contato.php                # Classe com métodos de banco (CRUD, filtros)
│
├── public/
│   ├── css/
│   │   ├── style.css              # Estilo base e formulário
│   │   └── list.css               # Estilo para a listagem
│   └── js/
│       ├── main.js                # Máscara, validação e WhatsApp
│       └── list.js                # Scripts adicionais
│
├── utils/
│   └── funcoes.php                # Funções auxiliares (formatação de datas etc)
│
├── view/
│   ├── form.php                   # Formulário principal de envio
│   ├── adicionar_contato.php      # Tela para novo contato
│   └── editar_contato.php         # Tela de edição com carregamento dos dados
│
├── list.php                       # Lista de todos os contatos (sem filtros)
├── lista_contatos.php             # Lista com filtros e paginação
└── index.php                      # Página inicial ou dashboard
````

---

## ✅ Funcionalidades

### 📥 Cadastro e Validação

* Validação de campos obrigatórios
* Máscara para telefone (formato brasileiro com DDD)
* Limite de 300 caracteres para mensagem
* Prevenção de envio acidental com Enter
* Feedback visual com SweetAlert2

### 🔍 Filtros e Paginação

* Filtro por nome, telefone, mensagem, data de início/fim
* Paginação com 15 contatos por página, mantendo filtros via GET

### ✏️ Ações em Contatos

* Editar, Excluir com confirmação, Enviar via WhatsApp
* Link dinâmico via API `https://wa.me/`
* Botões com ícones (Font Awesome) para ações rápidas

### 📦 Armazenamento (Banco de Dados)

Tabela `contatos`:

| Campo      | Tipo         | Descrição             |
| ---------- | ------------ | --------------------- |
| id         | INT (PK)     | Identificador único   |
| nome       | VARCHAR(100) | Nome do contato       |
| telefone   | VARCHAR(20)  | Número de telefone    |
| mensagem   | TEXT         | Mensagem do contato   |
| data\_hora | DATETIME     | Data/hora do cadastro |
| data\_update | DATETIME     | Data/hora da edição |

---

## 🧠 Lógica do Backend

### 🔌 Conexão ao Banco

```php
$db = (new Database())->getConnection();
```

### 🔄 Filtros Dinâmicos

```php
if ($nome !== '') {
    $filtros[] = "nome LIKE :nome";
    $params[':nome'] = "%$nome%";
}
```

### 📊 Paginação

```php
$offset = ($pagina_atual - 1) * $limite_por_pagina;
$sql = "SELECT * FROM contatos $where ORDER BY id DESC LIMIT :limite OFFSET :offset";
```

### 🧮 Contagem Total

```php
$sql_count = "SELECT COUNT(*) FROM contatos $where";
```

---

## 🧩 Tecnologias Utilizadas

* **PHP 8+**
* **MySQL**
* **PDO (PHP Data Objects)**
* **Bootstrap 5.3.3**
* **Font Awesome 6**
* **SweetAlert2**
* **jQuery (opcional)**
* **HTML5 / CSS3**

---

## 🎨 Interface do Usuário

* Interface responsiva para dispositivos móveis
* Ações com ícones intuitivos
* Mensagens interativas com SweetAlert2
* Layout moderno com Bootstrap

---

## 🔒 Segurança

* Uso de `Prepared Statements` com PDO
* Validação de entrada e sanitização com `htmlspecialchars()`
* Confirmação visual antes de exclusões

---

## 📸 Exemplo de URL com Filtros

```url
lista_contatos.php?nome=joao&data_inicio=2024-01-01&pagina=2
```

---

## 🔮 Melhorias Futuras

* Autenticação (login/admin)
* Exportação de contatos (CSV, Excel)
* Busca em tempo real com AJAX
* Validação de formulários no frontend
* Integração com WhatsApp Business API
* Painel de administração com relatórios
* Log de alterações por contato
* Notificações por e-mail

---

## 🌐 Dependências Externas

* [Bootstrap 5.3.3](https://getbootstrap.com/)
* [Font Awesome 6.4](https://fontawesome.com/)
* [SweetAlert2](https://sweetalert2.github.io/)
* [jQuery](https://jquery.com/)

---

