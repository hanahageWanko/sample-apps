<?php
class MiniBlogApplication extends Application
{
    protected $login_action = ['account', 'signin'];

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes()
    {
        return [
            '/'
                => ['controller' => 'status', 'action' => 'index'],
            '/status/post'
                => ['controller' => 'status', 'action' => 'post'],
            // '/user/:user_name'
            //     => array('controller' => 'status', 'action' => 'user'),
            // '/user/:user_name/status/:id'
            //     => array('controller' => 'status', 'action' => 'show'),
            '/account'
                => ['controller' => 'account', 'action' => 'index'],
            '/account/:action'
                => ['controller' => 'account'],
            // '/follow'
            //     => array('controller' => 'account', 'action' => 'follow'),
        ];
    }

    protected function configure()
    {
        $this->db_manager->connect(
            'master', 
            [
            'dsn'      => 'mysql:dbname=perfect_php;host=127.0.0.1',
            'user'     => 'root',
            'password' => ''
            ]
        );
    }
}
