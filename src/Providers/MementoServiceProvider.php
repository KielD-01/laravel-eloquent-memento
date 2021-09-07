<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento\Providers;

use Exception;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use KielD01\LaravelEloquentMemento\Constants;
use KielD01\LaravelEloquentMemento\Observers\ModelMementoObserver;

/**
 * Class MementoServiceProvider
 * @package KielD01\LaravelEloquentMemento\Providers
 */
class MementoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->migrations();
        $this->config();
    }

    /**
     * @throws Exception
     */
    public function boot(): void
    {
        Config::set('memento.enabled', $this->checkIfCanBeEnabled());

        if (config('memento.enabled')) {
            $this->enableMementoForModels();
        }
    }

    /**
     * Checks, if memento target table does exists
     *
     * @return bool
     */
    private function checkIfCanBeEnabled(): bool
    {
        return Schema::hasTable(Constants::DB_MEMENTO_TABLE);
    }

    private function migrations(): void
    {
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            'database' . DIRECTORY_SEPARATOR .
            'migrations' . DIRECTORY_SEPARATOR => database_path('migrations')
        ]);
    }

    private function config(): void
    {
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            'config' . DIRECTORY_SEPARATOR => config_path()
        ]);
    }

    /**
     * @throws Exception
     */
    private function enableMementoForModels(): void
    {
        $classes = ClassFinder::getClassesInNamespace(config('memento.models.namespace', 'App\\Models'));

        collect($classes)
            ->filter(static fn($class) => is_subclass_of($class, Model::class))
            ->each(static fn($model) => $model::observe(ModelMementoObserver::class));
    }
}