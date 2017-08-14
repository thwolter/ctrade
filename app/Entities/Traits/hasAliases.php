<?php


namespace App\Entities\Traits;


use App\Entities\Alias;
use App\Entities\Exchange;

trait hasAliases
{

    /**
     * Assign and persist an alias for the current entity.
     *
     * @param string|array $alias
     * @return Exchange
     */
    public function alias($alias)
    {
        foreach ((array)$alias as $value) {
            $mapping = new Alias(['alias' => $value]);
            $mapping->mappable()->associate($this)->save();
        }
        return $this;
    }


    public static function whereAlias($alias)
    {
        return self::whereHas('mappings', function ($query) use ($alias) {
            $query->where('alias', '=', $alias);
        });
    }

    public static function whereCodeOrAlias($alias)
    {
        $result = self::whereCode($alias);

        if (!$result->count()) {
            $result = self::whereAlias($alias);
        }

        return $result;
    }

    public static function whereNameOrAlias($alias)
    {
        $result = self::whereName($alias);

        if (!$result->count()) {
            $result = self::whereAlias($alias);
        }

        return $result;
    }

}