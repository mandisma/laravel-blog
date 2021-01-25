<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelStatus\Status as BaseStatus;

class Status extends BaseStatus
{
    use HasFactory;

    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';

    public function isValidStatus(string $name, ?string $reason = null): bool
    {

        if (! in_array($name, [self::DRAFT, self::PUBLISHED])) {
            return false;
        }

        return true;
    }
}
