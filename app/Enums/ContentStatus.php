<?php

namespace App\Enums;

enum ContentStatus: int
{
    case DRAFT = 1;
    case PUBLISHED = 2;
    case ARCHIVED = 3;

    public function label(): string
    {
        return match ($this) {
            ContentStatus::DRAFT  => '下書き',
            ContentStatus::PUBLISHED => '公開',
            ContentStatus::ARCHIVED => 'アーカイブ',
        };
    }

}
