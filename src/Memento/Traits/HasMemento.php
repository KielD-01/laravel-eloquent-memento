<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento\Memento\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use KielD01\LaravelEloquentMemento\Models\Memento;

/**
 * Class HasMemento
 * @package KielD01\LaravelEloquentMemento\Memento\Traits
 * @property Memento[] mementos
 *
 * @method morphMany($related, $name, $type = null, $id = null, $localKey = null)
 * @method getDirty()
 * @method getOriginal($name, $default = null)
 */
trait HasMemento
{
    use MementoCheckerTrait;

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
        $memento = [];

        collect($this->getDirty())
            ->each(function ($value, $field) use (&$memento) {
                $memento[] = $this->getOriginal($field);
            });

        $this->mementos()
            ->create([
                'action' => $action,
                'memento' => $memento
            ]);
    }

    /**
     * @return MorphMany
     */
    public function mementos(): MorphMany
    {
        return $this->morphMany(Memento::class, 'mementoable');
    }

    /**
     * @param string $action
     */
    public function processMemento(string $action): void
    {
        if ($this instanceof Model) {
            $this->beforeMemento();
            $this->onMemento($action);
            $this->afterMemento();
        }
    }
}