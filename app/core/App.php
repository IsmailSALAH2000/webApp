<?php
class App
{
    private $controller = 'home';
    private $method = 'index';

    public function splitUrl()
    {
        $url = $_GET['url'] ?? 'home'; // if $_GET['url'] is not set, use 'home' as default
        $url = explode('/', trim($url,"/"));
        return $url;
    }

    public function loadController()
    {
        $url = $this->splitUrl();
        $filename = "../app/controllers/" . ucfirst($url[0]) . ".php";
        if(file_exists($filename))
        {
            require $filename;
            $this->controller = ucfirst($url[0]);
            unset($url[0]);

        }else{
            $filename = "../app/controllers/_404.php";
            require $filename;
            $this->controller = "_404";
            unset($url[0]);
        }
        
        if(!empty($url[1]))
        {
            if(method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        //instancier le controller
        $controller = new $this->controller;
        call_user_func_array([$controller, $this->method], $url);
    }
}