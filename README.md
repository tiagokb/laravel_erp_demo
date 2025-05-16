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
