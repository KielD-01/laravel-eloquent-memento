<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento\Observers;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelMementoObserver
 * @package KielD01\LaravelEloquentMemento\Observers
 */
class ModelMementoObserver
{
    public function created(Model $model): void
    {
        $this->process($model, __FUNCTION__);
    }

    public function updating(Model $model): void
    {
        $this->process($model, __FUNCTION__);
    }

    public function deleting(Model $model): void
    {
        $this->process($model, __FUNCTION__);
    }

    /**
     * @param Model $model
     * @param string $action
     */
    private function process(Model $model, string $action): void
    {
        if (method_exists($model, 'processMemento')) {
            $model->processMemento($action);
        }
    }
}