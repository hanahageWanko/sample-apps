<?php
class ClassLoader
{
    protected $dirs;

    public function register()
    {
        // オートロード時に第二引数に登録したクラスをコールする(ここではloadClass)
        spl_autoload_register([$this, 'loadClass']);
    }

    public function registerDir($dir)
    {
        // オートロードの対象とするディレクトリへのプロパティを指定する
        $this->dirs[] = $dir;
    }

    public function loadClass($class)
    {
        foreach ($this->dirs as $dir) {
            // dirsプロパティの中に$class.phpがあるかを確認し、存在するときは読み込む
            $file = $dir . '/' . $class . '.php';
            if (is_readable($file)) {
                require $file;
                return;
            }
        }
    }
}
