<?php


namespace App\Services\SettingServices;

use App\Exceptions\Settings\SettingsException;


class BaseSettings
{

    protected $settings = [];
    protected $entity;
    protected $index = false;
    protected $human = false;


    public function __construct($entity)
    {
        $this->entity = $entity;
        $settings = $entity->settings;

        $this->settings = array_merge(
            $this->settings, is_null($settings) ? [] : $settings);
    }

    public function get($key)
    {
        $value = array_get($this->settings, $key);

        if ($this->index) {
            $result = $this->mapToIndex($key, $value);
        }

        elseif ($this->human) {
            $result = $this->mapToHuman($key, $value);
        }

        else {
            $result = $value;
        }

        return $result;
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

    public function only($attributes)
    {
        return array_only($this->all(), $attributes);
    }

    public function merge(array $attributes)
    {
        $attributes = $this->mapAttributes($attributes);

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


    public function toValue($i, $array)
    {
        return array_values($this->$array)[$i];
    }


    public function keys($array)
    {
        return array_keys($this->$array);
    }

    public function index()
    {
        $this->index = true;
        return $this;
    }

    public function human()
    {
        $this->human = true;
        return $this;
    }


    //
    // private functions
    //

    private function mapAttributes($attributes)
    {
        $result = [];
        foreach (array_keys($attributes) as $key)
        {
            if (isset($this->{$key})) {
                $result[$key] = array_values($this->{$key})[$attributes[$key]];
            } else {
                $result[$key] = $attributes[$key];
            }
        }
        return $result;
    }


    private function mapToIndex($map, $value)
    {
        if (!isset($this->{$map}))
            throw new SettingsException("A mapping array '{$map}' is required.");

        $result = array_index($value, $this->{$map});
        $this->index = false;

        return $result;
    }

    private function mapToHuman($map, $value)
    {
        if (!isset($this->{$map}))
            throw new SettingsException("A mapping array '{$map}' is required.");

        $found = array_search($value, $this->{$map});
        $result = ($found) ? $found : $map;
        $this->human = false;

        return $result;
    }
}