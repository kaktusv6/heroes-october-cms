<?php declare(strict_types=1);

use Nkf\Heroes\Models\ApiKey;
use Nkf\Heroes\Models\CharacteristicsHero;
use Nkf\Heroes\Models\Field;
use Nkf\Heroes\Models\FieldsHero;
use Nkf\Heroes\Models\HomeWorld;
use Nkf\Heroes\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Nkf\Heroes\Models\Characteristic;
use Nkf\Heroes\Models\Game;
use Nkf\Heroes\Models\Hero;
use Nkf\Heroes\Models\UsersToken;
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
    private const API_KEY = 'KFu5xJtP3J';
    private const TOKEN = 'dMdvyErGUg';

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function username(): string
    {
        return str_replace('.', '', $this->faker->userName);
    }

    public function generateApiKey(): void
    {
        $apiKey = new ApiKey;
        $apiKey->api_key = self::API_KEY;
        $apiKey->save();
    }

    public function generateToken(): void
    {
        $token = new UsersToken;
        $token->token = self::TOKEN;
        $token->user_id = User::get()->first()->id;
        $token->save();
    }

    public function run(): void
    {
        $this->generateApiKey();

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

            foreach ([
                         [
                             'name' => 'Рост',
                             'type' => 'int',
                         ],
                         [
                             'name' => 'Вес',
                             'type' => 'int',
                         ],
                         [
                             'name' => 'Прошлое',
                             'type' => 'string',
                         ],
                         [
                             'name' => 'Очки судьбы',
                             'type' => 'int',
                         ],
                         [
                             'name' => 'Возраст',
                             'type' => 'int',
                         ],
                         [
                             'name' => 'Пол',
                             'type' => 'string',
                         ],
                         [
                             'name' => 'Телосложение',
                             'type' => 'string',
                         ],
                         [
                             'name' => 'Деньги (Троны)',
                             'type' => 'int',
                         ],
                     ] as $item) {
                $field = new Field;
                $field->name = $item['name'];
                $field->type = $item['type'];
                $field->save();
                $field->games()->sync($gameId);
            }
        }

        $users = [];
        foreach ([
                     [
                         'login' => 'test',
                         'password' => 'testtest',
                     ]
                 ] as $userData) {
            $user = new User;
            $user->login = $userData['login'];
            $user->password = $userData['password'];
            $user->save();
            $users[] = $user->id;
        }

        $this->generateToken();

        for ($i = random_int(2, 5); $i-- > 0;) {
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
                $characteristicHero = new CharacteristicsHero;
                $characteristicHero->hero_id = $hero->id;
                $characteristicHero->characteristic_id = $characteristic->id;
                $characteristicHero->value = random_int(20, 40);
                $characteristicHero->save();
            }

            foreach ($hero->game->fields as $field) {
                $fieldHero = new FieldsHero;
                $fieldHero->field_id = $field->id;
                $fieldHero->hero_id = $hero->id;
                $value = null;
                switch ($field->type) {
                    case 'int':
                        $value = random_int(10, 20);
                        break;
                    case 'string':
                        $value = $this->faker->text(10);
                        break;
                }
                $fieldHero->value = $value;
                $fieldHero->save();
            }
        }
    }
}
