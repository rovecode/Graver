<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class CreateProjectPage extends Component
{
  private $Title = "";
  private $Picture = "";
  private $Text = "";
  private $Code = "";
  private $Message = "";

  function Think() {
    if (isset($_POST["title"]))
      $this->Title = $_POST["title"];
    if (isset($_POST["picture"]))
      $this->Picture = $_POST["picture"];
    if (isset($_POST["text"]))
      $this->Text = $_POST["text"];
    if (isset($_POST["code"]))
      $this->Code = $_POST["code"];

    if (empty($this->Title) || empty($this->Picture)
        || empty($this->Text) || empty($this->Code))
      return;

    if ($this->Code != "graver_3214") {
      $this->Message = "Неверный код";
      return;
    }

    $nameMask = "/[^a-zA-Zа-яёА-ЯЁ ]/u";
    if (preg_match($nameMask, $this->Title) || strlen($this->Picture) < 4) {
      $this->Message = "Неправильный формат полей";
      return;
    }

    if (!ArticlesController::GetInstance()->AddArticle(
      $this->Title,
      $this->Picture,
      $this->Text
    ))
      $this->Message = "Не удалось создать статью";
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
      ->SetText("Тестовый диалог создания статьи в Graver!"),
      (new Space),
      (new TextField)
      ->AddThemeKey("graver_field")
      ->SetPlaceholder("Название статьи")
      ->SetText($this->Title)
      ->SetActionKey("title"),
      (new Space),
      (new TextField)
      ->AddThemeKey("graver_field")
      ->SetPlaceholder("Ссылка на изображение")
      ->SetText($this->Picture)
      ->SetActionKey("picture"),
      (new Space),
      (new TextBox)
      ->AddThemeParameter(MaxWidth, Pr(100))
      ->AddThemeParameter(MinWidth, Pr(100))
      ->AddThemeParameter(MaxHeight, Px(300))
      ->AddThemeKey("graver_field")
      ->SetPlaceholder("Текст")
      ->SetText($this->Text)
      ->SetActionKey("text"),
      (new Space),
      (new TextField)
      ->AddThemeKey("graver_field")
      ->SetPlaceholder("Код")
      ->SetText($this->Code)
      ->SetActionKey("code"),
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
      ->SetTitle("Создать статью")
      ->SetOkText("Создать")
      ->SetCancelText("Отменить")
      ->SetBackRedirect("HomePage.php")
      ->SetToRedirect("CreateArticlePage.php")
      ->SetChild($this->BuildContent())
    );
  }
}

Node::Run(new CreateProjectPage);