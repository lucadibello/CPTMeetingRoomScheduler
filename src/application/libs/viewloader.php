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

    public static function load_full($template)
    {
        require_once  'application/views/_templates/header.php';
        require_once  'application/views/'.$template.'.php';
        require_once  'application/views/_templates/footer.php';
    }
}
