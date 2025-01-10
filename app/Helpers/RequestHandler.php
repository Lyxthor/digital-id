<?php
namespace App\Helpers;

class RequestHandler
{
    public static function handle(callable $func)
    {
        try
        {
            return $func();
        }
        catch(\Exception $e)
        {
            RequestHandler::redirect($e->getMessage());
        }
    }
    public static function redirect($messages)
    {
        dd($messages);
    }
}
