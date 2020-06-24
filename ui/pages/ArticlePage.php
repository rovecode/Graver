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
    // $this->Title = "Test page";

    // $this->Text = "Risk has historically been an internal monitoring process that hasn’t been subject to the same strict controls as groups such as finance – whose externally-disclosed reports undergo years of auditing. However, this is beginning to change as risk teams face up to new requirements to report directly to external regulators.

    // AxiomSL - FDSF Stress TestingThe change is apparent in the Firm Data Submission Framework (FDSF) stress tests, which risk teams at banks across the UK must carry out. The teams involved face the mammoth task of aggregating and consolidating granular data from across the enterprise, ensuring it is in the correct format before running the necessary stress test calculations and reporting the results to the Prudential Regulation Authority (PRA).
    
    // Some of the pitfalls to avoid have been illustrated by the implementation of the US Federal Reserve’s Comprehensive Capital Analysis and Review (CCAR), on which FDSF is based. Firms that took tactical approaches to CCAR, by allowing individual teams to manually adjust and enrich data, have experienced problems with data quality and consistency. Others have learned the hard way that they must carefully coordinate their operational processes, as many of the different teams required to execute CCAR calculations are inter-dependent.
    
    // If banks in the UK are to avoid these issues and get FDSF right from the start, they need a single platform that can easily aggregate and consolidate data from different lines of business. They should consider a platform that not only includes reporting capabilities, but also delivers stress tests and maintains the scenario logic used for these. Before they report to the PRA, risk teams must be able to reconcile the results of the tests with data submitted as part of other regulatory requirements, including Common Reporting filings.
    
    // A risk team’s responsibility does not end when the stress test results have been filed. They must also be able to audit the entire process and, therefore, need to use a platform with full traceability and drilldown capabilities. Finally, as regulatory requirements are prone to change, risk must consider the flexibility of the technology they use for FDSF to ensure they remain compliant.
    
    // By taking these steps, risk teams can step up to the challenges facing them with confidence.";

    // $this->Text = str_replace("\n", "<br/>", $this->Text);

    // $this->Picture = "https://paranoidandroid.co/assets/wallpapers/2018/submerged_desktop_thumb.jpg";
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
          ->AddThemeParameter(Padding, [Px(195), Px(40), Px(40), Px(40)])
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