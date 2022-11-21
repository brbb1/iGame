<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Points\Points;
use Brbb\IGame\Game\Domain\Points\PointsRepository;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\Shared\Domain\Primitives\Count;
use Nette\Database\Connection;

class MySqlPointsRepository implements PointsRepository
{

    public function __construct(private readonly Connection $connection)
    {
    }

    public function search(PlayerId $playerId, PrizeId $id): ?Points
    {
        $row = $this->connection->fetch('
            SELECT 
                p.id as id,
                p.status as status,
                p.player_id as player_id,
                p.count as count
            FROM player_points  p
            WHERE p.id = ? AND p.player_id = ?'
            , $id->value(), $playerId->value());

        if ($row === null) {
            return null;
        }

        return new Points(
            new PrizeId((int)$row->id),
            Status::from((string)$row->status),
            new Count((int)$row->count) ,
            new PlayerId((int)$row->player_id),
        );
    }

    public function save(Points $prize): Points
    {
        $this->connection->query('
            UPDATE player_points SET status = ? WHERE id = ?'
            , $prize->status()->value, $prize->id()->value());

        return $prize;
    }

    public function create(PlayerId $playerId, TermsId $termsId, Count $points): Points
    {
        $this->connection->query('
            UPDATE players_draws SET count = count - 1 WHERE player_id = ? AND draw_id = ?;

            INSERT INTO player_points (player_id, points_id, status, count) 
            VALUES (?, (SELECT id FROM prize_points WHERE draw_id = ?), ?, ?)
            '
            , $playerId->value(), $termsId->value()
            , $playerId->value(), $termsId->value(), Status::Delivered->value, $points->value());

        $id = $this->connection->getInsertId();

        return new Points(new PrizeId((int)$id), Status::Delivered, $points, $playerId);
    }

    public function searchAllByDraw(PlayerId $playerId, DrawId $drawId): array
    {
        $rows = $this->connection->query('
            SELECT 
                plp.id as id,
                plp.status as status,
                plp.count as count,
                plp.player_id as player_id
            FROM players p
            INNER JOIN players_draws pd on p.id = pd.player_id and pd.draw_id = ?
            INNER JOIN draws d on pd.draw_id = d.id
            INNER JOIN prize_points pp on d.id = pp.draw_id
            INNER JOIN player_points plp on p.id = plp.player_id
            WHERE p.id = ?'
            , $drawId->value(), $playerId->value());

        if ($rows->getRowCount() === 0) {
            return [];
        }

        $result = [];
        foreach ($rows as $row) {
            $result[] = new Points(
                new PrizeId((int)$row->id),
                Status::from((string)$row->status),
                new Count((int)$row->count),
                new PlayerId((int)$row->player_id),
            );
        }

        return $result;
    }
}