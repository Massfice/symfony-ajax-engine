<?php
  namespace Massfice\SymfonyAjaxEngine;

  class UserConfig {

    public static function config() {
      ComparatorMethod::addContainer('ja');
      ComparatorMethod::addContainer('ja2','ja');
    }

  }
?>
