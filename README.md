# Meu Amigo Secreto

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![GSAP](https://img.shields.io/badge/GSAP-88CE02?style=for-the-badge&logo=greensock&logoColor=white)

Uma aplicação web completa e moderna para organizar sorteios de Amigo Secreto (Amigo Oculto) de forma 100% online, segura e divertida. O projeto oferece desde o gerenciamento de participantes até uma experiência de revelação interativa com animações.

## Funcionalidades

### Área do Organizador
* **Gestão de Grupos:** Crie múltiplos grupos de sorteio.
* **Controle Total:** Adicione, edite e remova participantes facilmente.
* **Restrições de Sorteio:** Defina regras para impedir pares específicos (ex: casais não podem se tirar).
* **Opção de Participação:** O organizador pode optar por participar do sorteio ou apenas gerenciar.
* **Mural do Mistério:** Habilite ou desabilite a troca de mensagens anônimas entre os participantes.
* **Moderação:** Ferramenta para apagar mensagens inadequadas do mural.
* **Modo Festa:** Uma tela exclusiva "fullscreen" para projetar na TV e auxiliar na revelação dos presentes ao vivo.

### Área do Participante (Pública)
* **Acesso Simplificado:** Login via Link Único (Token), sem necessidade de cadastro e senha para convidados.
* **Resultado do Sorteio:** Visualização clara e animada de quem o participante tirou.
* **Lista de Desejos:**
    * Cadastre seus próprios desejos de presente.
    * Visualize a lista de desejos do seu amigo secreto.
* **Mural do Mistério:**
    * Envie mensagens anônimas para o mural geral do grupo.
    * Envie recados secretos diretamente para o seu amigo oculto.

## Tecnologias Utilizadas

* **Back-end:** Laravel 10+ (PHP 8.1+)
* **Autenticação:** Laravel Breeze (para o Organizador)
* **Banco de Dados:** MySQL
* **Front-end:** Blade Templates com Tailwind CSS
* **Interatividade:** Alpine.js (para modais e lógica reativa leve)
* **Animações:** GSAP (GreenSock) & ScrollTrigger
* **UX:** Lenis (Smooth Scroll) e SweetAlert2 (Pop-ups animados)

## Instalação e Como Rodar

Siga os passos abaixo para rodar este projeto na sua máquina local:

### Pré-requisitos
* PHP 8.1 ou superior
* Composer
* Node.js & NPM
* MySQL

### Passo a Passo

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/SEU-USUARIO/meu-amigo-secreto.git](https://github.com/SEU-USUARIO/meu-amigo-secreto.git)
    cd meu-amigo-secreto
    ```

2.  **Instale as dependências do Back-end (PHP):**
    ```bash
    composer install
    ```

3.  **Instale as dependências do Front-end (JS/CSS):**
    ```bash
    npm install
    ```

4.  **Configure o ambiente:**
    Crie uma cópia do arquivo de exemplo `.env.example`:
    ```bash
    cp .env.example .env
    ```
    *No Windows:* `copy .env.example .env`

5.  **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```

6.  **Configure o Banco de Dados:**
    Abra o arquivo `.env` e configure suas credenciais do banco de dados (crie um banco vazio no seu MySQL antes):
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nome_do_seu_banco
    DB_USERNAME=root
    DB_PASSWORD=sua_senha
    ```

7.  **Rode as migrações (Criação das tabelas):**
    ```bash
    php artisan migrate
    ```

8.  **Inicie o servidor local:**
    Você precisará de dois terminais abertos:

    *Terminal 1 (Servidor PHP):*
    ```bash
    php artisan serve
    ```

    *Terminal 2 (Compilador de Assets):*
    ```bash
    npm run dev
    ```

9.  **Acesse:**
    Abra seu navegador em `http://127.0.0.1:8000`

## Licença

Este projeto está sob a licença MIT. Sinta-se livre para usar e modificar.