<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class CreateFolderPage extends Component
{
  private $Name = "";
  private $ProjectID = -1;
  private $Message = "";
  private $FolderID = -1;

  function Think() {
    if (isset($_POST["name"]))
      $this->Name = $_POST["name"];
    if (isset($_GET["project_id"]))
      $this->ProjectID = $_GET["project_id"];
    if (isset($_GET["folder_id"]))
      $this->FolderID = $_GET["folder_id"];

    if (!ProjectsController::GetInstance()->ExistsByID($this->ProjectID)) {
      Controller::RedirectTo("HomePage.php");
      return;
    }

    if (empty($this->Name))
      return;

    $nameMask = "/[^a-zA-Zа-яёА-ЯЁ ]/u";
    if (preg_match($nameMask, $this->Name)) {
      $this->Message = "Неправильный формат полей";
      return;
    }

    FolderController::GetInstance()->AddFolder(
      $this->ProjectID,
      $this->Name
    );

    Controller::RedirectTo("ProjectPage.php?id=".$this->ProjectID."&folder_id=".$this->FolderID);
  }

  function __construct() {
    $this->Think();
  }

  function BuildContent() : Element {
    return (new Column)
    ->SetChilds([
      (new Text) 
      ->SetText("Тестовый диалог создания папки в Graver!"),
      (new Space),
      (new TextField)
      ->AddThemeKey("graver_field")
      ->SetPlaceholder("Название папки")
      ->SetText($this->Name)
      ->SetActionKey("name"),
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
      ->SetTitle("Создать папку")
      ->SetOkText("Создать")
      ->SetCancelText("Отменить")
      ->SetBackRedirect("ProjectPage.php?id=".$this->ProjectID."&folder_id=".$this->FolderID)
      ->SetToRedirect("CreateFolderPage.php?project_id=".$this->ProjectID."&folder_id=".$this->FolderID)
      ->SetChild($this->BuildContent())
    );
  }
}

Node::Run(new CreateFolderPage);