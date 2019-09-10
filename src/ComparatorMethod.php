<?php
  namespace Massfice\SymfonyAjaxEngine;

  use Massfice\Storage\Storage;
  use Massfice\SessionUtils\SessionUtils;

  class ComparatorMethod implements \Massfice\SelectingViewResolver\Comparator\ComparatorMethod {

    private static $containers_hierarchy;

    public static function addContainer(string $container, string $parent = '') {
      if(!isset(self::$containers_hierarchy[$parent])) $parent = '';
      if($container != 'blank') self::$containers_hierarchy[$container] = $parent;
    }

    private function getHierarchy(string $container) : array {

      $a = self::$containers_hierarchy;

      $p3 = $container;
      $p3 = $p3 == '' ? 'blank' : $p3;

      $p2 = isset($a[$p3]) && $a[$p3] != '' ? $a[$p3] : 'blank';
      $p1 = isset($a[$p2]) && $a[$p2] != '' ? $a[$p2] : 'blank';
      $p0 = isset($a[$p1]) && $a[$p1] != '' ? $a[$p1] : 'blank';

      $hierarchy = array($p0,$p1,$p2,$p3);

      return $hierarchy;
    }

    public function makeCompare(string $seed, string $prev) : array {

      $b = SessionUtils::advancedLoad('init_shelf','b',false);

      $b = $b === null ? false : $b;

      $hseed = $this->getHierarchy($seed);
      $hprev = $this->getHierarchy($prev);
      if(!$b)
      {
        for($i = 0; $i < count($hseed) && $i < count($hprev); $i++) {
          $r[] = $hseed[$i] == $hprev[$i] ? '' : $hseed[$i];
        }

        return $r;
      } else {
        return $hseed;
      }
    }

  }
?>
