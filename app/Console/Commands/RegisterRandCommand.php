<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegisterRandCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:register_rand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Register Rand User';

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
        
        // Conecta ao controller
        $controller = app(\App\Http\Controllers\AuthController::class);

        $result = $controller->register_random();

        $this->info('Segue dados para sua autenticação:');
        $this->info('Nome: ' . $result['name']);
        $this->info('Email: ' . $result['email']);
        $this->info('Senha: 987pa$$qwe');
    }
}
