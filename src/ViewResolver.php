<?php
  namespace Massfice\SymfonyAjaxEngine;

  use Massfice\Storage\ShelfBuilder;
  use Massfice\Storage\Storage;
  use Massfice\SelectingViewResolver\SelectingViewResolver;

  use Symfony\Component\HttpFoundation\Response;

  class ViewResolver {

    private $gmethod;
    private $cmethod;

    public function __construct() {

      Storage::getInstance()->setOverrideAllowed(false)->setModifyAllowed(false);

      ShelfBuilder::getBuilder()
        ->setJsonAllowed(true)
        ->setOverrideAllowed(false)
        ->build()
        ->addToStorage('view_resolver_containers');

      ShelfBuilder::getBuilder()
        ->setJsonAllowed(true)
        ->build()
        ->addToStorage('view_resolver_content')
        ->getBuilder()
        ->build()
        ->addToStorage('view_resolver_data');

        ShelfBuilder::getBuilder()
          ->build()
          ->addToStorage('view_resolver_templates_data');

        $this->gmethod = new GeneratorMethod();
        $this->cmethod = new ComparatorMethod();

        $this->content('blank');

    }

    public function assign(string $key, $var) : self {

      Storage::getInstance()->getShelf('view_resolver_templates_data')->addData($key,$var,true);

      return $this;
    }

    public function content(string $file_name, string $element_id = 'content') : self {
      $this->gmethod->generateContent($file_name,$element_id);

      return $this;
    }

    public function display(string $container = '') : Response {
      $resolver = new SelectingViewResolver();
      return new Response($resolver->resolve($container, $this->gmethod, $this->cmethod));
    }

  }
?>
