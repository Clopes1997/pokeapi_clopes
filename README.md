# pokeapi-app-clopes

Aplicação Laravel para consumo da PokéAPI v2, persistência local de dados de Pokémon e controle de acesso baseado em papéis.

## Stack
- PHP 8+, Laravel
- Composer
- MySQL
- Consumo HTTP da PokéAPI v2 com cache e tratamento de erros

## Requisitos
- PHP 8+
- Composer
- MySQL

## Configuração e execução
1) Instalar dependências  
`composer install`

2) Configurar ambiente  
Copie `.env.example` para `.env` e ajuste as credenciais do banco de dados.

3) Gerar chave da aplicação  
`php artisan key:generate`

4) Criar banco, migrar e popular dados básicos  
`php artisan migrate --seed`

5) Importar Pokémon (a listagem inicia vazia até este passo)  
`php artisan pokemon:import-auto`

6) Executar a aplicação  
`php artisan serve`  
Acesse o host e a porta indicados no terminal.

## Papéis de usuário
- Viewer: pode visualizar dados já importados.
- Editor: pode importar dados da PokéAPI e gerenciar favoritos.
- Admin: pode gerenciar usuários, permissões e registros importados, conforme as políticas definidas.

## Recuperação de senha
- A aplicação não envia e-mails. Para redefinir a senha, utilize o fluxo de recuperação e consulte os logs da aplicação para obter o link de redefinição.

## Importação de Pokémon
- O comando `php artisan pokemon:import-auto` realiza requisições HTTP GET à PokéAPI v2, que não requer autenticação.
- As respostas da API são cacheadas e falhas de rede ou indisponibilidade são tratadas de forma segura.
- Até a execução do comando, a aplicação pode iniciar com a lista de Pokémon vazia.