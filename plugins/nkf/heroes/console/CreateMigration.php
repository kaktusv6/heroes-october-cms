<?php declare(strict_types=1);

namespace Nkf\Heroes\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Yaml;

class CreateMigration extends Command
{
    protected $name = 'make:migration';
    protected $description = 'Make migration';
    private $tablePrefix = 'nkf_heroes_*';

    public function getFileName(): string
    {
        return Carbon::now()->format('Y_m_d_hi_').$this->argument('migration').'.php';
    }

    public function getDescription(): string
    {
        return ucfirst(str_replace('_', ' ', $this->argument('migration')));
    }

    public function getArgument(): array
    {
        return [
            ['migration', InputArgument::class, 'Description migration'],
        ];
    }

    public function handle(): void
    {
        $versions = Yaml::parseFile('../updates/version.yaml');
        echo $versions;
    }
}
