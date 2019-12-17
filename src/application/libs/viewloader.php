<?php

class ViewLoader
{
    public static function load($template, $args = null)
    {
        if (is_array($args)) {
            foreach ($args as $name => $value) {
                $$name = $value;
            }
        }

        require_once  'application/views/'.$template.'.php';
    }

    public static function loadString($template, $args = null){
        if (is_array($args)) {
            foreach ($args as $name => $value) {
                $$name = $value;
            }
        }

        return require_once 'application/views/'.$template.'.php';
    }
}
