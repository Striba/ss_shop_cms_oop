<?php

/**
 * Подключение шаблонизатора Smarty
 *
 */
class Smartyload {
    
    /**
     * Подключение шаблонизатора Smarty
     *
     * @return obj $smarty
     */
    public static function getSmarty() {
        
        //>Инициализация шаблонизатора Smarty:
        $smarty = new Smarty();

        $smarty->setTemplateDir(TemplaxtePrefix);
        $smarty->setCompileDir( ROOT . '/tmp/smarty/templates_c');
        $smarty->setCacheDir( ROOT . '/tmp/smarty/cache');
        $smarty->setConfigDir( ROOT . '/library/Smarty/configs');

        $smarty->assign('templateWebPath', TemplateWebPath);
        //<

        return $smarty;
    }
  
}
