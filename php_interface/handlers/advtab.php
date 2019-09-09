<?php
/**
 * Created by PhpStorm.
 * User: koe
 * Date: 09.09.19
 * Time: 22:30
 */


class AdvTab
{
    const FORM_NAME = "form_element_5";
    const DIV_TAB = "seo_adv_seo_adv";

    function removeAdvTab(&$form)
    {
        if ($form->name == self::FORM_NAME)
        {
            foreach ($form->tabs as &$value)
            {
                if ($value["DIV"] == self::DIV_TAB)
                    $value = [];
            }
        }
    }
}