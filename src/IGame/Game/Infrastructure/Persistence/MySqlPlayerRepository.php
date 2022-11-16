<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Player\Player;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Game\Domain\Player\Grade;
use Brbb\IGame\Game\Domain\Prize\Money;
use Brbb\IGame\Game\Domain\Prize\MaterialObject;
use Brbb\IGame\Game\Domain\Prize\Points;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\SubjectId;
use Brbb\IGame\Shared\Domain\Address;
use Brbb\IGame\Shared\Domain\BankAccount;
use Brbb\IGame\Shared\Domain\Coefficient;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\Primitives\Count;
use Brbb\Shared\Domain\Primitives\Name;
use Nette\Database\Connection;

class MySqlPlayerRepository implements PlayerRepository
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function search(UserId $userId, PlayerId $playerId): ?Player
    {
        $playersData = $this->connection->query('
            SELECT 
                p.id as player_id, 
                p.user_id, 
                p.bank_account,
                p.address,
                pt.name as player_type, 
                pt.points_coefficient as points_coefficient,
                pp.id as point_id,
                pp.count as points,
                pm.id as money_id,
                pm.count as money,
                o.id as object_id,
                o.name as object_name
            FROM players  p
            INNER JOIN users u on p.user_id = u.id
            INNER JOIN player_types pt on p.type_id = pt.id
            LEFT JOIN player_points pp on p.id = pp.player_id 
            LEFT JOIN players_money pm on p.id = pm.player_id
            LEFT JOIN players_objects po on p.id = po.player_id
            LEFT JOIN objects o on po.object_id = o.id
            WHERE p.id = ? and p.user_id = ?', $playerId->value(), $userId->value());

        if ($playersData->getRowCount() === 0) {
            return null;
        }

        $prizes = [];
        foreach ($playersData as $data) {
            if ($data->points !== null) {
                $prizes[] = new Prize(
                    new Points(new SubjectId((int) $data->point_id), new Count((int) $data->points))
                );

                continue;
            }

            if ($data->money !== null) {
                $prizes[] = new Prize(
                    new Money(new SubjectId((int) $data->money_id), new Count((int) $data->money))
                );

                continue;
            }

            if ($data->object_name !== null) {
                $prizes[] = new Prize(
                    new MaterialObject(new SubjectId((int) $data->object_id), new Name((string) $data->object_name))
                );
            }
        }

        return new Player(
            new PlayerId((int)$data->player_id),
            new UserId((int)$data->user_id),
            new Grade((string)$data->player_type),
            new Coefficient((int)$data->points_coefficient),
            new BankAccount((string)$data->bank_account),
            new Address((string)($data->address)),
            $prizes
        );
    }
}