<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../themes/include.php");

class ListItem extends Component
{
  private $Title;
  private $Link;
  private $Icon = Icons::List;

  function SetLink(string $string) {
    $this->Link = $string;
    return $this;
  }

  function SetIcon(string $string) {
    $this->Icon = $string;
    return $this;
  }

  function SetTitle(string $string) {
    $this->Title = $string;
    return $this;
  }

  function Build() : Node {
    return (new Link)
    ->AddThemeKey("graver_list_item")
    ->AddThemeParameter(Width, Pr(100))
    ->AddThemeParameter(TextDecoration, None)
    ->SetLink($this->Link)
    ->SetChild(
      (new Row)
      ->SetCrossAlign(CrossAxisAligns::Center)
      ->AddThemeParameter(Padding, [Px(9), Px(20)])
      ->AddChild(
        (new Text)
        ->AddThemeKey("material_icons")
        ->AddThemeParameter(Color, Hex("4242429c"))
        ->SetText($this->Icon)
      )
      ->AddChild(
        (new Text)
        ->AddThemeParameter(PaddingLeft, Px(10))
        ->AddThemeParameter(Color, Black)
        ->SetText($this->Title)
      )
    );
  }
}