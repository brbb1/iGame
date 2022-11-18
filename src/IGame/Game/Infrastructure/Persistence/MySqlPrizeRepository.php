<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\MaterialObject;
use Brbb\IGame\Game\Domain\Prize\Money;
use Brbb\IGame\Game\Domain\Prize\Points;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\PrizeRepository;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Prize\SubjectId;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\Shared\Domain\Primitives\Count;
use Brbb\Shared\Domain\Primitives\Name;
use Nette\Database\Connection;

class MySqlPrizeRepository implements PrizeRepository
{

    public function __construct(private readonly Connection $connection)
    {
    }

    public function searchAvailableObjects(TermsId $id): array
    {
        $objectsData = $this->connection->query('
            SELECT 
                pro.id as id,
                pro.name as name
            FROM prize_objects pro
            LEFT JOIN player_objects plo on pro.id = plo.object_id
            WHERE pro.draw_id = ? AND plo.player_id IS NULL; 
        '
            , $id->value());

        $objects = [];
        foreach ($objectsData as $data) {
            $objects[] = new Prize(
                new MaterialObject(new SubjectId((int) $data->id), Status::NotDraw,  new Name($data->name))
            );
        }

        return $objects;
    }

    public function creatPointsPrize(PlayerId $playerId, TermsId $termsId, Count $points): Prize
    {
        $this->connection->query('
            UPDATE players_draws SET count = count - 1 WHERE player_id = ? AND draw_id = ?;

            INSERT INTO player_points (player_id, points_id, status, count) 
            VALUES (?, (SELECT id FROM prize_points WHERE draw_id = ?), ?, ?)
            '
            , $playerId->value(), $termsId->value()
            , $playerId->value(), $termsId->value(), Status::Created->value, $points->value());

        $id = $this->connection->getInsertId();

        return new Prize(
            new Points(new SubjectId((int) $id), Status::Created, $points)
        );
    }

    public function createMoneyPrize(PlayerId $playerId, TermsId $termsId, Count $money): Prize
    {
        $this->connection->query('
            UPDATE draws d SET current_budget = current_budget - ? WHERE id = ? ;

            UPDATE players_draws SET count = count - 1 WHERE player_id = ? AND draw_id = ?;

            INSERT INTO player_money (player_id, money_id, status, count) 
            VALUES (?, (SELECT id FROM prize_money WHERE draw_id = ?), ?, ?);
            '
            , $money->value(), $termsId->value()
            , $playerId->value(), $termsId->value()
            , $playerId->value(), $termsId->value(), Status::Created->value, $money->value());

        $id = $this->connection->getInsertId();

        return new Prize(
            new Money(new SubjectId((int) $id), Status::Created, $money)
        );
    }

    public function createObjectPrize(PlayerId $playerId, TermsId $termsId, MaterialObject $object): Prize
    {
        $this->connection->query('
            UPDATE draws d SET current_object_ctn = current_object_ctn - 1 WHERE id = ? ;

            UPDATE players_draws SET count = count - 1 WHERE player_id = ? AND draw_id = ?;

            INSERT INTO player_objects (player_id, object_id, status) 
            VALUES (?, ?, ?);
            '
            , $termsId->value()
            , $playerId->value(), $termsId->value()
            , $playerId->value(), $object->id()->value(), Status::Created->value);

        $id = $this->connection->getInsertId();

        return new Prize(
            new MaterialObject(new SubjectId((int) $id), Status::Created, $object->name())
        );

    }
}