<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Draw\Draw;
use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Draw\DrawRepository;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\Primitives\Count;
use Brbb\Shared\Domain\Primitives\Name;
use Nette\Database\Connection;

class MySqlDrawRepository implements DrawRepository
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /** @return Draw[] */
    public function searchAll(PlayerId $playerId): array
    {
        $drawData = $this->connection->query('
            SELECT 
                pd.count as count,
                d.id as id,
                d.name as name
            FROM players  p
            INNER JOIN  players_draws pd on p.id = pd.player_id
            INNER JOIN draws d on pd.draw_id = d.id
            WHERE p.id = ?'
            , $playerId->value());

        if ($drawData->getRowCount() === 0) {
            return [];
        }

        $draws = [];
        foreach ($drawData as $draw) {
           $draws[] = new Draw(new DrawId((int) $draw->id),new Name((string) $draw->name), new Count((int) $draw->count));
        }

        return $draws;
    }
}