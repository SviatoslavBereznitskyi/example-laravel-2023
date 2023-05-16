<?php

declare(strict_types=1);

namespace App\Contracts;

interface RoomsManager
{
    public const RAFFLE_ROOM = 'raffle';
    public const CHARITY_ROOM = 'charity';
    public const ADVICE_BLOG_ROOM = 'advice_blog';
    public const TRANSACTION_ROOM = 'transaction';
    public const APARTMENT_ROOM = 'apartment';
    public const APARTMENT_ROOM_FAVORITE = 'apartment_favorite';
    public const SUBSCRIPTION_PROFILE = 'subscription_profile';
    public const SYSTEM = 'system';
    public const PROMO = 'promo';
    public const MESSAGES = 'messages';
    public const PRICES = 'prices';

    public static function getAvailableRooms(): array;
}
