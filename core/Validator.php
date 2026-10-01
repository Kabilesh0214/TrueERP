<?php
class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        foreach ($rules as $field => $ruleStr) {
            $ruleList = explode('|', $ruleStr);
            $val = $data[$field] ?? null;

            foreach ($ruleList as $rule) {
                if ($rule === 'required' && (empty($val) && $val !== '0')) {
                    $this->errors[$field][] = ucfirst($field) . " is required.";
                }
                if ($rule === 'email' && !empty($val) && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = ucfirst($field) . " must be a valid email.";
                }
            }
        }
        return empty($this->errors);
    }

    public function getErrors(): array { return $this->errors; }
}
