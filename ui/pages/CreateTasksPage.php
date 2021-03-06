<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class CreateTasksPage extends Component
{
  private $Name = "";
  private $ProjectID = -1;
  private $FolderID;
  private $Message = "";

  function Think() {
    if (isset($_POST["name"]))
      $this->Name = $_POST["name"];
    if (isset($_GET["project_id"]))
      $this->ProjectID = $_GET["project_id"];
    if (isset($_GET["folder_id"]))
      $this->FolderID = $_GET["folder_id"];

    if (!ProjectsController::GetInstance()->ExistsByID($this->ProjectID) 
        || !FolderController::GetInstance()->ExistsByID($this->FolderID)) {
      Controller::RedirectTo("HomePage.php");
      return;
    }

    if (empty($this->Name))
      return;

    $nameMask = "/[^a-zA-Zа-яёА-ЯЁ0-9 ,.:#№!()]/u";
    if (preg_match($nameMask, $this->Name)) {
      $this->Message = "Неправильный формат полей";
      return;
    }

    TaskController::GetInstance()->AddTask(
      $this->FolderID,
      $this->Name
    );

    if (!Action::GetValue("all") == "true")
      Controller::RedirectTo("ProjectPage.php?id=".$this->ProjectID."&folder_id=".$this->FolderID);
    else
      Controller::RedirectTo("ProjectPage.php?is_all=true&id=".$this->ProjectID);
  }

  function __construct() {
    parent::__construct();
    $this->Think();
  }

  function BuildContent() : Element {
    return Column::Create()
    ->Children([
      Text::Create() 
      ->Text("Тестовый диалог создания задачи в Graver!"),
      Space::Create(),
      (new TextField)
      ->ThemeKeys("graver_field")
      ->Placeholder("Название задачи")
      ->Text($this->Name)
      ->ActionKey("name"),
      Space::Create(),
      !empty($this->Message)
        ? (new ShakeErrorText)
          ->Text($this->Message)
        : new Container,
    ]);
  }

  function Build() : Element {
    return (new Document)
    ->Themes(GetAdaptiveThemes())
    ->Themes(GetGraverTheme())
    ->ThemeParameter(BackgroundColor, Hex("e6e8ea"))
    ->Child(
      (new Dialog)
      ->Title("Создать задачу")
      ->OkText("Создать")
      ->CancelText("Отменить")
      ->BackRedirect("ProjectPage.php?id=".$this->ProjectID."&folder_id=".$this->FolderID)
      ->ToRedirect("CreateTasksPage.php?project_id=".$this->ProjectID."&folder_id=".$this->FolderID."&all=".Action::GetValue("all", ""))
      ->Child($this->BuildContent())
    );
  }
}

Node::Run(new CreateTasksPage);