<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/29/19
 * Time: 4:04 PM
 */

namespace App\Security;


class TokenGenerator
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public function getRandomSecureToken(int $length): string
    {
        $maxNumber = strlen(self::ALPHABET);
        $token = '';

        for ($i = 0; $i < $length; $i++){
            $token .= self::ALPHABET[random_int(0, $maxNumber -1)];
        }

        return $token;
    }
}