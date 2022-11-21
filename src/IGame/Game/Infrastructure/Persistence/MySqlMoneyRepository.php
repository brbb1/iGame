<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\Persistence;

use Brbb\IGame\Game\Domain\Money\Money;
use Brbb\IGame\Game\Domain\Money\MoneyRepository;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\Shared\Domain\Primitives\Count;
use Nette\Database\Connection;

class MySqlMoneyRepository implements MoneyRepository
{

    public function __construct(private readonly Connection $connection)
    {
    }

    public function search(PlayerId $playerId, PrizeId $id): ?Money
    {
        $row = $this->connection->fetch('
            SELECT 
                p.id as id,
                p.status as status,
                p.count as count,
                p.player_id as player_id
            FROM player_money  p
            WHERE p.id = ? AND p.player_id = ?'
            , $id->value(), $playerId->value());

        if ($row === null) {
            return null;
        }

        return new Money(
            new PrizeId((int)$row->id),
            Status::from((string)$row->status),
            new Count((int)$row->count) ,
            new PlayerId((int)$row->player_id),
        );
    }

    public function save(Money $prize): Money
    {
        $this->connection->query('
            UPDATE player_money SET status = ? WHERE id = ?'
        , $prize->status()->value, $prize->id()->value());

        return $prize;
    }

    public function money(PlayerId $playerId, TermsId $termsId, Count $money): Money
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

        return new Money(new PrizeId((int)$id), Status::Created, $money, $playerId);
    }

    public function replace(PrizeId $moneyId, PrizeId $prizeId): void
    {
        $this->connection->query('
            UPDATE player_money SET points_prize_id = ? WHERE id = ?'
            , $prizeId->value(), $moneyId->value());
    }
}