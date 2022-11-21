<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\MaterialObject\MaterialObject;
use Brbb\IGame\Game\Domain\MaterialObject\MaterialObjectRepository;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Player\PlayerIdNull;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\Shared\Domain\Primitives\Name;
use Nette\Database\Connection;

class MySqlMaterialObjectRepository implements MaterialObjectRepository
{

    public function __construct(private readonly Connection $connection)
    {
    }

    public function search(PlayerId $playerId, PrizeId $id): ?MaterialObject
    {
        $row = $this->connection->fetch('
            SELECT 
                p.id as id,
                p.status as status,
                p.player_id as player_id,
                po.name as name 
            FROM player_objects  p
            INNER JOIN prize_objects po on p.object_id = po.id
            WHERE p.id = ? AND p.player_id = ?'
            , $id->value(), $playerId->value());

        if ($row === null) {
            return null;
        }

        return new MaterialObject(
            new PrizeId((int)$row->id),
            Status::from((string)$row->status),
            new Name((string)$row->name) ,
            new PlayerId((int)$row->player_id),
        );
    }

    public function save(MaterialObject $prize): MaterialObject
    {
        $this->connection->query('
            UPDATE player_objects SET status = ? WHERE id = ?'
            , $prize->status()->value, $prize->id()->value());

        return $prize;
    }

    /** @return MaterialObject[] */
    public function searchAvailable(TermsId $id): array
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
            $objects[] = new MaterialObject(new PrizeId((int)$data->id), Status::NotDraw, new Name($data->name), new PlayerIdNull(0));
        }

        return $objects;
    }

    public function create(PlayerId $playerId, TermsId $termsId, MaterialObject $object): MaterialObject
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

        return new MaterialObject(new PrizeId((int)$id), Status::Created, $object->name(), $playerId);
    }
}