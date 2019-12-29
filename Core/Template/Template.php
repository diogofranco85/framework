<?php

namespace Core\Template;

class Template{
    
    private $twig;
    private $loader; 
    public $debug = TRUE;
    private $html = null;

    public function __construct(){
        $this->loader = new \Twig\Loader\FilesystemLoader(ROOT.DS.'App'.DS.'View'.DS);
        $this->twig = new \Twig\Environment($this->loader, 
            [
            'cache' => ROOT.DS.'App'.DS.'Cache',
            'debug' => $this->debug
            ]
        );

        $this->registerFunctions();
    }

    public function render($filename, array $context = array()){
        $file = "{$filename}.html.twig";
        return  $this->twig->render($file, $context);        
    }

    private function registerFunctions(){
        $this->url();
        $this->assets();
        $this->import_js();
        $this->import_css();
        $this->titleUrl();
    }

    private function url()
    {
        $url_base = new \Twig\TwigFunction('url', function($uri = '/'){
            $base = SITE_URL;
            echo "{$base}{$uri}";
        });
        $this->twig->addFunction($url_base);
    }

    private function assets(){
        $assets = new \Twig\TwigFunction('assets', function($uri){
            $base = SITE_URL;
            echo "{$base}/Assets/{$uri}";
        });
        $this->twig->addFunction($assets);
    }

    public function import_js(){
        
        $import_js = new \Twig\TwigFunction('js',function($name){
            $this->include();
           $base = SITE_URL;
           $import = $this->html['js'];
            if(array_key_exists($name,$import)){
                if(is_array($import[$name])){
                    foreach( $import[$name] as $js)
                    {
                        echo "<script src='{$base}/Assets/{$js}'></script> \n";
                    }
                }else{
                    $filename = $import[$name];
                    echo "<script src='{$base}/Assets/{$filename}'></script>";
                }
            }else{
                throw new \Exception('Provider HTML não existe');
            }
        });
        $this->twig->addFunction($import_js);

    }

    public function import_css(){
        
        $import_js = new \Twig\TwigFunction('css',function($name){
           $this->include();
           $base = SITE_URL;
           $import = $this->html['css'];
            if(array_key_exists($name,$import)){
                if(is_array($import[$name])){
                    foreach( $import[$name] as $css)
                    {
                        echo "<link rel='stylesheet' href='{$base}/Assets/{$css}'> \n";
                    }
                }else{
                    $filename = $import[$name];
                    echo "<link rel='stylesheet' href='{$base}/Assets/{$filename}'>";
                }
            }else{
                throw new \Exception('Provider HTML não existe');
            }
        });
        $this->twig->addFunction($import_js);

    }

    private function include(){
        $uri = ROOT.DS.'App'.DS.'Services'.DS.'htmlProvides.php';
        if(file_exists($uri)){
            if($this->html == null){
                $this->html = require_once($uri);
            }
        }else{
            throw new \Exception('Arquivo provider html não existe');
        }      
    }

    public function titleUrl(){
        $fncTitle = new \Twig\TwigFunction('title_replace',function($title){
            $strTitle = str_replace('á','a',$title);
            $strTitle = str_replace('à','a',$strTitle);
            $strTitle = str_replace('ã','a',$strTitle);
            $strTitle = str_replace('â','a',$strTitle);
            $strTitle = str_replace('è','e',$strTitle);
            $strTitle = str_replace('é','e',$strTitle);
            $strTitle = str_replace('ê','e',$strTitle);
            $strTitle = str_replace('ẽ','e',$strTitle);
            $strTitle = str_replace('í','i',$strTitle);
            $strTitle = str_replace('ì','i',$strTitle);
            $strTitle = str_replace('ò','o',$strTitle);
            $strTitle = str_replace('ó','o',$strTitle);
            $strTitle = str_replace('ô','o',$strTitle);
            $strTitle = str_replace('õ','o',$strTitle);
            $strTitle = str_replace('ú','u',$strTitle);
            $strTitle = str_replace('ù','u',$strTitle);
            $strTitle = str_replace('ç','c',$strTitle);
            $strTitle = str_replace(' ','_',$strTitle);

            echo $strTitle;
        });

        $this->twig->addFunction($fncTitle);
    }

}

