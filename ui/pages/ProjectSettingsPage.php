<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class ProjecttingsPage extends Component
{
  private $ProjectID = -1;
  private $Fodlers;
  private $Message = "";
  private $ProjectName;

  function Think() {
    if (isset($_GET["project_id"]))
      $this->ProjectID = $_GET["project_id"];

    $this->Fodlers = FolderController::GetInstance()->GetFolders($this->ProjectID);

    if (!ProjectsController::GetInstance()->ExistsByID($this->ProjectID)) {
      Controller::RedirectTo("HomePage.php");
      return;
    }
    $project = ProjectsController::GetInstance()->GetProject($_COOKIE["session_key"], $this->ProjectID);
    $this->ProjectName = Action::GetValue("rename_field", $project["title"], ActionTypes::Post);

    if (isset($_GET["delete_folder"]) && $_GET["delete_folder"] == "true") {
      $this->DeleteFolder($_GET["folder_delete_id"]);
      Controller::RedirectTo("ProjectSettingsPage.php?project_id=".$this->ProjectID);
    }
    else if ($project["title"] != $this->ProjectName) {
      ProjectsController::GetInstance()->GetDB()->query(
        "UPDATE projects SET title = '".$this->ProjectName."' WHERE id = ".$this->ProjectID
      );
    }
    else if (isset($_GET["delete_project"]) && $_GET["delete_project"] == "true") {
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
    parent::__construct();
    $this->Think();
  }

  function BuildContent() : Element {
    $column = Column::Create();
    foreach ($this->Fodlers as $value) {
      $column->Children(
        (new ListItem)
        ->Icon(Icons::FolderOpen)
        ->Title($value["name"])
        ->Link("")
        ->Prefix(
          (new Link)
          ->ThemeParameter(Width, Px(32))
          ->ThemeParameter(Height, Px(32))
          ->ThemeParameter(MinWidth, Px(32))
          ->ThemeParameter(MinHeight, Px(32))
          ->ThemeParameter(Padding, 0)
          ->ThemeKeys("graver_button")
          ->Link("ProjectSettingsPage.php?delete_folder=true&project_id=".$this->ProjectID."&folder_id=".$this->FolderID."&folder_delete_id=".$value["id"])
          ->Child(
            Text::Create()
            ->ThemeKeys("material_icons")
            ->ThemeParameter(Color, Red)
            ->Text("delete")
          )
        )
        ->ThemeParameter(BackgroundColor, Transparent)
        ->ThemeParameter(Border, [Px(0), Solid, Transparent])
      );
    }
    return Column::Create()
    ->Children([
      Text::Create() 
      ->Text("Тестовый диалог для настройки проекта!"),
      Space::Create(),
      Text::Create() 
      ->ThemeParameter(FontWeight, 500)
      ->Text("Имя проекта"),
      Space::Create(),
      TextField::Create()
      ->ThemeKeys("graver_field")
      ->ActionKey("rename_field")
      ->Placeholder("Имя проекта")
      ->Text($this->ProjectName),
      Space::Create()
      ->Orientation(Space::Horizontal),
      // Button::Create()
      // ->ThemeParameter(Width, Px(40))
      // ->ThemeParameter(Height, Px(40))
      // ->ThemeParameter(MinWidth, Px(40))
      // ->ThemeParameter(MinHeight, Px(40))
      // ->ThemeParameter(Padding, [Px(7), 0])
      // ->ThemeKeys("graver_button")
      // ->ThemeKeys("material_icons")
      // ->Text(Icons::BlurOn)
      Space::Create(),
      Text::Create() 
      ->ThemeParameter(FontWeight, 500)
      ->Text("Папки"),
      Space::Create(),
      VerticalScrollView::Create()
      ->ThemeParameter(MaxHeight, Px(200))
      ->Child($column),
      Space::Create(),
      Link::Create()
      ->Link("ProjectSettingsPage.php?delete_project=true&project_id=".$this->ProjectID."&folder_id=".$this->FolderID)
      ->ThemeParameter(Color, Red)
      ->Child("Удалить проект"),
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
    ->Themes(GetFontsTheme())
    ->ThemeParameter(BackgroundColor, Hex("e6e8ea"))
    ->Child(
      (new Dialog)
      ->Title("Настроить проект")
      ->OkText("Изменить имя проекта")
      ->CancelText("Назад к проекту")
      ->BackRedirect("ProjectPage.php?id=".$this->ProjectID)
      ->ToRedirect("#")
      ->Child($this->BuildContent())
    );
  }
}

Node::Run(new ProjecttingsPage);