<?php declare(strict_types=1);

use Nkf\Heroes\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Nkf\Heroes\Models\Characteristic;
use Nkf\Heroes\Models\Game;
use Nkf\Heroes\Models\Hero;
use Nkf\Heroes\Utils\StringUtils;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $isProduction = App::environment() === 'production';
        if (!$isProduction) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            foreach (Schema::getConnection()->getDoctrineSchemaManager()->listTableNames() as $table) {
                if (StringUtils::startsWith($table, 'nkf')) {
                    DB::table($table)->truncate();
                }
            }
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }

        $this->call(InitalSeeder::class);

        if (!$isProduction) {
            $this->call(FixtureSeeder::class);
        }
    }
}

class InitalSeeder extends Seeder
{
    public function run(): void
    {
        // TODO seeder data from json files. In json files main data D&D and Warhammer 40k
    }
}

class FixtureSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function run(): void
    {
        $games = [];
        foreach ([
                     [
                         'title' => 'Warhammer 40K DH',
                     ]
                 ] as $gameData) {
            $game = new Game;
            $game->title = $gameData['title'];
            $game->description = $this->faker->text;
            $game->save();
            $games[] = $game->id;
        }

        foreach ($games as $gameId) {
            foreach ([
                        [
                            'title' => 'WS',
                        ],
                        [
                            'title' => 'BS',
                        ],
                        [
                            'title' => 'Strange',
                        ],
                        [
                            'title' => 'Tought',
                        ],
                        [
                            'title' => 'Agility',
                        ],
                        [
                            'title' => 'Intelligence',
                        ],
                        [
                            'title' => 'Perception',
                        ],
                        [
                            'title' => 'Will power',
                        ],
                        [
                            'title' => 'Fellow ship',
                        ],
                     ] as $characteristicData) {
                $characteristic = new Characteristic;
                $characteristic->title = $characteristicData['title'];
                $characteristic->description = $this->faker->text;
                $characteristic->range = [['min' => 0, 'max' => 100]];
                $characteristic->range_generator = [['min' => 20, 'max' => 40]];
                $characteristic->save();
                $characteristic->games()->sync($gameId);
            }

            foreach ([
                         [
                             'title' => 'Мир улий',
                         ],
                         [
                             'title' => 'Имперский мир',
                         ],
                         [
                             'title' => 'Дикий мир',
                         ],
                         [
                             'title' => 'Мир кузница',
                         ]
                     ] as $item) {
                $world = new HomeWorld;
                $world->title = $item['title'];
                $world->save();
                $world->games()->sync($gameId);
            }
        }

        $users = [];
        for ($i = random_int(3, 5); $i --> 0;)
        {
            $user = new User;
            $user->login = $this->faker->text(5);
            $user->password = $this->faker->password;
            $user->save();
            $users[] = $user->id;
        }

        for ($i = random_int(10, 20); $i --> 0;)
        {
            $hero = new Hero;
            $hero->name = $this->faker->text(5);
            $hero->game_id = $this->faker->randomElement($games);
            $hero->user_id = $this->faker->randomElement($users);
            $homeWorlds = $hero->game->homeWorlds->map(function (HomeWorld $world) {
                return $world->id;
            });
            $hero->home_world_id = $this->faker->randomElement($homeWorlds);
            $hero->save();

            foreach ($hero->game->characteristics as $characteristic) {
                $hero
                    ->characteristics()
                    ->save($characteristic, ['value_type' => TypeValue::INT, 'value' => random_int(20, 40)]);
            }
        }
    }
}
