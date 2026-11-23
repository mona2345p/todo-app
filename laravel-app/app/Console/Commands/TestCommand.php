<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

#[Signature('test:routes')]
#[Description('Test if routes are registered')]
class TestCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = Route::getRoutes()->getRoutes();
        
        $this->info('Registered routes:');
        foreach ($routes as $route) {
            $this->line($route->uri() . ' -> ' . $route->getActionName());
        }
        
        $this->info('Total routes: ' . count($routes));
    }
}
