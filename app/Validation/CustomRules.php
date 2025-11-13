<?php 
namespace App\Validation;

class CustomRules
{
    public function required_if($value, string $fields, array $data): bool
    {
        [$field, $expected] = explode(',', $fields);

        if (($data[$field] ?? null) === $expected) {
            return ! empty($value);
        }

        return true; // passes if condition not met
    }
}
