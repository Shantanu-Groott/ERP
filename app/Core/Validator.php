<?php

namespace App\Core;

class Validator
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data, array $rules): self
    {
        $validator = new self($data);
        $validator->validate($rules);
        return $validator;
    }

    public function validate(array $rules): void
    {
        foreach ($rules as $field => $fieldRules) {
            $ruleList = is_string($fieldRules) ? explode('|', $fieldRules) : $fieldRules;
            $value = $this->data[$field] ?? null;

            foreach ($ruleList as $rule) {
                $params = [];
                if (strpos($rule, ':') !== false) {
                    [$rule, $paramStr] = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                }

                if ($rule === 'required' && (is_null($value) || trim((string)$value) === '')) {
                    $this->addError($field, "The {$field} field is required.");
                    break;
                }

                if (!empty($value)) {
                    if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($field, "The {$field} must be a valid email address.");
                    }
                    if ($rule === 'min' && strlen((string)$value) < (int)$params[0]) {
                        $this->addError($field, "The {$field} must be at least {$params[0]} characters.");
                    }
                    if ($rule === 'max' && strlen((string)$value) > (int)$params[0]) {
                        $this->addError($field, "The {$field} may not be greater than {$params[0]} characters.");
                    }
                    if ($rule === 'numeric' && !is_numeric($value)) {
                        $this->addError($field, "The {$field} must be a number.");
                    }
                    if ($rule === 'in' && !in_array($value, $params)) {
                        $this->addError($field, "The selected {$field} is invalid.");
                    }
                }
            }
        }
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function first(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
}
