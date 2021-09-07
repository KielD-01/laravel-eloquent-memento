<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento\Memento\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use KielD01\LaravelEloquentMemento\Models\Memento\Memento;

/**
 * Class HasMemento
 * @package KielD01\LaravelEloquentMemento\Memento\Traits
 * @property array mementoRelations
 * @property null|array memorableFields
 * @property Memento[] mementos
 *
 * @method morphMany($related, $name, $type = null, $id = null, $localKey = null)
 * @method getAttributes()
 */
trait HasMemento
{
    use MementoCheckerTrait;

    /** @var array */
    protected array $mementoRelations = [];

    /** @var array|null */
    protected ?array $memorableFields = null;

    abstract public function beforeMemento(): void;

    abstract public function afterMemento(): void;

    public function onMemento(string $action): void
    {
        // ToDo : 1. Process memorable fields
        // ToDo : 2. Load relations
        $this->mementos()
            ->create([
                'action' => $action,
                'memento' => $this->getAttributes()
            ]);
    }

    /**
     * @return HasMany
     */
    public function mementos(): HasMany
    {
        return $this->morphMany(Memento::class, 'mementoable');
    }

    public function processMemento(string $action): void
    {
        if ($this instanceof Model) {
            $this->beforeMemento();
            $this->onMemento($action);
            $this->afterMemento();
        }
    }
}