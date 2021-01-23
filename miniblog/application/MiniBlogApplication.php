<?php
class MiniBlogApplication extends Application
{
    protected $login_action = ['account', 'signin'];
        
    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    public function registerRoutes()
    {
        return [];
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
