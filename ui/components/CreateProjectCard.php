<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/Space.php");

class CreateProjectCard extends Component
{
  private $Size = "135px";
  private $RedirectLink;

  /// RedirectLink
  function SetRedirectLink(string $string) {
    $this->RedirectLink = $string;
    return $this;
  }

  /// Size
  function SetSize(string $string) {
    $this->Size = $string;
    return $this;
  }

  /// Build
  function BuildContent() : Element {
    return (new Column)
    ->SetCrossAlign(CrossAxisAligns::Center)
    ->SetMainAlign(MainAxisAligns::Center)
    ->AddChild(
      (new Text)
      ->AddThemeKey("material_icons")
      ->SetText("add")
    );
  }

  function Build() : Node {
    return (new Link)
    ->AddThemeParameter(TextDecoration, None)
    //->AddThemeParameter(Color, Gray)
    ->SetLink($this->RedirectLink)
    ->SetChild(
      (new Container)
      ->AddThemeKey("graver_add_project_button")
      ->AddThemeParameter(MinWidth, $this->Size)
      ->AddThemeParameter(MaxWidth, $this->Size)
      ->AddThemeParameter(Width, $this->Size)
      ->AddThemeParameter(MinHeight, $this->Size)
      ->AddThemeParameter(MaxHeight, $this->Size)
      ->AddThemeParameter(Height, $this->Size)
      ->SetChild( $this->BuildContent())
    );
  }
}