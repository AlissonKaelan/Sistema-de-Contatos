# 📒 Sistema de Contatos com WhatsApp

Este projeto é um sistema web para cadastro, listagem, edição e envio de mensagens via WhatsApp, desenvolvido em PHP com PDO e MySQL. Possui interface responsiva com Bootstrap 5, arquitetura MVC simplificada e recursos de usabilidade como filtros, paginação e alertas visuais.

---

## 📁 Estrutura de Pastas

```
Sistema-de-Contatos/
├── config/
│   └── database.php
├── controller/
│   ├── ContatoController.php
│   └── excluir.php
├── model/
│   └── Contato.php
├── public/
│   ├── css/
│   │   ├── list.css
│   │   └── style.css
│   └── js/
│       ├── list.js
│       └── main.js
├── utils/
│   └── funcoes.php
├── view/
│   ├── adicionar_contato.php
│   ├── editar_contato.php
│   ├── index.php
│   └── list.php
├── composer.json
├── composer.lock
├── .gitignore
└── README.md
```

---

## ✅ Funcionalidades

- Cadastro, edição e exclusão de contatos
- Máscara e validação de telefone brasileiro
- Filtros avançados por nome, telefone, mensagem e datas
- Paginação de resultados
- Envio rápido de mensagem via WhatsApp Web
- Alertas visuais com SweetAlert2
- Interface responsiva com Bootstrap

---

## 🗄️ Banco de Dados

Tabela `contatos`:

| Campo        | Tipo         | Descrição               |
| ------------ | ------------ | ----------------------- |
| id           | INT (PK)     | Identificador único     |
| nome         | VARCHAR(100) | Nome do contato         |
| telefone     | VARCHAR(20)  | Número de telefone      |
| mensagem     | TEXT         | Mensagem do contato     |
| data_hora    | DATETIME     | Data/hora do cadastro   |
| data_update  | DATETIME     | Data/hora da edição     |

---

## ⚙️ Tecnologias Utilizadas

- PHP 8+ (PDO)
- MySQL
- Bootstrap 5
- Font Awesome 6
- SweetAlert2
- jQuery (opcional)
- Composer (para Dotenv)

---

## 🔒 Segurança

- Uso de prepared statements (PDO) para evitar SQL Injection
- Validação e sanitização de entradas
- Confirmação visual antes de exclusão
- Separação de responsabilidades (MVC)

---

## 🚀 Como Executar

1. **Clone o repositório**
2. **Configure o arquivo `.env`** com os dados do seu banco MySQL:
   ```
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=seu_banco
   DB_USER=usuario
   DB_PASS=senha
   ```
3. **Instale as dependências** com Composer:
   ```
   composer install
   ```
4. **Implemente a tabela `contatos`** no seu banco de dados.
5. **Acesse a pasta `/view`** pelo navegador para utilizar o sistema.

---

## 🔮 Melhorias Futuras

- Autenticação de usuários (login/admin)
- Exportação de contatos (CSV, Excel)
- Busca em tempo real (AJAX)
- Integração com WhatsApp Business API
- Log de alterações por contato

---

## 📄 Licença

Este projeto é livre para uso acadêmico e pessoal.

---
