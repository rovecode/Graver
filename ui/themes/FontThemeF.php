<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");

function GetFontsTheme() : Theme {
  return (new Theme)
  ->AddThemeBlock(
    (new ThemeBlock)
    ->SetKey("font-face")
    ->SetType(ThemeBlockTypes::Link)
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(FontFamily, "'Material Icons'")
      ->AddParameter(FontStyle, Normal)
      ->AddParameter(FontWeight, 400)
      ->AddParameter("src", [
        Url("https://fonts.gstatic.com/s/materialicons/v50/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.woff2"),
        Format("'woff2'")
      ])
    )
  )
  ->AddThemeBlock(
    (new ThemeBlock)
    ->SetKey("material_icons")
    ->AddModifier(
      (new StandartModifier)
      ->AddParameter(FontFamily, "'Material Icons'")
      ->AddParameter(FontWeight, Normal)
      ->AddParameter(FontStyle, Normal)
      // Preferred icon size.
      ->AddParameter(FontSize, Px(24))
      ->AddParameter(Display, InlineBlock)
      ->AddParameter(LineHeight, 1)
      ->AddParameter(TextTransform, None)
      ->AddParameter(LetterSpacing, Normal)
      ->AddParameter(WordWrap, Normal)
      ->AddParameter(WhiteSpace, NoWrap)
      ->AddParameter(Direction, LTR)
      // Support for all WebKit browsers.
      ->AddParameter(WebKit(FontSmoothing), Antialiased)
      // Support for Safari and Chrome.
      ->AddParameter(TextRendering, OptimizeLegibility)
      // Support for IE.
      ->AddParameter(FontFeatureSettings, "'liga'")
    )
  );
}