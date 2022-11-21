<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\MaterialObject\MaterialObject;
use Brbb\IGame\Game\Domain\Money\Money;
use Brbb\IGame\Game\Domain\Player\Grade;
use Brbb\IGame\Game\Domain\Player\Player;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Game\Domain\Points\Points;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
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

    private function prepareData($playersData): Player
    {
        $prizes = [];
        foreach ($playersData as $data) {
            if ($data->points !== null) {
                $prizes[] = new Points(
                    new PrizeId((int)$data->point_id),
                    Status::from($data->points_status),
                    new Count((int)$data->points),
                    new PlayerId($data->player_id),
                );

                continue;
            }

            if ($data->money !== null) {
                $prizes[] = new Money(
                    new PrizeId((int)$data->money_id),
                    Status::from($data->money_status),
                    new Count((int)$data->money),
                    new PlayerId($data->player_id),
                );

                continue;
            }

            if ($data->object_name !== null) {
                $prizes[] = new MaterialObject(
                    new PrizeId((int)$data->object_id),
                    Status::from($data->object_status),
                    new Name((string)$data->object_name),
                    new PlayerId($data->player_id),
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

    public function searchByUser(UserId $userId): ?Player
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
                pp.status as points_status,
                pp.count as points,
                pm.id as money_id,
                pm.status as money_status,
                pm.count as money,
                po.id as object_id,
                po.status as object_status,
                o.name as object_name
            FROM players  p
            INNER JOIN users u on p.user_id = u.id
            INNER JOIN player_types pt on p.type_id = pt.id
            LEFT JOIN player_points pp on p.id = pp.player_id 
            LEFT JOIN player_money pm on p.id = pm.player_id
            LEFT JOIN player_objects po on p.id = po.player_id
            LEFT JOIN prize_objects o on po.object_id = o.id
            WHERE p.user_id = ?', $userId->value());

        if ($playersData->getRowCount() === 0) {
            return null;
        }

        return $this->prepareData($playersData);
    }

    public function search(PlayerId $id): ?Player
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
                pp.status as points_status,
                pp.count as points,
                pm.id as money_id,
                pm.status as money_status,
                pm.count as money,
                po.id as object_id,
                po.status as object_status,
                o.name as object_name
            FROM players  p
            INNER JOIN player_types pt on p.type_id = pt.id
            LEFT JOIN player_points pp on p.id = pp.player_id 
            LEFT JOIN player_money pm on p.id = pm.player_id
            LEFT JOIN player_objects po on p.id = po.player_id
            LEFT JOIN prize_objects o on po.object_id = o.id
            WHERE p.user_id = ?', $id->value());

        if ($playersData->getRowCount() === 0) {
            return null;
        }

        return $this->prepareData($playersData);
    }
}