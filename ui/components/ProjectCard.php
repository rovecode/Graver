<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/Space.php");

class ProjectCard extends Component
{
  private $Size = "135px";
  private $PictureLink;
  private $RedirectLink;
  private $Title;
  
  /// Title
  function SetTitle(string $string) {
    $this->Title = $string;
    return $this;
  }

  /// RedirectLink
  function SetRedirectLink(string $string) {
    $this->RedirectLink = $string;
    return $this;
  }

  /// RedirectLink
  function SetPictureLink(string $string) {
    $this->PictureLink = $string;
    return $this;
  }

  /// Size
  function SetSize(string $string) {
    $this->Size = $string;
    return $this;
  }

  /// Build
  function BuildContent() : Element {
    return (new Picture)
    ->SetPosition(PicturePositions::Center)
    ->SetRepeat(PictureRepeats::NoRepeat)
    ->SetSize(PictureSizes::Cover)
    ->SetLink($this->PictureLink)
    ->SetChild(
      (new Column)
      ->SetMainAlign(MainAxisAligns::Center)
      ->SetCrossAlign(CrossAxisAligns::Center)
      ->AddThemeParameter(Padding, Px(10))
      ->AddChild(
        (new Text)
        ->AddThemeKey("on_show_x_translate")
        ->AddThemeParameter(AnimationDelay, "0.2s")
        ->AddThemeParameter(FontSize, Px(32))
        ->SetText(mb_substr($this->Title, 0, 1))
      )
      ->AddChild(
        (new Text)
        ->AddThemeKey("on_show_x_translate")
        ->AddThemeParameter(AnimationDelay, "0.4s")
        ->AddThemeParameter(FontWeight, 300)
        ->SetText($this->Title)
      )
    );
  }

  function Build() : Node {
    return (new Link)
    ->AddThemeParameter(TextDecoration, None)
    ->AddThemeParameter(Color, Black)
    ->SetLink($this->RedirectLink)
    ->SetChild(
      (new Container)
      ->AddThemeParameter(MinWidth, $this->Size)
      ->AddThemeParameter(MaxWidth, $this->Size)
      ->AddThemeParameter(Width, $this->Size)
      ->AddThemeParameter(MinHeight, $this->Size)
      ->AddThemeParameter(MaxHeight, $this->Size)
      ->AddThemeParameter(Height, $this->Size)
      ->AddThemeKey("graver_project_card")
      //->AddThemeParameter(Padding, Px(5))
      ->SetChild($this->BuildContent())
    );
  }
}