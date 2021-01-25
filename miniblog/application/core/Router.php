<?php
class Router {
    protected $routes;
    public function __construct($definitions) {
        $this->routes = $this->compileRoutes($definitions);
    }

    public function compileRoutes($definitions) {
        $routes = [];

        foreach ($definitions as $url => $params) {
            // URLを'/’で分割
            $tokens = explode('/', ltrim($url, '/'));
            foreach($tokens as $i => $token) {
                // ':'で始まる文字列が存在した場合は、':'以下の文字列を抜き出し、正規表現の形式に直す
                if(0 === strpos($token, ':')) {
                    $name = substr($token, 1);
                    $token = '(?P<' . $name . '>[^/]+)';
                }
                $tokens[$i] = $token;
            }

            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }

        return $routes;
    }

    public function resolve($path_info) {
        // $path_infoの先頭が'/'でない場合に'/'を付与する
        if('/' !== substr($path_info, 0, 1)) {
            $path_info = '/' . $path_info;
        }

        
        foreach($this->routes as $pattern => $params) {
            if(preg_match('#^' . $pattern . '$#', $path_info, $matches)) {
                // 正規表現にマッチした文字列を配列合致してルーティングパラメータを返す
                $params = array_merge($params, $matches); 

                return $params;
            }
        }

        return false;
    }
}
