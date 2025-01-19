<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RequestHandler
{
    public static function handle(callable $func)
    {
        try
        {
            return $func();
        }
        catch(\Throwable $e)
        {
            return RequestHandler::redirect($e->getMessage());
        }
    }
    public static function redirect($messages)
    {
        return redirect()
        ->back()
        ->with('error', $messages);
    }
}
