<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");

class ProjectTile extends Component
{
  private $Link;
  private $Title;
  private $SubTitle;
  private $Splash;

  function SetLink(string $string) {
    $this->Link = $string;
    return $this;
  }

  function SetSplash(bool $string) {
    $this->Splash = $string;
    return $this;
  }

  function SetTitle(string $string) {
    $this->Title = $string;
    return $this;
  }

  function SetSubTitle(string $string) {
    $this->SubTitle = $string;
    return $this;
  }

  function Build() : Node {
    return (new Link)
    ->SetLink($this->Link)
    ->AddThemeKey($this->Splash == false ? "on_show_x_translate" : "")
    ->AddThemeParameter(AnimationDuration, "0.45s")
    ->AddThemeParameter(Width, Pr(100))
    ->AddThemeParameter(Height, Px(60))
    ->AddThemeKey("graver_button")
    ->SetChild(
      (new Column)
      ->AddChild(
        (new Text)
        ->AddThemeKey($this->Splash == false ? "on_show_x_translate" : "")
        ->AddThemeParameter(AnimationDuration, "0.45s")
        ->AddThemeParameter(AnimationDelay, "0.25s")
        ->AddThemeParameter(PaddingTop, Px(3))
        ->AddThemeParameter(Color, Black)
        ->SetText($this->Title)
      )
      ->AddChild(
        (new Text)
        ->AddThemeKey($this->Splash == false ? "on_show_x_translate" : "")
        ->AddThemeParameter(AnimationDuration, "0.45s")
        ->AddThemeParameter(AnimationDelay, "0.35s")
        ->AddThemeParameter(FontWeight, 500)
        ->AddThemeParameter(FontSize, Px(12))
        ->AddThemeParameter(Color, Gray)
        ->SetText($this->SubTitle)
      )
    );
  }
}