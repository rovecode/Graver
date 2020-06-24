<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/Space.php");

class ArticleCard extends Component
{
  private $PictureLink;
  private $RedirectLink;
  private $Title;
  private $ImageHeight = "225px";
  
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

  /// ImageHeight
  function SetImageHeight(string $string) {
    $this->ImageHeight = $string;
    return $this;
  }

  /// Build
  function BuildPicture() : Element {
    return (new Picture)
    ->AddThemeParameter(BorderBottom, [Px(1), Solid, Hex("8484849e")])
    ->AddThemeParameter(Height, $this->ImageHeight)
    ->AddThemeParameter(BorderRadius, Px(5))
    ->SetPosition(PicturePositions::Center)
    ->SetRepeat(PictureRepeats::NoRepeat)
    ->SetSize(PictureSizes::Cover)
    ->SetLink($this->PictureLink);
  }

  function BuildBottom() : Element {
    return (new Row)
    ->AddThemeParameter(Padding, [Px(15), Px(30)])
    ->AddThemeParameter(Height, Auto)
    ->SetCrossAlign(CrossAxisAligns::Center)
    ->AddChild(
      (new Text)
      ->AddThemeParameter(FontSize, Px(16))
      ->AddThemeParameter(Width, Pr(100))
      ->SetText($this->Title)
    )
    ->AddChild(
      (new Link)
      ->SetLink($this->RedirectLink)
      ->SetChild(
        (new Button)
        ->AddThemeParameter(Width, Auto)
        ->AddThemeKey("on_show_x_translate")
        ->AddThemeParameter(AnimationDelay, "0.2s")
        ->AddThemeKey("graver_button")
        ->SetText("Читать")
      )
    );
  }

  function Build() : Node {
    return (new Container)
    ->AddThemeParameter(Height, Auto)
    ->AddThemeParameter(BorderRadius, Px(5))
    ->AddThemeParameter(Border, [Px(1), Solid, Hex("8c8c8c3b")])
    ->AddThemeParameter(BorderTop, [Px(1), Solid, Hex("ffffffe0")])
    ->AddThemeParameter(BorderBottom, [Px(1), Solid, Hex("8080808c")])
    ->SetChild(
      (new Picture)
      ->AddThemeParameter(BorderRadius, Px(5))
      ->SetPosition(PicturePositions::Center)
      ->SetRepeat(PictureRepeats::NoRepeat)
      ->SetSize(PictureSizes::Cover)
      ->SetLink($this->PictureLink)
      ->SetChild(
        (new Column)
        ->AddThemeParameter(Height, Auto)
        ->AddThemeParameter(BorderRadius, Px(5))
        ->AddThemeKey("graver_auth_form_background")
        ->AddChild($this->BuildPicture())
        ->AddChild($this->BuildBottom())
      )
    );
  }
}