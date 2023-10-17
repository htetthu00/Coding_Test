<?php

namespace App\Helpers;

class SanctumAuth 
{
    public static function CheckApiAuth() 
    {
        if(auth('sanctum')->user()) {
            return true;
        } else {
            return false;
        }
    }
}