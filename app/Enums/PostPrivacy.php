<?php

namespace App\Enums;

enum PostPrivacy: string
{
    case PUBLIC = 'public';
    case FRIENDS = 'friends';
    case PRIVATE = 'private';

    public function label(): string
    {
        return match($this) {
            self::PUBLIC => 'Public',
            self::FRIENDS => 'Friends Only',
            self::PRIVATE => 'Only Me',
        };
    }
}
