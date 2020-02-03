<?php declare(strict_types=1);

namespace Nkf\Heroes;

use Nkf\Heroes\Console\Seed;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {

    }

    public function registerSettings()
    {
    }

    public function register()
    {
        parent::register();
        $this->registerConsoleCommand('heroes:name', Seed::class);
    }


}
