<?php
  namespace Massfice\SymfonyAjaxEngine;

  use Twig\Loader\FilesystemLoader;
  use Twig\Environment;
  use Massfice\Storage\Storage;

  class GeneratorMethod implements \Massfice\SelectingViewResolver\Generator\GeneratorMethod {

    public function generateView(array $array) : string {

      $loader = new FilesystemLoader(__DIR__.'/templates/containers');
      $twig = new Environment($loader);

      $storage = Storage::getInstance();
      $shelf = $storage->getShelf('view_resolver_containers');
      $data = $storage->getShelf('view_resolver_templates_data')->getAllData();

      for($i = 0; $i < count($array); $i++) {
        if($array[$i] != '') {
          $template = $twig->load($array[$i].'.html.twig');
          $shelf->addData($i.'_header',$template->renderBlock('header',$data));
          $shelf->addData($i.'_footer',$template->renderBlock('footer',$data));
        }
      }

      return $storage->makeJson();
    }

    public function generateContent(string $file_name, string $element_id) {
      $loader = new FilesystemLoader(__DIR__.'/templates/content');
      $twig = new Environment($loader);

      $template = $twig->load($file_name.'.html.twig');

      $data = Storage::getInstance()->getShelf('view_resolver_templates_data')->getAllData();

      Storage::getInstance()->getShelf('view_resolver_content')->addData($element_id,$template->render($data),true);
    }

  }
?>
