<?php declare(strict_types=1);

namespace Nkf\Heroes\Commands;

use DatabaseSeeder;
use File;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Nkf\Enums\TypeMigration;
use Nkf\Heroes\Utils\FileUtils;
use Nkf\Heroes\Utils\StringUtils;
use October\Rain\Parse\Bracket as TextParser;
use Yaml;

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
        $this->output->text('Seed success');
    }
}

class CreateMigration extends Command
{
    protected $name = 'make:migration';
    protected $description = 'Create new migration';
    protected $signature = 'make:migration {description}';

    protected $namespace = 'Nkf\Heroes\Updates';
    protected $tablePrefix = 'nkf_heroes_*';
    protected $classPrefix = 'BuilderTable';

    protected $migrationsFolder = __DIR__.'/updates';
    protected $fileVersion = 'version.yaml';
    protected $migrationsTemplates = __DIR__.'/templates/migrations';

    protected function getFileName(): string
    {
        return sprintf(
            '%s_%s.php',
            Carbon::now('Asia/Vladivostok')->format('Y_m_d_hi'),
            $this->argument('description')
        );
    }

    protected function getMigrationDescription(): string
    {
        return StringUtils::snakeToText($this->argument('description'));
    }

    protected function getClassForMigration(): string
    {
        return sprintf('%s%s', $this->classPrefix, StringUtils::snakeToCamel($this->argument('description')));
    }

    protected function createFileMigration(string $fileName): bool
    {
        $typeMigration = TypeMigration::DEFAULT;
        if (StringUtils::strripos($fileName, TypeMigration::CREATE)) {
            $typeMigration = TypeMigration::CREATE;
        }

        $fileContent = File::get(FileUtils::join($this->migrationsTemplates, "migration_$typeMigration.php.tpl"));
        $code = TextParser::parse($fileContent, [
            'namespace' => $this->namespace,
            'className' => $this->getClassForMigration(),
            'tableNamePrefix' => $this->tablePrefix,
        ]);

        if (file_put_contents(FileUtils::join($this->migrationsFolder, $fileName), $code) === false) {
            $this->error('Unable to create migration file.');
            return false;
        }
        return true;
    }

    public function handle(): void
    {
        $pathToVersionFile = FileUtils::join($this->migrationsFolder, $this->fileVersion);
        $versions = Yaml::parseFile($pathToVersionFile);
        $migrationDescription = $this->getMigrationDescription();
        foreach ($versions as $version) {
            foreach ($version as $content) {
                if ($migrationDescription === $content) {
                    $this->error('Migration with same name already exists.');
                    return;
                }
            }
        }
        [$major, $minor, $build] = array_map('\intval', explode('.', last(array_keys($versions))));
        $build++;
        if ($build >= 10) {
            $build = 0;
            $minor++;
            if ($minor >= 10) {
                $minor = 0;
                $major++;
            }
        }
        $fileName = $this->getFileName();
        if (!$this->createFileMigration($fileName)) {
            return;
        }
        $versionMigration = implode('.', [$major, $minor, $build]);
        $migrationInfo = [
            $versionMigration => [
                $migrationDescription,
                $fileName,
            ]
        ];
        $versionsText = Yaml::render($migrationInfo);
        if (file_put_contents($pathToVersionFile, $versionsText, FILE_APPEND) === false) {
            $this->error('Unable to update version file');
        }
    }
}
