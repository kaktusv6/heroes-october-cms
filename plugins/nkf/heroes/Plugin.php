<?php declare(strict_types=1);

namespace Nkf\Heroes;

use Nkf\Content\ApiKey;
use Nkf\Content\TokenAuthenticate;
use Nkf\Heroes\Commands\CreateMigration;
use Nkf\Heroes\Commands\Seed;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public const MIDDLEWARE_ALIASES = [
        TokenAuthenticate::ALIAS => TokenAuthenticate::class,
        ApiKey::ALIAS => ApiKey::class,
    ];
    public function boot()
    {
        parent::boot();
        $router = app('router');
        foreach (self::MIDDLEWARE_ALIASES as $alias => $class) {
            $router->aliasMiddleware($alias, $class);
        }
    }

    public function register()
    {
        parent::register();
        $this->registerConsoleCommand('heroes:seed', Seed::class);
        $this->registerConsoleCommand('make:migration', CreateMigration::class);
    }


}
