<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Terms\Terms;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\IGame\Game\Domain\Terms\TermsRepository;
use Brbb\IGame\Shared\Domain\Chance;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\Primitives\Count;
use Brbb\Shared\Domain\Primitives\Name;
use Nette\Database\Connection;

class MySqlTermsRepository implements TermsRepository
{

    public function __construct(private readonly Connection $connection)
    {
    }

    public function search(PlayerId $playerId, DrawId $drawId): ?Terms
    {
        $term = $this->connection->fetch('
            SELECT 
                d.id as id,
                d.name as name,
                d.point_chance as points_chance,
                d.max_points as max_points,
                d.money_chance as money_chance,
                d.current_budget as budget,
                d.object_chance as object_chance,
                d.current_object_ctn as object_count
            FROM players  p
            INNER JOIN  players_draws pd on p.id = pd.player_id
            INNER JOIN draws d on pd.draw_id = d.id
            WHERE p.id = ? AND d.id = ? AND pd.count > 0'
            , $playerId->value(), $drawId->value());

        if ($term === null) {
            return null;
        }

        return new Terms(
            new TermsId((int) $term->id),
            new Name((string) $term->name),
            new Chance((int) $term->points_chance),
            new Count((int) $term->max_points),
            new Chance((int) $term->money_chance),
            new Count((int) $term->budget),
            new Chance((int) $term->object_chance),
            new Count((int) $term->object_count),
        );
    }

    public function searchByMoney(PrizeId $id): ?Terms
    {
        $term = $this->connection->fetch('
            SELECT 
                d.id as id,
                d.name as name,
                d.point_chance as points_chance,
                d.max_points as max_points,
                d.money_chance as money_chance,
                d.current_budget as budget,
                d.object_chance as object_chance,
                d.current_object_ctn as object_count
            FROM draws  d
            INNER JOIN prize_money pm on d.id = pm.draw_id
            WHERE pm.id = ?'
            , $id->value());

        if ($term === null) {
            return null;
        }

        return new Terms(
            new TermsId((int) $term->id),
            new Name((string) $term->name),
            new Chance((int) $term->points_chance),
            new Count((int) $term->max_points),
            new Chance((int) $term->money_chance),
            new Count((int) $term->budget),
            new Chance((int) $term->object_chance),
            new Count((int) $term->object_count),
        );

    }
}