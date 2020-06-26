<?php

require_once(__DIR__ . "/../components/include.php");
require_once(__DIR__ . "/../teamples/include.php");
require_once(__DIR__ . "/../elements/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../../backend/include.php");

class HomePage extends Component
{
  private $Projects;

  private $Articles;

  function Think() {
    if (!isset($_COOKIE["session_key"]) || !SessionController::GetInstance()->ExistsByKey($_COOKIE["session_key"]))
      Controller::RedirectTo("LoginPage.php");
    
    $this->Projects  = ProjectsController::GetInstance()->GetProjects($_COOKIE["session_key"]);

    $this->Articles = array_reverse(ArticlesController::GetInstance()->GetArticles());
  }

  function __construct() {
    $this->Think();
  }

  function BuildTopText(string $title, string $text) : Column {
    return (new Column)
    ->SetChilds([
      (new Text)
      ->AddThemeParameter(FontSize, Px(22))
      ->SetText($title),
      (new Space),
      (new Text)
      ->AddThemeParameter(FontSize, Px(15))
      ->SetText($text)
    ]);
  }

  function BuildTopContainer(string $title, string $text) : Element {
    return (new Container)
    ->AddThemeParameter(Padding, [Px(60), Px(40), 0, Px(40)])
    ->AddThemeParameter(Height, Auto)
    ->AddThemeParameter(BackgroundColor, Hex("e6e8ea96"))
    ->AddThemeParameter(BackdropFilter, Blur(Px(30)))
    ->AddThemeParameter(WebKit(BackdropFilter), Blur(Px(30)))
    ->SetChild(
      $this->BuildTopText($title, $text)
      ->AddChilds([
        (new Space)
        ->SetSpace(Px(35)),
        (new Separator)
        ->SetOrientation(Separator::Vertical)
      ])
    );
  }

  function BuildTopContainerMobile(string $title, string $text) : Element {
    return (new Container)
    ->AddThemeParameter(Padding, [0, Px(40)])
    ->AddThemeParameter(Height, Auto)
    ->AddThemeParameter(BackgroundColor, Hex("e6e8ea96"))
    ->AddThemeParameter(BackdropFilter, Blur(Px(30)))
    ->AddThemeParameter(WebKit(BackdropFilter), Blur(Px(30)))
    ->SetChild(
      (new Column)
      ->SetChilds([
        (new Separator)
        ->SetOrientation(Separator::Vertical),
        (new Space)
        ->SetSpace(Px(60)),
        $this->BuildTopText($title, $text),
        (new Space)
        ->SetSpace(Px(30)),
        (new Separator)
        ->SetOrientation(Separator::Vertical)
      ])
    );
  }

  function BuildProjectsMobile() : Element {
    return (new Stack)
    ->AddThemeParameter(MinHeight, Pr(100.1))
    ->SetChilds([
      (new VerticalScrollView)
      ->AddThemeKey("graver_hide_scrollbar")
      ->AddThemeParameter(Padding, [Px(190), Px(40), 0, Px(40)])
      ->SetChild(
        (new Builder)
        ->SetFunction(function ($args) {
          $queue = (new Grid)
          ->AddThemeParameter(Height, Auto)
          ->AddThemeParameter(JustifyContent, Center)
          ->SetSpacing(Px(20))
          ->SetColumnTeample(Repeat("auto-fill", Minmax(Px(120), Px(120))));
          $i = 0;
          foreach ($this->Projects as $value) {
            $queue->AddChild(
              (new ProjectCard)
              ->SetTitle($value["title"])
              ->SetPictureLink(Url($value["picture"]))
              ->SetRedirectLink("ProjectPage.php?id=" . $value["id"])
              ->SetSize(Px(120))
            );
            ++$i;
          }
          $queue->AddChild(
            (new CreateProjectCard)
            ->SetRedirectLink("CreateProjectPage.php")
          );
          return $queue;
        })
      ),
      $this->BuildTopContainerMobile(
        "Проекты",
        "Над чем вы хотели бы поработать сегодня?"
      ),
    ]);
  }

  function BuildArticlesMobile() : Element {
    return (new Column)
    ->AddThemeParameter(Height, Auto)
    ->SetChilds([
      $this->BuildTopText(
        "Статьи",
        "Прочитайте статьи которые помогут вам оптимизировать Ваш день"
      )
      ->AddThemeParameter(Padding, [Px(60), Px(40), 0, Px(40)]),
      (new Column)
      ->AddChilds([
        (new HorizontalScrollView)
        ->AddThemeParameter(PaddingBottom, [Px(60)])
        ->AddThemeParameter(PaddingTop, [Px(45)])
        //->AddThemeKey("graver_hide_scrollbar")
        ->SetChild(
          (new Builder)
          ->SetFunction(function ($args) {
            $queue = (new Row);
            $i = 0;
            $queue->AddChild(
              (new Space)
              ->SetSpace(Px(40))
              ->SetOrientation(Space::Horizontal)
            );
            foreach ($this->Articles as $value) {
              $queue->AddChilds([
                (new ArticleCard)
                ->SetImageHeight(Px(150))
                ->SetTitle($value["title"])
                ->SetPictureLink(Url($value["picture"]))
                ->SetRedirectLink("ArticlePage.php?text_id=".$value["id"]."&title=".$value["title"]."&picture=".$value["picture"])
                ->Build()
                ->AddThemeParameter(Width, [Px(350)])
                ->AddThemeParameter(MaxWidth, [Px(350)])
                ->AddThemeParameter(MinWidth, [Px(350)])
                ->AddThemeKey($i < 5 ? "on_show_x_large_translate" : "nonefd")
                ->AddThemeParameter(AnimationDelay, (0.15 * $i)."s")
                ->AddThemeParameter(AnimationDuration, "0.15s"),
                (new Space)
                ->SetOrientation(Space::Horizontal)
                ->SetSpace(Px(15))
              ]);
              ++$i;
            }
            $queue->AddChild(
              (new Space)
              ->SetSpace(Px(25))
              ->SetOrientation(Space::Horizontal)
            );
            return $queue;
          })
        ),
      ]),
    ]);
  }

