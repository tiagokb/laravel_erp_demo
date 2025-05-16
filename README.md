<div align="center">

<h1>Laravel ERP Demo</h1>

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Fc8aa633b-7b56-411b-98ee-5c709b830bdc%3Fdate%3D1%26label%3D1&style=for-the-badge)](https://forge.laravel.com/servers/789165/sites/2719199)

Um sistema ERP básico feito com Laravel, criado para fins de aprendizado e demonstração de um fluxo completo de pedidos, pagamentos e integrações com webhooks.
</div>

---

## 🚀 Tecnologias Utilizadas

- PHP ^8.2
- Laravel 12 
- Javascript
- MySQL
- Blade
- TailwindCSS

---

## 🔗 Demo Online

Acesse a versão de demonstração do projeto:

👉 [https://erpdemo.think.dev.br/](https://erpdemo.think.dev.br/)

---

### 🧪 Testes via Postman

Este projeto inclui uma **collection do Postman** com requisição pronta para testar o endpoint de webhook manualmente.

📁 Arquivo: [`Laravel ERP Demo.postman_collection.json`](postman%2FLaravel%20ERP%20Demo.postman_collection.json)

> O webhook pode ser testado enviando um `POST` para `/webhook` com os seguintes parâmetros:
>
> - `id`: ID do pedido
> - `status`: `paid`, `shipped` ou `canceled`
>
> Esses valores disparam os e-mails automáticos correspondentes, porem, qualquer valor enviado ao status sera reproduzido no banco e enviado um email genérico.

#### Como usar:

1. Importe o arquivo `.json` no [Postman](https://www.postman.com/).
2. Defina a variável `{{base_url}}` como a URL da sua aplicação local ou online.
3. Execute a requisição desejada para simular o recebimento do webhook.


## ⚙️ Como Rodar Localmente

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/laravel_erp_demo.git

# Acesse o diretório
cd laravel_erp_demo

# Instale as dependências
composer install
npm install && npm run dev

# Configure o .env
cp .env.example .env
php artisan key:generate

# Rode o servidor (Não é necessário se estiver usando Laravel Herd)
php artisan serve

# Rode a queue default (emails e webhook)
php artisan queue:work --queue=default
