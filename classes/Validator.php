<?php

class Validator
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): bool
    {
        foreach ($rules as $field => $fieldRules) {
            $value = $this->data[$field] ?? null;

            foreach ($fieldRules as $rule => $param) {
                if (is_int($rule)) {
                    $rule = $param;
                    $param = null;
                }

                $method = 'validate' . ucfirst($rule);
                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $param);
                } else {
                    throw new Exception("Unknown validation rule: $rule");
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    // ==== RULE METHODS ====

    private function validateRequired(string $field, $value): void
    {
        if (is_null($value) || trim($value) === '') {
            $this->addError($field, 'This field is required.');
        }
    }

    private function validateEmail(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'Invalid email format.');
        }
    }

    private function validateMin(string $field, $value, int $min): void
    {
        if (strlen(trim($value)) < $min) {
            $this->addError($field, "Minimum length is $min characters.");
        }
    }

    private function validateMax(string $field, $value, int $max): void
    {
        if (strlen(trim($value)) > $max) {
            $this->addError($field, "Maximum length is $max characters.");
        }
    }

    private function validateLength(string $field, $value, int $length): void
    {
        if (strlen(trim($value)) != $length) {
            $this->addError($field, "Length must be $length characters.");
        }
    }

    private function validateNumber(string $field, $value): void
    {
        if (!is_numeric($value)) {
            $this->addError($field, 'This field must be a number.');
        }
    }

    private function validatePhone(string $field, $value): void
    {
        if (!preg_match('/^\+?\d-\d{3}-\d{3}-\d{4}$/', $value)) {
            $this->addError($field, 'Invalid phone number format.');
        }
    }

    // ==== Error Handling ====

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}
