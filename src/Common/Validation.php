<?php

namespace SimDex\Common;

class Validation
{
    public static function validateEmail(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePhone(string $value): string|bool
    {

    }

    public static function validateDomain(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_DOMAIN);
    }

    public static function validateIP(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_IP);
    }

    public static function validateIPv4(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
    
    public static function validateURL(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED, FILTER_FLAG_HOST_REQUIRED);
    }

    public static function validateAddress(string $value): string|bool
    {
        
    }

    public static function validateCity(string $value): string|bool
    {
        
    }

    public static function validateState(string $value): string|bool
    {
        
    }

    public static function validateZIP(string $value): string|bool
    {
        
    }

    public static function validateCountry(string $value): string|bool
    {
        
    }
}