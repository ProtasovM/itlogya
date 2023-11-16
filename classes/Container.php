<?php

class Container
{
    private static self $instance;
    private array $container;

    private function __construct()
    {}

    public static function instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __set($key, $value)
    {
        $this->container[$key] = $value;
    }

    public function __get($key)
    {
        if (!isset($this->container[$key]))
        {
            return null;
        }
        return $this->container[$key];
    }
}