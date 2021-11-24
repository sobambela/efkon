<?php

namespace App;

use stdClass;

class Router
{
    protected $request_uri;
    protected $request_method;

    public function __construct(string $request_method, $request_uri)
    {
        $this->request_method = $request_method;
        $this->request_uri = $request_uri;
    }

    public static function get(string $route, string $targetControllerPath, string $method){
        if(self::$request_method == 'GET' && self::$request_uri == $route){
            $class = new $targetControllerPath;
            return call_user_func( array( $class, $class ) ); //$class->method()
        }
    }

    public static function post(string $route, string $targetControllerPath, string $method){
        if(self::$request_method == 'POST' && self::$request_uri == $route){
            $class = new $targetControllerPath;
            return call_user_func( array( $class, $class ) ); //$class->method()
        }
    }

}