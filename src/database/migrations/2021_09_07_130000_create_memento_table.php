<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use KielD01\LaravelEloquentMemento\Constants;

/**
 * Class CreateMementoTable
 */
class CreateMementoTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(Constants::DB_MEMENTO_TABLE)) {
            Schema::create(Constants::DB_MEMENTO_TABLE, static function (Blueprint $table) {
                $table->id()->primary();
                $table->string('action')->nullable(false);
                $table->string('memento')->nullable(false);
                $table->string('mementoable_id')->nullable(false);
                $table->string('mementoable_type')->nullable(false);

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        !Schema::hasTable(Constants::DB_MEMENTO_TABLE) ?:
            Schema::drop(Constants::DB_MEMENTO_TABLE);
    }
}