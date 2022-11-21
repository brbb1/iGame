<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Player\Grade;
use Brbb\IGame\Game\Domain\Player\Player;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Shared\Domain\Address;
use Brbb\IGame\Shared\Domain\BankAccount;
use Brbb\IGame\Shared\Domain\Coefficient;
use Brbb\IGame\Shared\Domain\UserId;
use Nette\Database\Connection;

class MySqlPlayerRepository implements PlayerRepository
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function searchByUser(UserId $userId): ?Player
    {
        $data = $this->connection->fetch('
            SELECT 
                p.id as player_id, 
                p.user_id, 
                p.bank_account,
                p.address,
                pt.name as player_type, 
                pt.points_coefficient as points_coefficient
            FROM players  p
            INNER JOIN users u on p.user_id = u.id
            INNER JOIN player_types pt on p.type_id = pt.id
            WHERE p.user_id = ?', $userId->value());

        if ($data === null) {
            return null;
        }

        return new Player(
            new PlayerId((int)$data->player_id),
            new UserId((int)$data->user_id),
            new Grade((string)$data->player_type),
            new Coefficient((int)$data->points_coefficient),
            new BankAccount((string)$data->bank_account),
            new Address((string)($data->address))
        );
    }

    public function search(PlayerId $id): ?Player
    {
        $data = $this->connection->fetch('
            SELECT 
                p.id as player_id, 
                p.user_id, 
                p.bank_account,
                p.address,
                pt.name as player_type, 
                pt.points_coefficient as points_coefficient
            FROM players  p
            INNER JOIN player_types pt on p.type_id = pt.id
            WHERE p.id = ?', $id->value());

        if ($data === null) {
            return null;
        }

        return new Player(
            new PlayerId((int)$data->player_id),
            new UserId((int)$data->user_id),
            new Grade((string)$data->player_type),
            new Coefficient((int)$data->points_coefficient),
            new BankAccount((string)$data->bank_account),
            new Address((string)($data->address))
        );
    }
}