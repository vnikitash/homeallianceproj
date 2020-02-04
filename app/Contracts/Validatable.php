<?php
declare(strict_types = 1);

namespace App\Contracts;

/**
 * Interface Validatable
 * @package App\Validation
 */
interface Validatable
{
    /**
     * @return array
     */
    public function validated();
}
