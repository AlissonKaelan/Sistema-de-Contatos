
# 📱 Projeto: Formulário de Contato com Envio via WhatsApp

Este projeto consiste em um sistema simples para cadastro, listagem e edição de contatos, com envio de mensagens via WhatsApp diretamente do navegador. Ele utiliza PHP para backend, PDO para acesso ao banco de dados, e Bootstrap 5 para o frontend responsivo.

---

## 📁 Estrutura do Projeto

```plaintext
raiz/
├── controller/
│   └── ContatoController.php         # Controlador responsável pela lógica de salvar e excluir contatos
├── model/
│   └── Contato.php                   # Modelo que encapsula operações no banco de dados usando PDO
├── public/
│   ├── css/
│   │   ├── style.css                 # Estilos base e específicos para o formulário
│   │   └── list.css                  # Estilos para a lista de contatos e botões de ação
│   └── js/
│       └── main.js                   # Scripts JS para máscaras, validação e envio via WhatsApp
├── view/
│   ├── form.php                     # Formulário principal para cadastro e envio
│   ├── adicionar_contato.php        # Página para adicionar um novo contato
│   └── editar_contato.php           # Página para edição de contato existente
└── list.php                         # Página que lista todos os contatos cadastrados
````

---

## ✅ Funcionalidades Principais

* Validação dos campos obrigatórios e formatação correta do telefone brasileiro
* Máscara de telefone em tempo real no campo de entrada
* Contagem de caracteres no campo de mensagem para limitar a 300 caracteres
* Envio rápido de mensagem via WhatsApp utilizando URL API `https://wa.me/`
* Alertas visuais e feedbacks usando SweetAlert2 para sucesso, erros e avisos
* Layout responsivo e moderno com Bootstrap 5
* Armazenamento dos contatos em banco de dados com PHP PDO
* Edição e exclusão de contatos diretamente pela lista
* Estrutura MVC simplificada (Model, View e Controller)

---

## 🧠 Detalhes dos Componentes

### Modelo: `model/Contato.php`

Classe que gerencia as operações do banco de dados:

* `__construct(PDO $conn)`: Recebe a conexão PDO
* `salvar($nome, $telefone, $mensagem, $dataHora)`: Insere um novo contato
* `telefoneExiste($telefone)`: Verifica se o telefone já está cadastrado
* `excluir($id)`: Remove contato pelo ID

### Controlador: `controller/ContatoController.php`

Recebe requisições do formulário e realiza as ações de salvar e excluir contatos, além de redirecionar com parâmetros de sucesso ou erro.

### Scripts JS: `public/js/main.js`

* Máscara de telefone brasileira com DDD
* Validação dos campos em tempo real
* Contador de caracteres para mensagem
* Montagem do link para envio via WhatsApp
* Prevenção de envio acidental ao pressionar Enter

### Estilos CSS

* `style.css`: estilos gerais para o formulário e página principal
* `list.css`: estilos para a listagem de contatos e botões de ação (call, message, edit, delete)

---

## 🖥️ Views (Interface)

### `view/form.php`

Formulário principal para cadastrar e enviar mensagens via WhatsApp.

### `view/adicionar_contato.php`

Formulário dedicado para adicionar um novo contato, com validação e preenchimento automático da data/hora.

### `view/editar_contato.php`

Formulário para editar um contato já existente, com dados carregados do banco.

### `list.php`

Página que lista todos os contatos cadastrados, com opções para ligar, enviar mensagem, editar ou excluir.

---

## 💾 Banco de Dados

Tabela `contatos` com os seguintes campos:

| Campo       | Tipo         | Descrição                  |
| ----------- | ------------ | -------------------------- |
| `id`        | INT (PK)     | Identificador único        |
| `nome`      | VARCHAR(100) | Nome do contato            |
| `telefone`  | VARCHAR(20)  | Número de telefone         |
| `mensagem`  | TEXT         | Mensagem padrão do contato |
| `data_hora` | DATETIME     | Data e hora do cadastro    |

---

## 🚀 Melhorias Futuras

* Implementar autenticação de usuários para acesso seguro
* Adicionar paginação e filtros na lista de contatos
* Integrar com API oficial do WhatsApp Business para envio direto
* Painel administrativo com dashboard e relatórios
* Envio de notificações por e-mail ao cadastrar contato

---

## 📄 Licença
