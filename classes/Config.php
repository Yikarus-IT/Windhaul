<?php
class Config
{
    private array $settings = [];

    public function __construct(string $configFile)
    {
        if (!file_exists($configFile)) {
            throw new Exception("Config file not found: $configFile");
        }
        $this->settings = require $configFile;
        if (!is_array($this->settings)) {
            throw new Exception("Config file must return an array");
        }
    }

    /**
     * Get a config value by key with optional default
     */
    public function get(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Magic getter for config properties
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }
}
