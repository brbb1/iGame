<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
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

    public function search(UserId $userId, PlayerId $playerId, DrawId $drawId): ?Terms
    {
        $termsData = $this->connection->query('
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
            INNER JOIN users u on p.user_id = u.id
            INNER JOIN  players_draws pd on p.id = pd.player_id
            INNER JOIN draws d on pd.draw_id = d.id
            WHERE p.id = ? and p.user_id = ? AND d.id = ?', $playerId->value(), $userId->value(), $drawId->value());

        if ($termsData->getRowCount() === 0) {
            return null;
        }

        $term = $termsData[0];
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