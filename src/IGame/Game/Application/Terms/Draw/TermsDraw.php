<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Terms\Draw;

use Brbb\IGame\Game\Domain\Prize\Type;
use Brbb\IGame\Game\Domain\Terms\Terms;

class TermsDraw
{
    // Если огранниченные призы разыграны, присваеваем неограниченный
    public function defaultDraw(Terms $terms): Type
    {
        // На основе условий создаем массив для выбора какой приз создавать
        $pointsChance = $terms->pointsChance()->value();
        $moneyChance  = $terms->moneyChance()->value();
        $objectChance = $terms->objectChance()->value();

        $defaultPrize = [
            'count' => $terms->maxPoints()->value(),
            'type'  => Type::points,
        ];

        $prizes = [
            $pointsChance => $defaultPrize,

            $pointsChance + $moneyChance => [
                'count' => $terms->budget()->value(),
                'type'  => Type::money,
            ],

            $pointsChance + $moneyChance + $objectChance => [
                'count' => $terms->objectChance()->value(),
                'type'  => Type::object,
            ],
        ];

        // Розынрыш приза
        /** @noinspection PhpUnhandledExceptionInspection */
        $percent = random_int(0, 99);

        // Если все деньги или вещи были уже разыграны, начисляем очки
        $validPrize = $defaultPrize;
        foreach ($prizes as $prizePercent => $prize) {
            if ($percent >= $prizePercent) {
                continue;
            }

            if ($prize['count'] === 0) {
                break;
            }

            $validPrize = $prize;
            break;
        }

        return $validPrize['type'];
    }
}