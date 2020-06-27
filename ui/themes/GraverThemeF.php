<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");
require_once(__DIR__ . "/../elements/include.php");

function GetGraverTheme() : Theme {
  return (new Theme)
  ->AddThemeBlocks([
    (new ThemeBlock)
    ->SetKey("graver_list_item")
    ->AddModifiers([
      (new StandartModifier)
      ->AddParameter(FontSize, Px(14))
      ->AddParameter(Padding, [Px(1), 0]),
      (new HoverModifier)
      ->AddParameter(FontSize, Px(16))
      ->AddParameter(Padding, 0)
      ->AddParameter(BackgroundColor, Hex("e3e8ec6b"))
      ->AddParameter(BorderTop, [Px(1), Solid, Hex("f9f9f9db")])
      ->AddParameter(BorderBottom, [Px(1), Solid, Hex("adadadcc")]),
    ]),
    (new ThemeBlock)
    ->SetKey("graver_list_item:active > *")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Transition, "all ease 0.2s")
      ->AddParameter(Transform, Scale(0.98, 0.96))
      ->AddParameter(Filter, Blur(Px(0.5)))
    ),

    (new ThemeBlock)
    ->SetKey("graver_check_line")
    ->AddModifiers([
      (new HoverModifier)
      ->AddParameter(BackgroundColor, Hex("3a3a3a12"))
    ]),

    (new ThemeBlock)
    ->SetKey("graver_check_line_link")
    ->AddModifiers([
      (new StandartModifier)
      ->AddParameter(Color, Gray),
      (new HoverModifier)
      ->AddParameter(Color, Hex("166edb"))
    ]),

    (new ThemeBlock)
    ->SetKey("graver_field")
    ->AddModifiers([
      (new StandartModifier)
      ->AddParameter(Padding, [Px(10),Px(16)])
      ->AddParameter(Outline, None)
      ->AddParameter(BackgroundColor, Rgba(255, 255, 255, 0.35))
      ->AddParameter(Outline, None)
      ->AddParameter(Border, [Px(1), Solid, Hex("8c8c8c33")])
      ->AddParameter(BorderTop, [Px(1), Solid, White])
      ->AddParameter(BorderBottom, [Px(1), Solid, Hex("adadadcc")])
      ->AddParameter(BorderRadius, Px(5)),
      (new FocusModifier)
      ->AddParameter(Border, [
        Px(1),
        Solid,
        Hex("2294f5")
      ])
      ->AddParameter(BorderTop, [
        Px(1),
        Solid,
        Hex("51adf0")
      ])
      ->AddParameter(BorderBottom, [
        Px(1),
        Solid,
        Hex("0872c9")
      ]),
    ]),
    
    (new ThemeBlock)
    ->SetKey("graver_add_project_button > * > p")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Color, Gray)
      ->AddParameter(FontSize, Px(28))
    ),
    (new ThemeBlock)
    ->SetKey("graver_add_project_button:hover > * > p")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(FontWeight, 300)
      ->AddParameter(Color, Hex("166edb"))
    ),

    (new ThemeBlock)
    ->SetKey("graver_project_card")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Transition, "all ease 0.5s")
      ->AddParameter(BackgroundColor, Hex("d9d9d9"))
      ->AddParameter(BorderRadius, Px(5))
      ->AddParameter(Border, [Px(1), Solid, Hex("adadad59")])
      ->AddParameter(BorderTop, [Px(1), Solid, Hex("ffffffe0")])
      ->AddParameter(BorderBottom, [Px(1), Solid, Hex("b3b3b3")])
    )
    ->AddModifier(
      (new HoverModifier)
      ->AddParameter(BorderColor, Hex("119ef7"))
      ->AddParameter(Border, [Px(2), Solid, Hex("2294f5")])
      ->AddParameter(BorderTop, [Px(2), Solid, Hex("51adf0")])
      ->AddParameter(BorderBottom, [Px(2), Solid, Hex("0872c9")])
      ->AddParameter(Transform, Scale(1.05, 1.05))
      ->AddParameter(Padding, Px(2))
    )
    ->AddModifier(
      (new ActiveModifier)
      ->AddParameter(Filter, Blur(Px(0.45)))
      ->AddParameter(Transform, Scale(0.999, 0.999))
    ),
    (new ThemeBlock)
    ->SetKey("graver_project_card:hover > div > div")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(BorderRadius, Px(2))
      ->AddParameter(BackdropFilter, Blur(Px(4)))
      ->AddParameter(BackgroundColor, Hex("ffffff30"))
      ->AddParameter(Webkit(BackdropFilter), Blur(Px(4)))
    ),
    (new ThemeBlock)
    ->SetKey("graver_project_card > div > div")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Transition, "all ease 0.8s")
      ->AddParameter(BackgroundColor, Hex("ffffff90"))
      ->AddParameter(BackdropFilter, Blur(Px(25)))
      ->AddParameter(BorderRadius, Px(4))
      ->AddParameter(Webkit(BackdropFilter), Blur(Px(25)))
    ),
    (new ThemeBlock)
    ->SetKey("graver_project_card > div")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(BorderRadius, Px(4))
    ),
    (new ThemeBlock)
    ->SetKey("graver_project_card:hover > div")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(BorderRadius, Px(2))
    ),

    (new ThemeBlock)
    ->SetKey("graver_button")
    ->AddModifiers([
      (new StandartModifier)
      ->AddParameter(Transition, "all ease 0.225s")
      ->AddParameter(Color, Black)
      ->AddParameter(FontWeight, 500)
      ->AddParameter(BackgroundColor, Hex("e3e8ec6b"))
      ->AddParameter(Padding, [Px(10),Px(16)])
      ->AddParameter(BorderRadius, Px(5))
      ->AddParameter(Outline, None)
      ->AddParameter(TextDecoration, None)
      ->AddParameter(TextAlign, Center)
      ->AddParameter(Border, [Px(1), Solid, Hex("8c8c8c33")])
      ->AddParameter(BorderTop, [Px(1), Solid, Hex("f9f9f9db")])
      ->AddParameter(BorderBottom, [Px(1), Solid, Hex("adadadcc")]),
      (new HoverModifier)
      ->AddParameter(TextDecoration, None)
      ->AddParameter(Color, Hex("166edb")),
      (new ActiveModifier)
      ->AddParameter(Filter, Blur(Px(0.25)))
      ->AddParameter(Transform, Scale(0.975, 0.99))
    ]),

    (new ThemeBlock)
    ->SetKey("graver_card")
    ->SetModifiers([
      (new StandartModifier)
      ->AddParameter(Transition, "all ease 0.1s")
      ->AddParameter(BorderRadius, Px(4))
      ->AddParameter(BorderTop, [
        Px(1),
        Solid,
        Hex("a2a2a2b3")
      ])
      ->AddParameter(BorderBottom, [
        Px(1),
        Solid,
        Hex("77777791")
      ]),
      //->AddParameter(BackdropFilter, Blur(Px(0)))
      (new HoverModifier)
      ->AddParameter(BackdropFilter, Blur(Px(10)))
      ->AddParameter(BackgroundColor, Rgba(255, 255, 255, 0.4))
    ]),
    (new ThemeBlock)
    ->SetKey("graver_card > *")
    ->SetModifiers([
      (new StandartModifier)
      ->AddParameter(Display, None)
    ]),
    (new ThemeBlock)
    ->SetKey("graver_card:hover > *")
    ->SetModifiers([
      (new StandartModifier)
      ->AddParameter(Display, Block)
    ]),

    (new ThemeBlock)
    ->SetKey("graver_hide_scrollbar")
    ->SetModifiers([
      (new StandartModifier)
      ->AddParameter(Overflow, "-moz-scrollbars-none")
      ->AddParameter("-ms-overflow-style", None),
      (new WebKitScrollBarModifier)
      ->AddParameter(Display, None)
    ]),
    (new ThemeBlock)
    ->SetKey("graver_auth_title")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(FontSize, Px(100))
      ->AddParameter(Color, Hex("fcfcfc"))
    ),
    (new ThemeBlock)
    ->SetKey("graver_auth_form_title")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(FontWeight, 500)
      ->AddParameter(FontSize, Px(30))
    ),
    (new ThemeBlock)
    ->SetKey("on_show_x_translate")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Animation, "show_from 0.3s linear 1 alternate-reverse backwards")
    ),

    (new ThemeBlock)
    ->SetKey("on_show_x_large_translate")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Animation, "show_from_large 0.3s linear 1 alternate-reverse backwards")
    ),

    (new ThemeBlock)
    ->SetKey("on_show_translate")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Animation, [
        "show_from", 
        ".6s",
        "ease-in-out", 
        "alternate-reverse"
      ])
    ),
    (new ThemeBlock)
    ->SetKey("graver_page_background")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(BackgroundColor, Hex("fcfcfc"))
    ),
    (new ThemeBlock)
    ->SetKey("graver_auth_form_background")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(BackdropFilter, Blur(Px(30)))
      ->AddParameter(Webkit(BackdropFilter), Blur(Px(30)))
      ->AddParameter(BackgroundColor, Rgba(255, 255, 255, 0.8))
    ),
    (new ThemeBlock)
    ->SetKey("a")
    ->SetType(ThemeBlockTypes::Core)
    ->AddModifiers([
      (new StandartModifier)
      ->AddParameter(FontWeight, 500)
      ->AddParameter(Color, Hex("166edb"))
      ->AddParameter(TextDecoration, None),
      (new HoverModifier)
      ->AddParameter(TextDecoration, Underline),
      (new ActiveModifier)
      ->AddParameter(Color, Hex("cc941d"))
    ]),
    (new ThemeBlock)
    ->SetKey("graver_auth_field")
    ->AddModifiers([
      (new StandartModifier)
      ->AddParameter(Padding, [Px(0), Px(16)])
      ->AddParameter(Outline, None)
      ->AddParameter(BackgroundColor, Rgba(255, 255, 255, 0.5))
      ->AddParameter(BorderTop, [
        Px(1),
        Solid,
        Hex("ffffffc9")
      ])
      ->AddParameter(BorderBottom, [
        Px(1),
        Solid,
        Hex("80808057")
      ])
      ->AddParameter(BorderRadius, Px(5))
      ->AddParameter(MinHeight, Px(45))
      ->AddParameter(MaxHeight, Px(45))
      ->AddParameter(Height, Px(45)),
      (new FocusModifier)
      ->AddParameter(Padding, [Px(0), Px(15)])
      ->AddParameter(Border, [
        Px(1),
        Solid,
        Hex("2294f5")
      ])
      ->AddParameter(BorderTop, [
        Px(1),
        Solid,
        Hex("51adf0")
      ])
      ->AddParameter(BorderBottom, [
        Px(1),
        Solid,
        Hex("0872c9")
      ]),
    ]),
    (new ThemeBlock)
    ->SetKey("graver_auth_button")
    ->AddModifiers([
      (new StandartModifier)
      ->AddParameter(Transition, "all ease 0.3s")
      ->AddParameter(Color, Hex("166edb"))
      ->AddParameter(FontWeight, 500)
      ->AddParameter(Background, "linear-gradient(0.25turn, #c5c5c57a, #c5c5c57a)")
      ->AddParameter(Padding, [
        Px(0),
        Px(16)
      ])
      ->AddParameter(BorderRadius, Px(5))
      ->AddParameter(Outline, None)
      ->AddParameter(MinHeight, Px(45))
      ->AddParameter(MaxHeight, Px(45))
      ->AddParameter(Height, Px(45))
      //->AddParameter(Border, [Px(1), Solid, Transparent])
      ->AddParameter(BorderTop, [
        Px(1),
        Solid,
        Hex("f1f1f1bf")
      ])
      ->AddParameter(BorderBottom, [
        Px(1),
        Solid,
        Hex("80808057")
      ]),
      (new HoverModifier)
      ->AddParameter(Background, "linear-gradient(0.25turn, #c5c5c57a, #c5c5c5)")
      ->AddParameter(Color, White),
      (new ActiveModifier)
      ->AddParameter(Filter, Blur(Px(0.75)))
      ->AddParameter(Transform, Scale(0.975, 0.99))
    ]),
    (new ThemeBlock)
    ->SetKey("graver_shake_error_text")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(Color, Red)
      ->AddParameter(Animation, ["graver_shake_text_keys", ".2s", "ease-in-out", "5", "alternate-reverse"])
    )
  ])
  ->SetFrameBlocks([
    (new FrameBlock)
    ->SetKey("graver_shake_text_keys")
    ->AddFrames([
      (new Frame)
      ->SetValue(Pr(0))
      ->AddParameter(Transform, Translate(0, 0)),
      (new Frame)
      ->SetValue(Pr(25))
      ->AddParameter(Color, Hex("ff4040"))
      ->AddParameter(Filter, Blur(Px(0.5))),
      (new Frame)
      ->SetValue(Pr(50))
      ->AddParameter(Filter, Blur(Px(1.2))),
      (new Frame)
      ->SetValue(Pr(75))
      ->AddParameter(Color, Hex("ff4040"))
      ->AddParameter(Filter, Blur(Px(0.5))),
      (new Frame)
      ->SetValue(Pr(100))
      ->AddParameter(Transform, Translate(Px(10), 0)),
    ]),
    (new FrameBlock)
    ->SetKey("show_from")
    ->AddFrames([
      (new Frame)
      ->SetValue(Pr(50))
      ->AddParameter(Opacity, 1),
      (new Frame)
      ->SetValue(Pr(100))
      ->AddParameter(Opacity, 0),
      (new Frame)
      ->SetValue(To)
      ->AddParameter(Transform, Scale(0.9, 0.9))
      ->AddParameter(Filter, Blur(Px(1.75)))
    ]),
    (new FrameBlock)
    ->SetKey("show_from_large")
    ->AddFrames([
      (new Frame)
      ->SetValue(Pr(50))
      ->AddParameter(Opacity, 1),
      (new Frame)
      ->SetValue(Pr(100))
      ->AddParameter(Opacity, 0),
      (new Frame)
      ->SetValue(To)
      ->AddParameter(Transform, Scale(0.97, 0.97))
      ->AddParameter(Filter, Blur(Px(1.75)))
    ])
  ]);
}

function DUO($child, bool $f) {
  return (new Column)
  ->AddThemeParameter(Padding, Px(75))
  ->AddThemeParameter(Padding, Px(50))
  ->SetChilds([
    (new Column)
    ->SetCrossAlign(CrossAxisAligns::Center)
    ->AddChild(
      (new Text)
      ->AddThemeParameter(FontSize, Px(25))
      ->SetText("Surface Duo")
    ),
    (new Space)
    ->SetSpace(Px(50)),
    (new Container)
    ->AddThemeParameter(Padding, Px(25))
    ->AddThemeParameter(BackgroundColor, Black)
    ->AddThemeParameter(BorderRadius, $f ? [Px(20), 0, 0, Px(20)] : Px(20))
    ->AddThemeParameter(BoxShadow, [0, 0, Px(4), Rgba(0,0,0,0.5)])
    ->SetChild(
      (new Container)
      ->AddThemeParameter(Border, [Px(1), Solid, White])
      ->SetChild($child)
    )
  ]);
}