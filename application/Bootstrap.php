<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initDbConfig() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $params = array('host' => $config->database->hostname,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->database);
        $db = Zend_Db::factory($config->database->type, $params);
        Zend_Registry::set('db', $db);
        
       //Zend_Db_Table::setDefaultAdapter($db);
    }
    

}

