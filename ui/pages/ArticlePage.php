<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class ArticlePage extends Component
{
  private $Title;
  private $Text;
  private $Picture;

  function AddMarckdown(string $string, string $finder, string $left, string $right) : string {
    $text = "";
    $isFind = false;
    $array = preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);;
    foreach ($array as $value) {
      if ($value == $finder) {
        $text .= $isFind ? $right : $left;
        $isFind = !$isFind;
      }
      else
        $text .= $value;
    }
    return $text;
  }
  function Think() {
    $this->Title = $_GET["title"];
    $this->Picture = $_GET["picture"];
    $text = ArticlesController::GetInstance()->GetTextById($_GET["text_id"]);
    $text = $this->AddMarckdown($text, "_", "<b>", "</b>");
    $text = $this->AddMarckdown($text, "*", "<i>", "</i>");
    $textArray = explode("\n", $text);

    $this->Text = new Queue;
    foreach ($textArray as $value) {
      if (strlen($value) >= 2 && $value[0] == "#" && $value[1] == " ")
        $this->Text->AddChild(
          (new Text)
          ->AddThemeParameter(FontSize, Px(19))
          ->SetText(substr($value, 2))
        );
      else
        $this->Text->AddChild(
          (new Text)
          ->SetText($value)
        );
      $this->Text->AddChild(
        (new Space)
      );
    }
  }

  function __construct() {
    $this->Think();
  }

  /// Build
  function BuildLeft() : Element {
    return (new Container);
  }

  function BuildRight() : Element {
    return (new Container)
    ->SetChild(
      (new Stack)
      ->AddChild(
        (new VerticalScrollView)
        ->AddThemeParameter(BackgroundColor, Hex("f1f1f1e3"))
        ->AddThemeParameter(BackdropFilter, Blur(Px(30)))
        ->AddThemeParameter(WebKit(BackdropFilter), Blur(Px(30)))
        ->AddThemeKey("graver_hide_scrollbar")
        ->SetChild(
          (new Column)
          ->AddThemeKey("on_show_x_large_translate")
          ->AddThemeParameter(Padding, [Px(230), Px(40), Px(40), Px(40)])
          ->AddThemeParameter(AnimationDelay, "0.4s")
          ->SetChilds($this->Text->GetChilds())
        )
      )
      ->AddChilds([
        (new Container)
        ->AddThemeParameter(BackdropFilter, Blur(Px(30)))
        ->AddThemeParameter(WebKit(BackdropFilter), Blur(Px(30)))
        ->AddThemeParameter(ZIndex, 3)
        ->AddThemeParameter(Height, Auto)
        ->AddThemeParameter(Padding, [Px(60), Px(40), 0, Px(40)])
        ->SetChild(
          (new Column)
          ->AddChild(
            (new Row)
            ->AddThemeKey("on_show_x_translate")
            ->AddThemeParameter(AnimationDuration, "0.3s")
            ->SetCrossAlign(CrossAxisAligns::Center)
            ->AddChild(
              (new Text)
              ->AddThemeParameter(FontSize, Px(22))
              ->AddThemeParameter(Width, Pr(100))
              ->SetText($this->Title)
            )
            ->AddChild(
              (new Space)
              ->SetOrientation(Space::Vertical)
              ->SetSpace(Px(7))
            )
            ->AddChild(
              (new Link)
              ->SetLink("HomePage.php")
              ->SetChild(
                (new Button)
                ->AddThemeKey("on_show_x_translate")
                ->AddThemeParameter(AnimationDelay, "0.3s")
                ->AddThemeParameter(Width, Auto)
                ->AddThemeKey("graver_button")
                ->SetText("Прочитал")
              )
            )
          )
          ->AddChilds([
            (new Space)
            ->SetSpace(Px(35)),
            (new Separator)
            ->SetOrientation(Separator::Vertical)
          ])
        )
      ])
    );
  }

  function Build() : Node {
    return (new Document)
    ->SetTitle("Статья: ".$this->Title . ", graver.com")
    ->AddTheme(GetGraverTheme())
    ->AddThemes(GetAdaptiveThemes())
    ->SetChild(
      (new Stack)
      ->AddThemeKey("graver_page_background")
      ->SetChilds([
        (new Picture)
        ->SetLink(Url($this->Picture))
        ->SetRepeat(PictureRepeats::NoRepeat)
        ->SetSize(PictureSizes::Cover)
        /*->SetChild(
          (new Container)
          //->AddThemeParameter(BackgroundColor, Hex("00000010"))
          ->AddThemeParameter(BackdropFilter, Blur(Px(1)))
        )*/,
        (new Row)
        ->SetChilds([
          $this->BuildLeft()
          ->AddThemeKey("not_mobile"),
          (new Separator)->Build()
          ->AddThemeParameter(BackgroundColor, Hex("ffffff65"))
          ->AddThemeKey("not_mobile"),
          (new Separator)->Build()
          ->AddThemeKey("not_mobile"),
          $this->BuildRight()
        ])
      ])
    );
  }
}

Node::Run((new ArticlePage)->Build());