<?php


namespace App\Settings;


class Settings
{

    protected $settings = [];
    protected $entity;


    public function __construct($entity)
    {
        $this->entity = $entity;
        $settings = $entity->settings;

        $this->settings = array_merge(
            $this->settings, is_null($settings) ? [] : $settings);
    }

    public function get($key)
    {
        return array_get($this->settings, $key);
    }

    public function set($key, $value)
    {
        $this->settings[$key] = $value;
        $this->persist();
    }

    public function all()
    {
        return $this->settings;
    }

    public function merge(array $attributes)
    {
        $this->settings = array_merge(
            $this->settings,
            array_only($attributes, array_keys($this->settings))
        );

        return $this->persist();
    }

    public function persist()
    {
        return $this->entity->update(['settings' => $this->settings]);
    }

    public function __get($key)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }
        throw new \Exception("The {$key} settings does not exist.");
    }

    protected function has($key)
    {
        return array_key_exists($key, $this->settings);
    }
}