<?php

require_once(__DIR__ . "/../../libs/include_tree-php.php");

function GetAdaptiveThemes() : array {
  return (new Queue)
  ->SetChilds([
    // ALl
    (new Theme)
    ->AddThemeBlock(
      (new ThemeBlock)
      ->SetKey("adaptive_dialog")
      ->AddModifier(
        (new StandartModifier)
        ->AddParameter(Height, Auto)
        ->AddParameter(MaxWidth, Px(600))
      ),
    ),

    // MOBILE
    (new Theme)
    ->SetMaxWidth(Px(800))
    ->AddThemeBlocks([
      (new ThemeBlock)
      ->SetKey("not_mobile")
      ->AddModifier(
        (new StandartModifier)
        ->AddParameter(Display, None)
      ),
      (new ThemeBlock)
      ->SetKey("adaptive_dialog")
      ->AddModifier(
        (new StandartModifier)
        ->AddParameter(Height, Pr(100))
        ->AddParameter(MaxWidth, Pr(100))
      )
    ]),
    /// TABLET
    (new Theme)
    ->SetMinWidth(Px(800))
    ->SetMaxWidth(Px(1200))
    ->AddThemeBlocks([
      (new ThemeBlock)
      ->SetKey("not_tablet")
      ->AddModifier(
        (new StandartModifier)
        ->AddParameter(Display, None)
      ),
      (new ThemeBlock)
      ->SetKey("graver_left_auth_title")
      ->AddModifier(
        (new StandartModifier)
        ->AddParameter(FontSize, Px(80))
      ),
      (new ThemeBlock)
      ->SetKey("graver_left_auth_picture")
      ->AddModifier(
        (new StandartModifier)
        ->AddParameter(Width, Pr(50))
      )
    ]),
    /// DESKTOP
    (new Theme)
    ->SetMinWidth(Px(1200))
    ->AddThemeBlock(
      (new ThemeBlock)
      ->SetKey("not_desktop")
      ->AddModifier(
        (new StandartModifier)
        ->AddParameter(Display, None)
      )
    )
  ])
  ->GetChilds();
}