<?php

namespace App\Console\Commands\Rscript;

use App\Entities\User;
use Illuminate\Console\Command;

class CreateToken extends Command
{

    protected $shScript;

    protected $envFile;

    protected $user = [
        'name'  => 'rscript',
        'email' => 'rscript@capmyrisk.com'
    ];


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rscript:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an api token and store it in rscripts/.env';



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->shScript = storage_path('install/rscript-install.sh');
        $this->envFile = base_path('rscripts/.env.R');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->createUser();
        echo "User was created with name: '{$user->last_name}' and Id: {$user->id}.";

        $this->call('passport:client');

        $url = url('oauth/token');
        $clientId = $this->ask('Client Id:');
        $clientSecret = $this->ask('Client Secret:');

        $this->createCredentialsFile($url, $clientId, $clientSecret);

        echo "Successfully created file 'rscript/.env.R'.\n";

    }

    /**
     * @param $url
     * @param $clientId
     * @param $clientSecret
     */
    private function createCredentialsFile($url, $clientId, $clientSecret): void
    {
        file_put_contents($this->envFile, "uri_token <- '{$url}'");
        file_put_contents($this->envFile, "\nclient_id <- '{$clientId}'", FILE_APPEND);
        file_put_contents($this->envFile, "\nclient_secret <- '{$clientSecret}'", FILE_APPEND);
    }


    private function createUser()
    {
        return User::firstOrCreate([
            'last_name' => $this->user['name'],
            'email' => $this->user['email'],
            'verified' => 1
        ]);
    }

}
