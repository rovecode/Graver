<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class ProjectSettingsPage extends Component
{
  private $ProjectID = -1;
  private $FolderID;
  private $Fodlers;
  private $Message = "";

  function Think() {
    if (isset($_GET["project_id"]))
      $this->ProjectID = $_GET["project_id"];
    if (isset($_GET["folder_id"]))
      $this->FolderID = $_GET["folder_id"];

    $this->Fodlers = FolderController::GetInstance()->GetFolders($this->ProjectID);

    if (!ProjectsController::GetInstance()->ExistsByID($this->ProjectID)) {
      Controller::RedirectTo("HomePage.php");
      return;
    }

    if (isset($_GET["delete_folder"]) && $_GET["delete_folder"] == "true") {
      $this->DeleteFolder($_GET["folder_delete_id"]);
      Controller::RedirectTo("ProjectSettingsPage.php?project_id=".$this->ProjectID."&folder_id=".$this->FolderID);
    }

    if (isset($_GET["delete_project"]) && $_GET["delete_project"] == "true") {
      $this->DeleteProject($this->ProjectID);
      Controller::RedirectTo("HomePage.php");
    }
  }

  function DeleteFolder($id) {
    $tasks = TaskController::GetInstance()->GetTasksIDInFolder($id);
    foreach ($tasks as $value) {
      TaskController::GetInstance()->DeleteTask($value);
    }
    FolderController::GetInstance()->DeleteFolder($id);
  }

  function DeleteProject($id) {
    $folders = FolderController::GetInstance()->GetFoldersID($id);
    foreach ($folders as $value) {
      $this->DeleteFolder($value);
    }
    ProjectsController::GetInstance()->DeleteProject($id);
  }

  function __construct() {
    $this->Think();
  }

  function BuildContent() : Element {
    $column = (new Column);
    foreach ($this->Fodlers as $value) {
      $column->AddChild(
        (new ListItem)
        ->SetIcon(Icons::FolderOpen)
        ->SetTitle($value["name"])
        ->SetLink("")
        ->SetPrefix(
          (new Link)
          ->AddThemeParameter(Width, Px(32))
          ->AddThemeParameter(Height, Px(32))
          ->AddThemeParameter(MinWidth, Px(32))
          ->AddThemeParameter(MinHeight, Px(32))
          ->AddThemeParameter(Padding, 0)
          ->AddThemeKey("graver_button")
          ->SetLink("ProjectSettingsPage.php?delete_folder=true&project_id=".$this->ProjectID."&folder_id=".$this->FolderID."&folder_delete_id=".$value["id"])
          ->SetChild(
            (new Text)
            ->AddThemeKey("material_icons")
            ->AddThemeParameter(Color, Red)
            ->SetText("delete")
          )
        )
        ->Build()
        ->AddThemeParameter(BackgroundColor, Transparent)
        ->AddThemeParameter(Border, [Px(0), Solid, Transparent])
      );
    }
    return (new Column)
    ->SetChilds([
      (new Text) 
      ->SetText("Тестовый диалог для настройки проекта!"),
      (new Space),
      (new Text) 
      ->AddThemeParameter(FontWeight, 500)
      ->SetText("Папки"),
      (new Space),
      (new VerticalScrollView)
      ->AddThemeParameter(MaxHeight, Px(200))
      ->SetChild($column),
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
    ->AddTheme(GetFontsTheme())
    ->AddThemeParameter(BackgroundColor, Hex("e6e8ea"))
    ->SetChild(
      (new Dialog)
      ->SetTitle("Настроить проект")
      ->SetOkText("Удалить проект")
      ->SetCancelText("Назад к проекту")
      ->SetBackRedirect("ProjectPage.php?id=".$this->ProjectID."&folder_id=".$this->FolderID)
      ->SetToRedirect("ProjectSettingsPage.php?delete_project=true&project_id=".$this->ProjectID."&folder_id=".$this->FolderID)
      ->SetChild($this->BuildContent())
    );
  }
}

Node::Run(new ProjectSettingsPage);