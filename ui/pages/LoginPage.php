<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class LoginPage extends Component
{
  private $Password = "";
  private $Login = "";
  private $Message = "";

  function Think() {
    $loginResult = SessionController::GetInstance()
    ->Create($this->Login, $this->Password, $key);
    
    switch ($loginResult) {
      case SessionCreateEnum::Ok:
        $_COOKIE["session_key"] = $key;
        Controller::RedirectTo("HomePage.php");
      case SessionCreateEnum::BadLogin:
        return "Неправильный формат логина";
      case SessionCreateEnum::BadPassword:
        return "Неправильный формат пароля";
      case SessionCreateEnum::UserNotExists:
        return "Пользователь не найден";
      case SessionCreateEnum::ServerError:
        return "Произошла ошибка на стороне сервера";
      default:
        return "Неизвестная ошибка";
    }
  }

  function __construct() {
    if (isset($_GET["login_or_email"]))
      $this->Login = $_GET["login_or_email"];
    if (isset($_GET["password"]))
      $this->Password = $_GET["password"];

    if (!empty($this->Login) && !empty($this->Password)) 
      $this->Message = $this->Think();
  }

  function BuildForm() : Node {
    return (new Action)
    ->SetChild(
      (new Column)
      ->AddChilds([
        (new Text)
        ->AddThemeParameter(FontSize, Px(22))
        ->SetText("Войдите в Ваш аккаунт"),
        (new Space),
        (new Row)
        ->SetCrossAlign(CrossAxisAligns::End)
        ->AddThemeParameter(Height, Auto)
        ->AddChilds([
          (new Text)
          ->SetText("У вас нет аккаунта?"),
          (new Space)
          ->SetOrientation(Space::Horizontal)
          ->SetSpace(Px(5)),
          (new Link)
          ->SetLink("RegistratePage.php")
          ->SetChild("Создайте его!")
        ]),
        (new Space),
        (new TextField)
        ->SetActionKey("login_or_email")
        ->AddThemeKey("graver_auth_field")
        ->SetPlaceholder("Логин или email")
        ->SetText($this->Login),
        (new Space),
        (new PasswordField)
        ->SetActionKey("password")
        ->AddThemeKey("graver_auth_field")
        ->SetPlaceholder("Пароль")
        ->SetText($this->Password),
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
        ->SetText("Войти")
      ])
    );
  }

  function Build() : Node {
    return (new AuthTeample("Вход"))
    ->SetChild($this->BuildForm());
  }
}

Node::Run(new LoginPage);