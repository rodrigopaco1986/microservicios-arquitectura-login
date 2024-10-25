<?php

namespace Rpj\Login;

class Response
{
    public function __construct(
        private bool $success = true,
        private string $message = '',
        private array $data = [],
    ) {}

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setValues(bool $success, string $message = '', array $data = []): void
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;

    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    public function terminate()
    {
        exit();
    }
}
