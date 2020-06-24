<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class CreateProjectPage extends Component
{
  private $Name = "";
  private $Picture = "";
  private $Message = "";

  function Think() {
    if (isset($_POST["name"]))
      $this->Name = $_POST["name"];
    if (isset($_POST["link"]))
      $this->Picture = $_POST["link"];

    if (empty($this->Name) || empty($this->Picture))
      return;

    $nameMask = "/[^a-zA-Zа-яёА-ЯЁ ]/u";
    if (preg_match($nameMask, $this->Name) || strlen($this->Picture) < 4) {
      $this->Message = "Неправильный формат полей";
      return;
    }

    if (!ProjectsController::GetInstance()->AddProject(
      $this->Name,
      $this->Picture,
      $_COOKIE["session_key"]
    ))
      $this->Message = "Не удалось создать проект";
    else
      Controller::RedirectTo("HomePage.php");
  }

  function __construct() {
    $this->Think();
  }

  function BuildContent() : Element {
    return (new Column)
    ->SetChilds([
      (new Text)
      ->SetText("Тестовый диалог создания проекта в Graver!"),
      (new Space),
      (new TextField)
      ->AddThemeKey("graver_field")
      ->SetPlaceholder("Название проекта")
      ->SetText($this->Name)
      ->SetActionKey("name"),
      (new Space),
      (new TextField)
      ->AddThemeKey("graver_field")
      ->SetPlaceholder("Ссылка на изображение")
      ->SetText($this->Picture)
      ->SetActionKey("link"),
      (new Space),
      !empty($this->Message)
        ? (new ShakeErrorText)
          ->SetText($this->Message)
        : new Container,
    ]);
  }

  function Build() : Node {
    return (new Document)
    ->AddThemes(GetAdaptiveThemes())
    ->AddTheme(GetGraverTheme())
    ->AddThemeParameter(BackgroundColor, Hex("e6e8ea"))
    ->SetChild(
      (new Dialog)
      ->SetTitle("Создать проект")
      ->SetOkText("Создать")
      ->SetCancelText("Отменить")
      ->SetBackRedirect("HomePage.php")
      ->SetToRedirect("CreateProjectPage.php")
      ->SetChild($this->BuildContent())
    );
  }
}

Node::Run(new CreateProjectPage);