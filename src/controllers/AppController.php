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

    protected function isLogged() {
        if(!isset($_COOKIE['userEmail'])) {
            $template = 'login';
            $variables = ['messages' => ['Musisz się zalogować']];

            return $this->render($template, $variables);
        }

        return true;
    }

    protected function decodeCompetitionID() {
        $coded = $this->isGet() ? $_GET['id'] : $_POST['id'];

        $code = base64_decode($coded);
        $code = str_replace(COMP_HASH, "", $code);
        $code = str_split($code, strlen($code)/2 + 2);
        $code = base64_decode($code[0]);

        return base64_decode($code);
    }
}