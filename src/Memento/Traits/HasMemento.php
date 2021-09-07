<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento\Memento\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use KielD01\LaravelEloquentMemento\Models\Memento;

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

    public function beforeMemento(): void
    {
        // Reusable method
    }

    public function afterMemento(): void
    {
        // Reusable method
    }

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
     * @return MorphMany
     */
    public function mementos(): MorphMany
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