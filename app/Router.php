<?php

namespace App;

use App\DB;
use stdClass;

class Router
{
    protected static $request_uri;
    protected static $request_method;
    protected static $request_data;


    /**
     * Instantiate the class properties with HTTP Request data.
     *
     * @param  string  $request_method HTTP Request method
     * @param  string  $request_uri HTTP Request URI
     * @param  array  $request_data GET or POST data
     * @return void
     */
    public function __construct(string $request_method, $request_uri, array $request_data = [])
    {
        self::$request_method = $request_method;
        self::$request_uri = $request_uri;
        self::$request_data = $request_data;
    }

    /**
     * Routes the URI of the GET method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public static function get(string $route, string $targetControllerPath, string $controllerMethod)
    {
        $request_data = self::$request_data;
        
        if(self::$request_method == 'GET' && self::$request_uri == $route){
            $class = new $targetControllerPath;
            return call_user_func_array( array( $class, $controllerMethod ),  array($request_data)); //$class->method()
        }
    }

    /**
     * Routes the URI of the POST method to the specified controller.
     *
     * @param  string  $route The user specified route, as it appears in the Request URI
     * @param  string  $targetControllerPath The fully qualified namespace path to the target controller
     * @param  string  $controllerMethod The method that will be called in the target controller
     * @return mix
     */
    public static function post(string $route, string $targetControllerPath, string $controllerMethod)
    {
        $request_data = self::$request_data;
        
        if(self::$request_method == 'POST' && self::$request_uri == $route){
            $class = new $targetControllerPath;
            return call_user_func_array( array( $class, $controllerMethod ),  array($request_data)); //$class->method()
        }
    }

}