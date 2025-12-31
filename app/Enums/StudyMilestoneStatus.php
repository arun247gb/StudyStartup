<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self notStarted()
 * @method static self inProgress()
 * @method static self completed()
 * @method static self blocked()
 * @method static self cancelled()
 */
class StudyMilestoneStatus extends Enum
{
    public static function values(): array
    {
        return [
            'notStarted' => 1,
            'inProgress' => 2,
            'completed'  => 3,
            'blocked'    => 4,
            'cancelled'  => 5,
        ];
    }

    public static function labels(): array
    {
        return [
            'notStarted' => 'Not Started',
            'inProgress' => 'In Progress',
            'completed'  => 'Completed',
            'blocked'    => 'Blocked',
            'cancelled'  => 'Cancelled',
        ];
    }

    /**
     * Get the Enum instance from DB value
     *
     * @param mixed $value
     * @return self
     */
    public static function fromValue($value): self
    {
        return static::from($value);
    }

    /**
     * Get human-readable label from value
     *
     * @param mixed $value
     * @return string
     */
    public static function getAttribute($value): string
    {
        $values = static::values();
        $key = array_search($value, $values);

        if ($key !== false) {
            $labels = static::labels();
            return $labels[$key];
        }

        return '';
    }
}
