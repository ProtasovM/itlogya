<?php

class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function params()
    {
        return array_merge(
            $this->get(),
            $this->post(),
        );
    }

    public function get(): array
    {
        return $_GET;
    }

    public function post(): array
    {
        return $_POST;
    }

    public function uri()
    {
        return explode(
            '?',
            $_SERVER['REQUEST_URI']
        )[0];
    }

    public function isPage(string $page): bool
    {
        return str_contains(
            $this->uri(),
            $page
        );
    }
}