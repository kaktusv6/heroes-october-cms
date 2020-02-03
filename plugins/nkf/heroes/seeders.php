<?php declare(strict_types=1);

namespace Nkf\Heroes;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Nkf\Heroes\Models\Characteristic;
use Nkf\Heroes\Models\Game;
use Nkf\Heroes\Utils\FileUtil;
use Nkf\Heroes\Utils\JsonUtil;

class HeroesSeeder extends Seeder
{
    private $pathToDirJson;
    private $faker;

    public function __construct()
    {
        $this->pathToDirJson = FileUtil::concatPaths(base_path(), 'plugins', 'nkf', 'heroes', 'json_data');
        $this->faker = Factory::create();
        parent::__construct();
    }


    private function getDataFromJson(string $fileName): mixed
    {
        return JsonUtil::decodeFile(FileUtil::concatPaths($this->pathToDirJson, $fileName.'.json'));
    }

    public function run(): void
    {
        $games = $this->getDataFromJson('games');
        $gameIds = [];
        foreach ($games as $game) {
            $gameIds[] = Game::create($game)->id;
        }

        $characteristics = $this->getDataFromJson('characteristics');
        foreach ($characteristics as $characteristic) {
            $characteristic = Characteristic::create($characteristic);
            $characteristic->game_id = $this->faker->randomElement($gameIds);
            $characteristic->save();
        }
    }
}
