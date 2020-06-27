<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../themes/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");

class AuthTeample extends Component
{
  private $Child;
  private $Title;

  function __construct(string $title) {
    $this->Child = new Container;
    $this->Title = $title;
  }

  /// Child
  function SetChild(Node $child) {
    $this->Child = $child;
    return $this;
  }

  function GetChild() : Node {
    return $this->Child;
  }

  /// Build
  function BuildLeft() : Element {
    return (new Column)
    ->AddThemeKey("graver_left_auth_picture")
    ->SetCrossAlign(CrossAxisAligns::Center)
    ->SetMainAlign(MainAxisAligns::Center)
    ->AddChild(
      (new Text)
      ->AddThemeKeys(["graver_left_auth_title", "graver_auth_title"])
      ->SetText("graver")
    );
  }

  function BuildRight() : Element {
    return (new VerticalScrollView)
    ->AddThemeKey("graver_auth_form_background")
    ->SetChild(
      (new Column)
      ->SetCrossAlign(CrossAxisAligns::Center)
      ->SetMainAlign(MainAxisAligns::Center)
      ->AddThemeParameter(Padding, [
        Px(50),
        Px(25)
      ])
      ->AddChild(
        (new Container)
        ->AddThemeKey("on_show_translate")
        ->AddThemeParameter(MaxWidth, Px(500))
        ->AddThemeParameter(Height, Auto)
        ->SetChild(
          (new Column)
          ->SetChilds([
            (new Text)
            ->AddThemeKeys([
              "graver_auth_form_title", 
              "not_tablet", 
              "not_desktop"
            ])
            ->SetText("graver"),
            (new Space)
            ->SetSpace(Px(25)),
            $this->Child
          ])
        )
      )
    );
  }

  function Build() : Node {
    return (new Document)
    ->SetTitle($this->Title . ", graver.com")
    ->AddTheme(GetGraverTheme())
    ->AddThemes(GetAdaptiveThemes())
    ->SetChild(
      (new Stack)
      ->AddThemeKey("graver_page_background")
      ->SetChilds([
        (new Picture)
        ->SetLink(Url("https://www.muralswallpaper.com/app/uploads/Green-Tropical-Plant-Wallpaper-Mural-Room-820x532.jpg")) //
        ->SetRepeat(PictureRepeats::NoRepeat)
        ->SetSize(PictureSizes::Cover)
        /*->SetChild(
          (new Container)
          //->AddThemeParameter(BackgroundColor, Hex("00000010"))
          ->AddThemeParameter(BackdropFilter, Blur(Px(1)))
        )*/,
        (new Row)
        ->SetChilds([
          $this->BuildLeft()
          ->AddThemeKey("not_mobile"),
          (new Separator)->Build()
          ->AddThemeParameter(BackgroundColor, Hex("ffffff33"))
          ->AddThemeKey("not_mobile"),
          (new Separator)->Build()
          ->AddThemeKey("not_mobile"),
          $this->BuildRight()
        ])
      ])
    );
  }
}

//Node::Run((new AuthTeample)->Build());