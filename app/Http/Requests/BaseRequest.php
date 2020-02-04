<?php
declare(strict_types = 1);

namespace App\Http\Requests;

use App\DTO\BaseDTO;
use App\Contracts\Validatable;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseRequest
 * @package App\Http\Requests
 */
class BaseRequest extends FormRequest implements Validatable
{
    protected const DTO_CLASS = null;

    /**
     * BaseRequest constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     * @throws \Exception
     */
    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        if (!static::DTO_CLASS || !class_exists(static::DTO_CLASS)) {
            throw new \Exception('Incorrect DTO class');
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return (static::DTO_CLASS)::compiledRules();
    }

    /**
     * Convert validatable object to DTO
     *
     * @return mixed
     */
    public function toBag(): BaseDTO
    {
        $className = static::DTO_CLASS;

        $dtoClass = new $className($this, $this->user());

        //Auto build DTO class from Request and call all the required setters
        foreach ($this->validated() as $field => $value) {
            $setterMethod = "set" . $this->underscoreToCamelCase($field, true);
            if (method_exists($dtoClass, $setterMethod)) {
                $dtoClass->$setterMethod($value);
            }
        }

        return $dtoClass;
    }

    /**
     * @param $string
     * @param bool $capitalizeFirstCharacter
     * @return string
     */
    private function underscoreToCamelCase($string, $capitalizeFirstCharacter = false): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        return $capitalizeFirstCharacter ? $str : lcfirst($str);
    }
}
