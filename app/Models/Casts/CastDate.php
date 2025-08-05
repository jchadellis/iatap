<?php

namespace App\Models\Cast;

use CodeIgniter\DataCaster\Cast\BaseCast;
use InvalidArgumentException;

// The class must inherit the CodeIgniter\DataCaster\Cast\BaseCast class
namespace App\Casts;

use CodeIgniter\Entity\Cast\BaseCast;
use CodeIgniter\I18n\Time;

class CastDate extends BaseCast
{
    public static function get($value, array $params = [])
    {
        // Convert to CI4 Time object or DateTime
        return Time::parse($value); // or new \DateTime($value)
    }

    public static function set($value, array $params = [])
    {
        // Convert to a storable format (string)
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        return $value; // Assume it's already a string
    }
}