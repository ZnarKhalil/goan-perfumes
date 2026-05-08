<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['translatable_type', 'translatable_id', 'locale', 'field', 'value'])]
class Translation extends Model
{
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }
}
