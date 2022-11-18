<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

class SubjectTypeMap
{
    public final const POINTS = 'points';
    public final const MONEY  = 'money';
    public final const OBJECT = 'object';


    public final const TYPE_SUBJECT = [
        self::POINTS => Points::class,
        self::MONEY => Money::class,
        self::OBJECT => MaterialObject::class,
    ];

    public final const SUBJECT_TYPE = [
        Points::class         => self::POINTS,
        Money::class          => self::MONEY,
        MaterialObject::class => self::OBJECT,
    ];
}