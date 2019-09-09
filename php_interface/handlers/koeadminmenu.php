<?php
class KoeAdminMenu
{
    const MANAGER_GROUP_ID = 5;

    function changeMenuForManager(&$aGlobalMenu, &$aModuleMenu)
    {
        global $USER;
        if ($USER->IsAdmin())
            return;

        if (in_array(self::MANAGER_GROUP_ID, $USER->GetUserGroupArray()))
        {
            $aGlobalMenuContent = $aGlobalMenu["global_menu_content"];
            $aGlobalMenu = [];
            $aGlobalMenu["global_menu_content"] = $aGlobalMenuContent;

            $newsMenu = static::newsMenu($aModuleMenu);
            $aModuleMenu = [];
            $aModuleMenu[] = $newsMenu;
        }
    }

    static function newsMenu($aModuleMenu)
    {
        foreach ($aModuleMenu as $key => $value)
        {
            if ($value["items_id"] === "menu_iblock_/news")
            {
                $newsMenu = $aModuleMenu[$key];
                return $newsMenu;
            }
        }
    }
}