<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Draw\Draw;
use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Draw\DrawRepository;
use Brbb\IGame\Game\Domain\Player\Player;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\MaterialObject;
use Brbb\IGame\Game\Domain\Prize\Money;
use Brbb\IGame\Game\Domain\Prize\Points;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\SubjectId;
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
    public function searchAll(UserId $userId, PlayerId $playerId): array
    {
        $drawData = $this->connection->query('
            SELECT 
                pd.count as count,
                d.id as id,
                d.name as name
            FROM players  p
            INNER JOIN users u on p.user_id = u.id
            INNER JOIN  players_draws pd on p.id = pd.player_id
            INNER JOIN draws d on pd.draw_id = d.id
            WHERE p.id = ? and p.user_id = ?', $playerId->value(), $userId->value());

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