<?php


namespace App\Helpers;


use App\Entities\User;
use Ramsey\Uuid\Uuid;

class UuidHelper
{
    /**
     * Generates UUID4
     *
     * @return string
     */
    public static function generateUuid()
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public static function generateApiToken(User $user)
    {
        return hash_hmac('sha256', strtolower(trim($user->id . $user->updated_at)), config('app.key'));
    }
}