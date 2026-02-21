<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeSeederCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:seeder {name}";
    protected $description = 'Create a new seeder class with date prefix for tenant databases';
    protected $type = 'Seeder';

    protected function getPath($name)
    {
        $timestampName = time() . '_' .Str::replaceFirst($this->rootNamespace(), '', $name);

        return database_path('seeders/RunningSeeder').'/'.str_replace('\\', '/', $timestampName).'.php';
    }

    protected function getStub()
    {
        return __DIR__.'/stubs/seeder.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }


    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the seeder'],
        ];
    }
}
