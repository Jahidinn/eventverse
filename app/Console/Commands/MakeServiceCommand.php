<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';

    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = trim($this->argument('name'));

        $path = app_path('Services/' . $name . '.php');

        // Buat folder jika belum ada
        File::ensureDirectoryExists(dirname($path));

        if (File::exists($path)) {
            $this->error('Service already exists!');
            return Command::FAILURE;
        }

        $class = class_basename($name);

        $namespace = 'App\\Services';

        if (str_contains($name, '/')) {
            $folder = str_replace('/', '\\', dirname($name));

            $namespace .= '\\' . $folder;
        }

        $stub = <<<PHP
<?php

namespace {$namespace};

class {$class}
{

}

PHP;

        File::put($path, $stub);

        $this->info("Service created successfully.");
        $this->line($path);

        return Command::SUCCESS;
    }
}