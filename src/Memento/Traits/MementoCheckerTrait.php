<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento\Memento\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use KielD01\LaravelEloquentMemento\Memento\Constants;

/**
 * Trait MementoCheckerTrait
 * @package KielD01\LaravelEloquentMemento\Memento\Traits
 * @method string getTable()
 */
trait MementoCheckerTrait
{
    public function checkIfSchemaIsMemento(): bool
    {
        return $this->mementoCallback(
            Constants::MEMENTO_SCHEMAS_CACHE_KEY,
            function (array $cachedSchemas) {
                return in_array($this->getTable(), $cachedSchemas, true);
            }
        );
    }

    public function storeSchemaForMemento(): void
    {
        $this->mementoCallback(
            Constants::MEMENTO_SCHEMAS_CACHE_KEY,
            function (array $cachedSchemas) {
                $cachedSchemas[] = $this->getTable();
                Cache::forever(Constants::MEMENTO_SCHEMAS_CACHE_KEY, $cachedSchemas);
                Cache::forever(
                    sprintf(
                        Constants::MEMENTO_SCHEMA_RECORDS,
                        $this->getTable()
                    ),
                    collect()
                );
            }
        );
    }

    /**
     * @param string $cacheKey
     * @param Closure $closure
     * @param ...$args
     * @return mixed
     */
    private function mementoCallback(string $cacheKey, Closure $closure, ...$args)
    {
        $cachedData = Cache::get($cacheKey, []);

        if ($this instanceof Model) {
            $methodArgs = func_get_args();
            return $closure($cachedData, array_splice($methodArgs, 0, 2));
        }
    }
}