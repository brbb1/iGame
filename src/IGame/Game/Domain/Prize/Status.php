<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

enum Status: string
{
    case NotDraw = 'not_draw';
    case Created = 'created';
    case Delivered = 'delivered';
    case Received = 'received';
    case Replaced = 'replaced';
    case Declined = 'declined';
}