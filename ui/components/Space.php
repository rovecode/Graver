<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");

class Space extends Component
{
  const Horizontal = true;
  const Vertical = false;

  private $Space = "15px";
  private $Orientation = Space::Vertical;

  // Orientation
  function SetOrientation(bool $orientation) {
    $this->Orientation = $orientation;
    return $this;
  }

  function GetOrientation() : bool {
    return $this->Orientation;
  }

  // Space
  function SetSpace(string $string) {
    $this->Space = $string;
    return $this;
  }

  function GetSpace() : string {
    return $this->Space;
  }

  function Build() : Node {
    $cont = (new Container);
    if ($this->Orientation) {
      $cont->AddThemeParameter(Width, $this->Space);
      $cont->AddThemeParameter(MaxWidth, $this->Space);
      $cont->AddThemeParameter(MinWidth, $this->Space);
    }
    else {
      $cont->AddThemeParameter(Height, $this->Space);
      $cont->AddThemeParameter(MaxHeight, $this->Space);
      $cont->AddThemeParameter(MinHeight, $this->Space);
    }
    return $cont;
  }
}