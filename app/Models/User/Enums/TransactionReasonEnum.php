<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum TransactionReasonEnum: string
{
    case Order = 'order';
    case Exchange = 'exchange';
    case Reward = 'reward';
    case ChangeLimit = 'changeLimit';
    case Achievement = 'achievement';
    case Raise = 'raise';
    case Actualization = 'actualization';
    case RaffleTicket = 'raffleTicket';
    case CharityTicket = 'charityTicket';
}