  function BuildMobile() : Element {
    return (new VerticalScrollView)
    ->SetChild(
      (new Column)
      ->SetChilds([
        $this->BuildArticlesMobile(),
        $this->BuildProjectsMobile()
        ->SetID("projects")
      ])
    );
  }

  function BuildProjectsDesktop() : Element {
    return (new Stack)
    ->SetChilds([
      (new VerticalScrollView)
      ->AddThemeKey("graver_hide_scrollbar")
      ->AddThemeParameter(Padding, [Px(190), Px(41), 0, Px(41)])
      ->SetChild(
        (new Builder)
        ->SetFunction(function ($args) {
          $queue = (new Grid)
          ->AddThemeParameter(Height, Auto)
          ->AddThemeParameter(JustifyContent, Center)
          ->SetSpacing(Px(20))
          ->SetColumnTeample(Repeat("auto-fill", Minmax(Px(13), Px(135))))
          ->AddThemeParameter(PaddingBottom, Px(20));
          $i = 0;
          $anim_speed = 1;
          foreach ($this->Projects as $value) {
            $anim_delta = (0.1 * ($i * $anim_speed));
            $queue->AddChild(
              (new ProjectCard)
              ->SetTitle($value["title"])
              ->SetPictureLink(Url($value["picture"]))
              ->SetRedirectLink("ProjectPage.php?id=" . $value["id"])
              ->Build()
              ->AddThemeKey("on_show_x_translate")
              ->AddThemeParameter(AnimationDelay, $anim_delta > 0 ? $anim_delta."s" : "0s")
            );
            $anim_speed -= 0.015;
            ++$i;
          }
          $queue->AddChild(
            (new CreateProjectCard)
            ->SetRedirectLink("CreateProjectPage.php")
          );
          return $queue;
        })
      ),
      $this->BuildTopContainer(
        "Проекты",
        "Над чем вы хотели бы поработать сегодня?"
      )
    ]);
  }

  function BuildArticlesDesktop() : Element {
    return (new Stack)
    ->SetChilds([
      (new VerticalScrollView)
      ->AddThemeKey("graver_hide_scrollbar")
      ->AddThemeParameter(Padding, [Px(190), Px(50), 0, Px(50)])
      ->SetChild(
        (new Builder)
        ->SetFunction(function ($args) {
          $queue = (new Column);
          $i = 0;
          foreach ($this->Articles as $value) {
            $queue->AddChilds([
              (new ArticleCard)
              ->SetTitle($value["title"])
              ->SetPictureLink(Url($value["picture"]))
              ->SetRedirectLink("ArticlePage.php?text_id=".$value["id"]."&title=".$value["title"]."&picture=".$value["picture"])
              ->Build()
              ->AddThemeKey("on_show_x_large_translate")
              ->AddThemeParameter(AnimationDelay, (0.2 * $i + 0.4)."s")
              ->AddThemeParameter(AnimationDuration, "0.2s"),
              (new Space)
            ]);
            ++$i;
          }
          return $queue;
        })
      ),
      $this->BuildTopContainer(
        "Статьи",
        "Прочитайте статьи которые помогут вам оптимизировать Ваш день"
      )
    ]);
  }

  function BuildDesktop() : Element {
    return (new Row)
    ->SetChilds([
      $this->BuildProjectsDesktop(),
      (new Separator)
      ->SetOrientation(Separator::Horizontal),
      $this->BuildArticlesDesktop()
    ]);
  }

  function Build() : Node {
    return (new Document)
    ->AddTheme(GetGraverTheme())
    ->AddThemes(GetAdaptiveThemes())
    ->AddTheme(GetFontsTheme())
    ->AddThemeParameter(BackgroundColor, Hex("e6e8ea"))
    ->SetTitle("Главная, graver.com")
    ->SetChild(
      (new Queue)
      ->SetChilds([
        $this->BuildDesktop()
        ->AddThemeKeys(["not_mobile"]),
        $this->BuildMobile()
        ->AddThemeKeys(["not_desktop", "not_tablet"])
      ])
    );
  }
}

Node::Run(new HomePage);