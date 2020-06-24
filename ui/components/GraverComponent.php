<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");

abstract class GraverComponent extends Component
{
  abstract function Theme() : Theme;

  abstract function Build() : Element;
}