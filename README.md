<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Informações sobre o projeto

Primeiros passos: <br/>
	- Clone o projeto em sua máquina.<br/>
	- Inicialize o docker com docker compose up<br/>
	- Acesse o terminal da aplicação (app-1)<br/>
	- Rode os seguintes comandos:<br/><br/>
	composer update<br/>
	php artisan migrate<br/>
	php artisan serve<br/>

Informações adicionais
	- O projeto vai rodar na porta 9000 ([127.0.0.1:9000](http:127.0.0.1:9000)). Está configurada essa porta para evitar possíveis conflitos com a porta 8000, por ser padrão.

## Fluxo de teste

Para seguir o fluxo de teste, você deve rodar no terminal da aplicação o comando para criar um usuário para realizar a autenticação

Comando para registrar usuário com as informações que você desejar (Nome, email, senha e confirmação de senha), veja um exemplo: 
	* maiores informações sobre as validações de registro, podem ser vista em AuthController::register()

	php artisan command:register "Bruno Carraro" "bruno@bruno.com" "123456" "123456"

Comando para registrar usuário de forma randômica, via factory: 

	php artisan command:register_rand

Ao criar um usuário, você verá no terminal as informações para efetuar a autenticação. Abra um aplicação para testar API (Postman) e realize a autenticação conforme abaixo:
	- Request: POST http://127.0.0.1:9000/api/login

	- Headers: 
		Accept 		application/json

	- Body: x-www-form-urlenconded
		email		email@email.com
		password	password

Ao efetuar a requisição, ele vai retornar o token da autenticação.

Para as demais requisições, é obrigatório o uso da Authorization Bearer

	Exemplo: 
		Headers: 
		Authorization	Bearer 1|1p4XH93ToTkx0J6OABwjtxaa61xK3JiDMR8A23uP

## Segue lista das APIs disponibilizadas:
- Registro: 
	POST http://127.0.0.1:9000/api/register
- Login: 
	POST http://127.0.0.1:9000/api/login

- Clientes: 
	GET | POST | PUT | DELETE  http://127.0.0.1:9000/api/clients

- Produtos: 
	GET | POST | PUT | DELETE  http://127.0.0.1:9000/api/products

- Filtrar Produtos por cliente: 
	POST http://127.0.0.1:9000/api/products/search-client/{id}

- Filtrar Produtos por nome: 
	POST http://127.0.0.1:9000/api/products/search/{nome}

- Logout
	POST http://127.0.0.1:9000/api/logout

* Para informações sobre os campos obrigatórios para preenchimento do POST, você encontra na function store() em cada controller.