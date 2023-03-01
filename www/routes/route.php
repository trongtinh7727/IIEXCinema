<?php
$routeList = [];
class Route
{
    public static function add($routeName, $action)
    {
        $GLOBALS['routeList'][] = ['name' => $routeName, 'action' => $action];
    }

    public static function run()
    {
        $request = $_SERVER['REQUEST_URI'];
        foreach ($GLOBALS['routeList'] as $r) {
            if ($r['name'] == $request) {
                return $r['action'];
            }
        }
    }
}
