<?php declare(strict_types=1);

namespace Nkf\Heroes\Console;

use DatabaseSeeder;
use Illuminate\Console\Command;

class Seed extends Command
{
    protected $name = 'heroes:seed';
    protected $description = 'Seed data in plugin Nkf.Heroes';

    protected $seeder;

    public function __construct()
    {
        parent::__construct();
        $this->seeder = new DatabaseSeeder();
    }

    public function handle(): void
    {
        $this->seeder->run();
        $this->output->writeln('Seed success');
    }
}
