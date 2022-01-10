<?php

class AppController {
    private $request;

    public function __construct() {
        $this->request=$_SERVER['REQUEST_METHOD'];
    }

    protected function isGet():bool {
        return $this->request === 'GET';
    }

    protected function isPost():bool {
        return $this->request === 'POST';
    }

    protected function render(string $template = null, array $variables = []) {
        if(!isset($_COOKIE['userEmail']) && !in_array($template, ['login', 'register', '']) && $this->isGet()) {
            $template = 'login';
            $variables = ['messages' => ['Musisz się zalogować']];
        }

        $templatePath = 'public/views/'.$template.'.php';
        $output = 'File not found';

        if(file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }

        print $output; 
    }

    protected function isLogged(): bool {
        if(isset($_COOKIE['userEmail'])) {
            return true;
        }

        $template = 'login';
        $variables = ['messages' => ['Musisz się zalogować']];

        $this->render($template, $variables);

        return false;
    }

}