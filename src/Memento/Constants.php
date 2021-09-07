<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento;

/**
 * Class Constants
 * @package KielD01\LaravelEloquentMemento
 */
final class Constants
{
    public const MEMENTO_SCHEMAS_CACHE_KEY = 'memento_schemas';
    public const MEMENTO_SCHEMA_RECORDS = '%s_memento_records';
    public const MEMENTO_CACHE_PATTERN = '%s_record_mementos';

    public const DB_MEMENTO_TABLE = 'memento';
}