<?php

namespace MiniRestFramework\Http\Request\RequestValidation;

use Exception;
use MiniRestFramework\Exceptions\RuleNotFound;

class ValidationRuleFactory
{
    /**
     * @throws Exception
     */
    public static function createRule($ruleName, array $params = []): ValidationRule
    {
        $className =  "MiniRestFramework\\Http\Request\\Rules\\" .
            ucfirst($ruleName) . 'Rule';

        if (class_exists($className)) {

            return new $className(...$params);
        }

        throw new RuleNotFound("Regra de validação {$ruleName} não encontrada.");
    }
}