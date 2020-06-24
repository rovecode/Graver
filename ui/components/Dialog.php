<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/Space.php");

class Dialog extends Component
{
  private $BackRedirect = "#";
  private $ToRedirect = "#";
  private $Title = "Title";
  private $OkButtonText = ""; 
  private $CancelButtonText = "";
  private $Child = " ";

  /// BackRedirect
  function SetBackRedirect(string $string) {
    $this->BackRedirect = $string;
    return $this;
  }

  /// ToRedirect
  function SetToRedirect(string $string) {
    $this->ToRedirect = $string;
    return $this;
  }

  /// Title
  function SetTitle(string $string) {
    $this->Title = $string;
    return $this;
  }

  /// CancelButtonText
  function SetCancelText(string $string) {
    $this->CancelButtonText = $string;
    return $this;
  }

  /// PkButtonText
  function SetOkText(string $string) {
    $this->OkButtonText = $string;
    return $this;
  }

  /// Childs
  function SetChild($value) {
    $this->Child = is_string($value)
      ? (new Text)->SetText($value)
      : $value;
    return $this;
  }

  /// Build
  function Build() : Node {
    return (new Column)
    ->SetCrossAlign(CrossAxisAligns::Center)
    ->SetMainAlign(MainAxisAligns::Center)
    ->AddChild(
      (new Action)
      ->SetType(ActionTypes::Post)
      ->AddThemeKey("adaptive_dialog")
      ->SetRedirect($this->ToRedirect)
      ->SetChild(
        (new Column)
        ->AddThemeKey("on_show_translate")
        ->SetMainAlign(MainAxisAligns::Center)
        ->AddThemeParameter(BackgroundColor, Hex("f1f1f157"))
        ->AddThemeParameter(Padding, [Px(35), Px(25)])
        ->AddThemeParameter(BorderRadius, Px(5))
        ->AddThemeParameter(Border, [Px(1), Solid, Hex("8c8c8c3b")])
        ->AddThemeParameter(BorderTop, [Px(1), Solid, Hex("ffffffe0")])
        ->AddThemeParameter(BorderBottom, [Px(1), Solid, Hex("8080808c")])
        ->AddChild(
          (new Container)
          ->AddThemeParameter(Height, Auto)
          ->SetChild(
            (new Column)
            ->AddThemeParameter(Height, Auto)
            ->AddChilds([
              (new Text)
              ->AddThemeParameter(FontSize, Px(22))
              ->SetText($this->Title),
              (new Space),
              $this->Child,
              (new Space),
              (new Row)
              ->AddChilds([
                (new Link)
                ->AddThemeKey("graver_button")
                ->SetLink($this->BackRedirect)
                ->AddThemeParameter(Width, Pr(100))
                ->SetChild($this->CancelButtonText),
                (new Space)
                ->SetOrientation(Space::Horizontal)
                ->SetSpace(Px(10)),
                (new Button)
                ->AddThemeKey("graver_button")
                ->AddThemeParameter(Width, Pr(100))
                ->SetText($this->OkButtonText)
              ])
            ])
          )
        )
      )
    );
  }
}