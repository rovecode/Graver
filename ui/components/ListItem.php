<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../themes/include.php");

class ListItem extends Component
{
  private $Title;
  private $Prefix;
  private $Link;
  private $Icon = Icons::List;

  function SetLink(string $string) {
    $this->Link = $string;
    return $this;
  }

  function SetPrefix(Node $string) {
    $this->Prefix = $string;
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

  function BuildsContent() {
    return (new Row)
    ->SetCrossAlign(CrossAxisAligns::Center)
    ->AddThemeParameter(Padding, [Px(9), Px(20)])
    ->AddChild(
      (new Text)
      ->AddThemeKey("material_icons")
      ->AddThemeParameter(Color, Hex("4242429c"))
      ->AddThemeParameter(PaddingRight, Px(10))
      ->SetText($this->Icon)
    )
    ->AddChild(
      (new HorizontalScrollView)
      ->AddThemeKey("graver_hide_scrollbar")
      ->SetChild(
        (new Column)
        ->SetMainAlign(MainAxisAligns::Center)
        ->AddChild(
          (new Text)
          ->AddThemeParameter(WhiteSpace, "pre")
          ->AddThemeParameter(Width, Pr(100))
          ->AddThemeParameter(Color, Black)
          ->SetText($this->Title)
        )
      )
    )
    ->AddChild(
      $this->Prefix == null ? new COntainer : $this->Prefix
    );
  }

  function Build() : Node {
    return $this->Link != "" 
    ? (new Link)
      ->AddThemeKey("graver_list_item")
      ->AddThemeParameter(Width, Pr(100))
      ->AddThemeParameter(TextDecoration, None)
      ->SetLink($this->Link)
      ->SetChild( $this->BuildsContent() )
    : (new Container)
      ->AddThemeKey("graver_list_item")
      ->AddThemeParameter(Width, Pr(100))
      ->AddThemeParameter(TextDecoration, None)
      ->SetChild($this->BuildsContent());
  }
}