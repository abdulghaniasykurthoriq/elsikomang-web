<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Generate a new Service class in app/Services';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        if (File::exists($path)) {
            $this->error("Service already exists at {$path}");
            return Command::FAILURE;
        }

        File::ensureDirectoryExists(app_path('Services'));

        $stub = <<<EOT
<?php

namespace App\Services;

class {$name}
{
    //
}
EOT;

        File::put($path, $stub);

        $this->info("Service created: {$path}");
        return Command::SUCCESS;
    }
}
