<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegisterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:register {name : The name of the new user} {email : The email of the new user} {password : The password of the new user} {password_confirmation : The password_confirmation of the new user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Register User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Registrando usuário...');
        
        $parameters = [
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'password_confirmation' => $this->argument('password_confirmation')
        ];

        // Cria uma request, pois o comando artisan não é por meio de http request
        $request = new \Illuminate\Http\Request($parameters);
        
        // Conecta ao controller
        $controller = app(\App\Http\Controllers\AuthController::class);

        $result = $controller->register($request);

        $this->info('Segue dados para sua autenticação:');
        $this->info('Nome: ' . $result['name']);
        $this->info('Email: ' . $result['email']);
        $this->info('Senha: ' . $this->argument('password'));

    }
}
