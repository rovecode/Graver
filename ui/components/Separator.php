<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");

class Separator extends Component
{
  const Horizontal = true;
  const Vertical = false;

  private $Orientation = Separator::Horizontal;

  // Orientation
  function SetOrientation(bool $orientation) {
    $this->Orientation = $orientation;
    return $this;
  }

  function GetOrientation() : bool {
    return $this->Orientation;
  }

  function Build() : Node {
    $cont = (new Container)
    ->AddThemeParameter(BackgroundColor, Hex("bababa"));
    if ($this->Orientation) {
      $cont->AddThemeParameter(Width, Px(1));
      $cont->AddThemeParameter(MaxWidth, Px(1));
      $cont->AddThemeParameter(MinWidth, Px(1));
    }
    else {
      $cont->AddThemeParameter(Height, Px(1));
      $cont->AddThemeParameter(MaxHeight, Px(1));
      $cont->AddThemeParameter(MinHeight, Px(1));
    }
    return $cont;
  }
}