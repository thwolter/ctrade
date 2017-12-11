<?php

namespace App\Services\Settings;

use App\Exceptions\ServiceException;

trait Settingable
{
    private $settingsInstance;


    public function getSettingsInstance()
    {
        if (!$this->settingsService or !class_exists($this->settingsService)) {
            throw new ServiceException("'settings' property not defined.");
        }

        if (!isset($this->settingsInstance)) {
            $this->settingsInstance = new $this->settingsService($this);
        }

        return $this->settingsInstance;
    }


    public function settings($key = null)
    {
        $settings = $this->getSettingsInstance();
        return $key ? $settings->get($key) : $settings;
    }
}