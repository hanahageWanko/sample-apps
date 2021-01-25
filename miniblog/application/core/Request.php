<?php
class Request
{
    public function getBaseUrl()
    {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $request_uri = $this->getRequestUri();
        // 第一引数の中から第二引数に指定した文字列が出現するかどうかを確認
        if (0 === strpos($request_uri, $script_name)) {
            // 存在した場合BaseUrl === ScriptNameとなるため、$scirpt_nameを返却
            return $script_name;
        } else if (0 === strpos($request_uri, dirname($script_name))) {
              // フロントコントローラが省略されている場合に、フロントコントローラを省略したディレクトリで抜き出す
              // 最後の'/'を削除することにより、path_infoにあたる[/list]などの部分を必ず'/'付きで指定できるようにするため
            return rtrim(dirname($script_name), '/');
        }
        return '';
    }

    public function getPathInfo()
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        if (false !== ($pos = strpos($request_uri, '?'))) {
            $request_uri = substr($request_uri, 0, $pos);
        }
        $path_info = (string)substr($request_uri, strlen($base_url));

        return $path_info;
    }
    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }
        return false;
    }

    public function getGet($name, $default = null)
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }

        return $default;
    }

    public function getPost($name, $default = null)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return $default;
    }

    public function getHost()
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }
        return $_SERVER['SERVER_NAME'];
    }

    public function isSsl()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return true;
        }
        return false;
    }

    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
