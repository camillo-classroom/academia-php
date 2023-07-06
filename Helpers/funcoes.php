<?php 
    //Retorna um novo GUID (Identificador Único Global)
    function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    function Bcrypt($texto, $salt)
    {
        return crypt($texto, $salt);
    }

    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log('.json_encode($output, JSON_HEX_TAG).');';

        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }

        echo $js_code;
    }
?>