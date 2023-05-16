<?php

declare(strict_types=1);

namespace App\Contracts;

interface NotificationManager extends RoomsManager
{
    public const TICKET_BUYING = 'ticket_buying';

    public const TRANS_PATH = 'subscriptions.';

    public function notify(string $room, array $data = []): void;

    public function notifyToRuffleRoom(string $room, array $data = []): void;

    public function notifyToCharityRoom(string $room, array $data = []): void;

    public function notifyToPersonalRoom(string $room, string $userId, array $data = [], ?bool $save = true): void;
}
