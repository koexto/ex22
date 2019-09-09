<?php
/**
 * Created by PhpStorm.
 * User: koe
 * Date: 09.09.19
 * Time: 23:36
 */

class Event404
{
    function event404Log()
    {
        if (defined("ERROR_404") && ERROR_404 == "Y")
        {
            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                "DESCRIPTION" => $url,
            ));
        }

    }
}