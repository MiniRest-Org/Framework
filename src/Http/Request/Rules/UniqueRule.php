<?php

namespace MiniRestFramework\Http\Request\Rules;

use MiniRestFramework\Http\Request\RequestValidation\ValidationRule;
use MiniRestFramework\Support\Facades\DB;

class UniqueRule implements ValidationRule
{

    protected string $table;
    protected string $column;
    protected ?int $ignoreId;

    public function __construct(string $table, string $column = 'email', ?int $ignoreId = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
    }

    public function passes($value, $params = []): bool
    {
        $query = DB::table($this->table)->where($this->column, $value);

        if ($this->ignoreId !== null) {
            $query->where('id', '!=', $this->ignoreId);
        }

        return $query->first() === null;
    }

    public function errorMessage($field, $params = []): string
    {
        return "O campo $field já está em uso.";
    }
}