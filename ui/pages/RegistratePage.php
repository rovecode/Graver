<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class RegistratePage extends Component
{
  private $Name = "";
  private $LastName = "";
  private $Login = "";
  private $Password = "";
  private $PasswordRepeat = "";
  private $Message = "";

  function Think() {
    if ($this->Password != $this->PasswordRepeat)
      return "Пароли не совпадают";

    $registerResult = ProfileController::GetInstance()
    ->Create(
      $this->Name,
      $this->LastName,
      $this->Login,
      $this->Password
    );
    
    switch ($registerResult) {
      case ProfileCreateEnum::Ok:
        Controller::RedirectTo("LoginPage.php?login_or_email=".$this->Login);
      case ProfileCreateEnum::BadLogin:
        return "Неправильный формат логина";
      case ProfileCreateEnum::BadPassword:
        return "Неправильный формат пароля";
      case ProfileCreateEnum::BadName:
        return "Неправильный формат имени";
      case ProfileCreateEnum::BadLastName:
        return "Неправильный формат фамилии";
      case ProfileCreateEnum::Exists:
        return "Пользователь уже существует с таким логином";
      case ProfileCreateEnum::ServerError:
        return "Произошла ошибка на стороне сервера";
      default:
        return "Неизвестная ошибка";
    }
  }

  function __construct() {
    if (isset($_GET["name"]))
      $this->Name = $_GET["name"];
    if (isset($_GET["last_name"]))
      $this->LastName = $_GET["last_name"];
    if (isset($_GET["login"]))
      $this->Login = $_GET["login"];
    if (isset($_GET["login"]))
      $this->Password = $_GET["password"];
    if (isset($_GET["password_repeat"]))
      $this->PasswordRepeat = $_GET["password_repeat"];

    if (
      !empty($this->Name)
      && !empty($this->LastName)
      && !empty($this->Login)
      && !empty($this->Password)
      && !empty($this->PasswordRepeat)
    )
      $this->Message = $this->Think();
  }

  function BuildForm() : Node {
    return (new Action)
    ->SetChild(
      (new Column)
      ->AddChilds([
        (new Text)
        ->AddThemeParameter(FontSize, Px(22))
        ->SetText("Присоеденитесь к Graver"),
        (new Space),
        (new Row)
        ->SetCrossAlign(CrossAxisAligns::End)
        ->AddThemeParameter(Height, Auto)
        ->AddChilds([
          (new Text)
          ->SetText("У вас уже есть аккаунт?"),
          (new Space)
          ->SetOrientation(Space::Horizontal)
          ->SetSpace(Px(5)),
          (new Link)
          ->SetLink("LoginPage.php")
          ->SetChild("Войдите в него!")
        ]),
        (new Space),
        (new Row)
        ->AddThemeParameter(Height, Auto)
        ->AddChilds([
          (new TextField)
          ->SetActionKey("name")
          ->AddThemeKey("graver_auth_field")
          ->SetPlaceholder("Имя")
          ->SetText($this->Name),
          (new Space)
          ->SetOrientation(Space::Horizontal)
          ->SetSpace(Px(10)),
          (new TextField)
          ->SetActionKey("last_name")
          ->AddThemeKey("graver_auth_field")
          ->SetPlaceholder("Фамилия")
          ->SetText($this->LastName)
        ]),
        (new Space),
        (new Text)
        ->SetText("Логин должен состоять из минимум 7 латинских букв или цифр"),
        (new Space),
        (new TextField)
        ->SetActionKey("login")
        ->AddThemeKey("graver_auth_field")
        ->SetPlaceholder("Логин")
        ->SetText($this->Login),
        (new Space),
        (new Text)
        ->SetText("Пароль должен быть длинее 7 символов и содержать одну цифру, букву, и заглавную букву"),
        (new Space),
        (new PasswordField)
        ->SetActionKey("password")
        ->AddThemeKey("graver_auth_field")
        ->SetPlaceholder("Пароль")
        ->SetText($this->Password),
        (new Space),
        (new PasswordField)
        ->SetActionKey("password_repeat")
        ->AddThemeKey("graver_auth_field")
        ->SetPlaceholder("Повтор пароля")
        ->SetText($this->PasswordRepeat),
        (new Space),
        !empty($this->Message)
          ? (new Column)
          ->SetChilds([
            (new ShakeErrorText)
            ->SetText($this->Message),
            (new Space)
          ])
          : new Container,
        (new Button)
        ->AddThemeKey("graver_auth_button")
        ->SetText("Присоеденится")
      ])
    );
  }

  function Build() : Node {
    return (new AuthTeample("Присоеденитесь"))
    ->SetChild($this->BuildForm());
  }
}

Node::Run(new RegistratePage);