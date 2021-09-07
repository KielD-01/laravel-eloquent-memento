<?php
declare(strict_types=1);

namespace KielD01\LaravelEloquentMemento\Models\Memento;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use KielD01\LaravelEloquentMemento\Constants;

/**
 * Class Memento
 * @package KielD01\LaravelEloquentMemento\Models\Memento
 * @property string table
 * @property array fillable
 *
 * @property int id
 * @property int|string mementoable_id
 * @property string mementoable_type
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 * @property Model mementoable
 */
class Memento extends Model
{
    use SoftDeletes;

    protected $table = Constants::DB_MEMENTO_TABLE;

    protected $fillable = [
        'id',
        'mementoable_id',
        'mementoable_type',
        'memento',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return MorphTo
     */
    public function mementoable(): MorphTo
    {
        return $this->morphTo();
    }
}