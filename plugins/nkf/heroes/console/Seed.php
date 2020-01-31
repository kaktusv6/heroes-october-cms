<?php namespace Nkf\Heroes\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Seed extends Command
{
    protected $name = 'heroes:seed';
    protected $description = 'Seed data in plugin Nkf.Heroes';

    protected $seeder;

    /**
     * Seed constructor.
     * @param $seeder
     */
    public function __construct()
    {
        $this->seeder = $seeder;
    }


    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {

        $this->output->writeln('Seed success');
    }

    protected function getArguments()
    {
        return [];
    }

    protected function getOptions()
    {
        return [];
    }
}
