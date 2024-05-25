<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReplaceCharacterInUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:replace {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace character in URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url');

        $posicao = strpos($url, ':8');
        if ($posicao !== false && $posicao > 0) {
            $url = substr_replace($url, '', $posicao - 1, 1);
            $this->info($url);
        } else {
            $this->error('Substring ":8" not found in the URL or the position is invalid.');
        }
    }
}
