<?php

require_once(__DIR__ . "/libs/tree-php/Includes/All.php");


function Bufdsfsf() {
  return (new Document)
  ->SetTitle("Test Page")
  ->SetChild(
    (new Row)
    ->AddChild(
      (new Text)
      ->AddThemeParameter(FontSize, Px(100))
      ->SetText("Hello World")
    )
    ->AddChild(
      (new Text)
      ->SetText("Hello World")
    )
    ->AddChild(
      (new Text)
      ->SetText("Hello World")
    )
    ->AddChild(
      (new Text)
      ->SetText("Hello World")
    )
  );
}

Node::Run(Bufdsfsf());