<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Services\Raffle\DTO\RaffleDTO;
use App\Services\Raffle\DTO\TicketDTO;
use App\Services\Raffle\DTO\WinnerDTO;

interface RaffleService
{
    public function randomInt(int $min, int $max): int;

    public function randomFromArray(array $array): mixed;

    public function getRaffle(int $id): RaffleDTO;

    public function addTickets(int $raffleId, string $userId, string $email, int $count);

    public function getTicket(int $raffleId, int $ticketId): TicketDTO;

    public function getWinner(int $raffleId): WinnerDTO;

    public function createRaffle(string $name): ?int;

    public function finishRaffles(int $id);

    public function getRafflesCount();
}
