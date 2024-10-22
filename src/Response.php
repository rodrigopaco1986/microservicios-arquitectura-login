<?php

namespace Rpj\Login;

class Response
{
    public function __construct(
        private bool $success = true,
        private string $message = '',
        private array $data = [],
    ) {}

    public function setData(array $data): void
    {
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
        echo 'exit';
        exit();
    }
}
