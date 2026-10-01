<?php
class Response
{
    public function setStatusCode(int $code): self
    {
        http_response_code($code);
        return $this;
    }

    public function json(mixed $data, int $status = 200): string
    {
        $this->setStatusCode($status);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}
