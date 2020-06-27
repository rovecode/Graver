<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class ProjectPage extends Component
{
  private $ProjectsCount;
  private $Picture;
  private $Name;
  private $ProjectID;
  private $IsFolderSelected;
  private $Splash;
  private $Folders;
  private $FolderID;
  private $Folder;
  private $Tasks;
  private $SplashTaskList;
  private $TaskCount = 0;

  function Think() {
    $this->ProjectID = $_GET["id"];
    $this->Splash = !isset($_GET["splash"]) ? true : ($_GET["splash"] == "true" ? true : false);
    $this->SplashTaskList = !isset($_GET["splash_tasks"]) ? true : ($_GET["splash_tasks"] == "true" ? true : false);
    $this->ProjectsCount = ProjectsController::GetInstance()->Count($_COOKIE["session_key"]);
    $project = ProjectsController::GetInstance()->GetProject($_COOKIE["session_key"], $_GET["id"]);
    $this->Picture = $project["picture"];
    $this->Name = $project["title"];
    $this->FolderID = !isset($_GET["folder_id"]) ? -1 : $_GET["folder_id"];
    $this->Folders = FolderController::GetInstance()->GetFolders($this->ProjectID);
    $this->IsFolderSelected = $this->FolderID >= 0;
    if ($this->IsFolderSelected) {
      $this->Folder = FolderController::GetInstance()->GetFolder($this->FolderID);
      $this->Tasks = TaskController::GetInstance()->GetTasks($this->Folder["id"]);
    }
    foreach (FolderController::GetInstance()->GetFoldersID($this->ProjectID) as $value) {
      $this->TaskCount += TaskController::GetInstance()->GetTasksCountInFolder($value);
    }
  }

  function __construct() {
    $this->Think();
  }

  function BuildTitleLeft(string $string) {
    return (new Text)
    ->AddThemeParameter(FontSize, Px(22))
    ->AddThemeParameter(FontWeight, 500)
    ->AddThemeParameter(Padding, [0, Px(17)])
    ->AddThemeParameter(Color, Hex("4242429c"))
    ->SetText($string);
  }

  function BuildCheckLine(string $icon, string $text, string $link) {
    return (new Row)
    ->SetCrossAlign(CrossAxisAligns::Scretch)
    ->AddThemeParameter(Height, Px(39))
    ->AddThemeParameter(MinHeight, Px(39))
    ->AddThemeParameter(MaxHeight, Px(39))
    ->AddThemeParameter(PaddingLeft, Px(30))
    ->AddThemeKey("graver_check_line")
    ->AddThemeKey($this->SplashTaskList ? "on_show_x_large_translate" : "")
    ->AddThemeParameter(Height, Auto)
    ->AddChild(
      (new Link)
      ->AddThemeParameter(TextDecoration, None)
      ->AddThemeKey("graver_check_line_link")
      ->SetLink($link)
      ->SetChild(
        (new Column)
        ->SetCrossAlign(CrossAxisAligns::Center)
        ->SetMainAlign(MainAxisAligns::Center)
        ->AddChild(
          (new Text)
          ->AddThemeKey("material_icons")
          ->SetText($icon)
        )
      )
    )
    ->AddChild(
      (new Container)
      ->AddThemeParameter(PaddingLeft, Px(15))
      ->AddThemeParameter(PaddingRight, Px(30))
      ->SetChild(
        (new HorizontalScrollView)
        ->AddThemeParameter(MaxWidth, Pr(100))
        ->AddThemeParameter(BorderBottom, [Px(1), Solid, Hex("8080803d")])
        ->AddThemeKey("graver_hide_scrollbar")
        ->SetChild(
          (new Column)
          ->AddThemeParameter(Height, Px(39))
          ->SetMainAlign(MainAxisAligns::Center)
          ->AddChild(
            (new Text)
            ->AddThemeParameter(WhiteSpace, "pre")
            ->SetText($text)
          )
        )
      )
    );
  }

  function BuildRightFolder() {
    $column = new Column;
    $i=0;
    foreach ($this->Tasks as $value) {
      $column->AddChild(
        $this->BuildCheckLine(Icons::RadioButtonChecked, $value["name"], "DeleteTask.php?task_id=".$value["id"]."&project_id=".$this->ProjectID."&folder_id=".$this->FolderID)
        ->AddThemeParameter(AnimationDelay, (0.025 * ($i + cos($i) * 2)) ."s")
      );
    }
    $column->AddChild(
      $this->BuildCheckLine(Icons::Plus, "Добавить", "CreateTasksPage.php?project_id=".$this->ProjectID.($this->FolderID >= 0 ? "&folder_id=".$this->FolderID : ""))
      ->AddThemeParameter(AnimationDelay, 0.05 * $i ."s")
    );
    return (new Stack)
    ->AddThemeKey($this->SplashTaskList ? "on_show_x_large_translate" : "")
    ->AddChild(
      (new VerticalScrollView)
      ->AddThemeKey("graver_hide_scrollbar")
      ->AddThemeParameter(PaddingTop, Px(98))
      ->SetChild($column)
    )
    ->AddChild(
      (new Column)
      ->AddThemeParameter(WebKit(BackdropFilter), Blur(Px(20)))
      ->AddThemeParameter(BackdropFilter, Blur(Px(20)))
      ->AddThemeParameter(Height, Auto)
      ->AddChild(
        (new Space)
        ->SetSpace(Px(40)),
      )
      ->AddChild(
        (new HorizontalScrollView)
        ->AddThemeKey("graver_hide_scrollbar")
        ->AddThemeParameter(Padding, [0, Px(30)])
        ->SetChild(
          (new Text)
          ->AddThemeParameter(WhiteSpace, "pre")
          ->AddThemeParameter(PaddingBottom, Px(30))
          ->AddThemeParameter(FontSize, Px(22))
          ->SetText($this->Folder["name"])
        )
      )
      ->AddChild(
        (new Container)
        ->AddThemeParameter(Padding, [0, Px(30)])
        ->SetChild(
          (new Separator)
          ->SetOrientation(Separator::Vertical)
        )
      )
    );
  }

  function BuildTabs() {
    return (new Column)
    ->AddThemeParameter(Height, Auto)
    ->AddThemeParameter(Padding, [0, Px(15)])
    ->AddThemeParameter(PaddingTop, Px(20))
    ->AddChild(
      (new Row)
      ->AddThemeParameter(Height, Auto)
      ->AddThemeParameter(MaxHeight, Px(60))
      ->AddChilds([
        (new ProjectTile)
        ->SetLink("ProjectSettingsPage.php?project_id=".$this->ProjectID."&folder_id=".$this->FolderID)
        ->SetSplash(!$this->Splash)
        ->SetTitle("Настройки")
        ->SetSubTitle("проекта"),
        (new Space)
        ->SetSpace(Px(10))
        ->SetOrientation(Space::Horizontal),
        (new ProjectTile)
        ->SetLink("HomePage.php")
        ->SetTitle("Главная")
        ->SetSplash(!$this->Splash)
        ->SetSubTitle($this->ProjectsCount . " проект"),
      ])
    )
    ->AddChilds([
      (new Space)
      ->SetSpace(Px(10)),
      (new ProjectTile)
      ->SetSplash(!$this->Splash)
      ->SetLink("ProjectPage.php?splash=false&id=".$this->ProjectID)
      ->SetTitle("Все")
      ->SetSubTitle($this->TaskCount != 0 ? $this->TaskCount . " задач" : "Все задачи выполнены")
    ]);
  }

  function BuildList() {
    $column = (new Column)
    ->AddThemeParameter(PaddingTop, Px(268));
    $column->AddChild(
      (new Space)
      ->SetSpace(Px(5))
    );
    foreach ($this->Folders as $value) {
      $column->AddChild(
        (new ListItem)
        ->SetLink("ProjectPage.php?splash=false&id=".$this->ProjectID."&folder_id=".$value["id"])
        ->SetIcon(Icons::FolderOpen)
        ->SetPrefix(
          (new Text)
          ->AddThemeParameter(PaddingLeft, Px(10))
          ->AddThemeParameter(Color, Gray)
          ->AddThemeParameter(FontWeight, 300)
          ->SetText(TaskController::GetInstance()->GetTasksCountInFolder($value["id"]) . " ")
        )
        ->SetTitle($value["name"])
      );
    }
    $column->AddChild(
      (new ListItem)
      ->SetLink("CreateFolderPage.php?project_id=".$this->ProjectID."&folder_id=".$this->FolderID)
      ->SetIcon(Icons::Plus)
      ->SetTitle("Добавить")
    );
    return (new VerticalScrollView)
    ->AddThemeKey("graver_hide_scrollbar")
    ->SetChild($column);
  }

  function BuildLeft() : Element {
    return (new Container)
    ->AddThemeKeys(["graver_project_left", "graver_project"])
    ->SetChild(
      (new Stack)
      ->AddChild(
        (new Container)
        ->AddThemeParameter(WebKit(BackdropFilter), Blur(Px(50)))
        ->AddThemeParameter(BackdropFilter, Blur(Px(50)))
        ->AddThemeParameter(BackgroundColor, Hex("efefefad"))
      )
      ->AddChild($this->BuildList())
      ->AddChild(
        (new Container)
        ->AddThemeParameter(Height, Auto)
        ->AddThemeParameter(ZIndex, 2)
        ->SetChild(
          (new Column)
          ->AddThemeParameter(WebKit(BackdropFilter), Blur(Px(20)))
          ->AddThemeParameter(BackdropFilter, Blur(Px(20)))
          ->AddThemeParameter(Height, Auto)
          ->AddChild(
            (new Space)
            ->SetSpace(Px(40)),
          )
          ->AddChild($this->BuildTitleLeft($this->Name))
          ->AddChild($this->BuildTabs())
          ->AddChild(
            (new Text)
            ->AddThemeParameter(Padding, [ Px(20), Px(17) ])
            ->AddThemeParameter(FontSize, Px(13))
            ->AddThemeParameter(Color, Hex("3e3e3e"))
            ->SetText("Папки")
          )
          ->AddChild(
            (new Container)
            ->AddThemeParameter(Padding, [0, Px(15)])
            ->SetChild(
              (new Separator)
              ->SetOrientation(Separator::Vertical)
            )
          )
        )
      )
    );
  }

  function BuildRight() : Element {
    return (new Container)
    ->AddThemeKeys(["graver_project_right", "graver_project"])
    ->AddThemeParameter(BackgroundColor, Hex("e6e8ea"))
    ->SetChild(
      $this->IsFolderSelected
      ? $this->BuildRightFolder()
      : (new Column)
        ->AddThemeKey("on_show_x_translate")
        ->SetMainAlign(MainAxisAligns::Center)
        ->SetCrossAlign(CrossAxisAligns::Center)
        ->AddChild($this->BuildTitleLeft("Выберете папку"))
    );
  }

  function Build() : Node {
    return (new Document)
    ->AddTheme(GetGraverTheme())
    ->AddThemes(GetAdaptiveThemes())
    ->AddTheme(GetFontsTheme())
    ->AddThemeParameter(BackgroundColor, Hex("e6e8ea"))
    ->SetTitle("Имя проекта, graver.com")
    ->AddThemeKey($this->Splash == true ? "on_show_x_large_translate" : "")
    ->SetChild(
      (new Stack)
      ->AddChild(
        (new Picture)
        ->SetLink(Url($this->Picture))
        ->SetRepeat(PictureRepeats::NoRepeat)
        ->SetSize(PictureSizes::Cover)
      )
      ->AddChild(
        (new Queue)
        ->AddChild(
          (new Row)
          ->AddThemeKey("not_mobile")
          ->AddChilds([
            $this->BuildLeft(),
            (new Separator),
            $this->BuildRight()
          ])
        )
        ->AddChild(
          (new HorizontalScrollView)
          ->AddThemeKeys(["not_desktop", "not_tablet"])
          ->AddThemeKey("graver_hide_scrollbar")
          ->SetChild(
            (new Row)
            ->AddChilds([
              $this->BuildLeft(),
              (new Separator),
              $this->BuildRight()
            ])
          )
        )
      )
    );
  }
}

Node::Run(new ProjectPage);