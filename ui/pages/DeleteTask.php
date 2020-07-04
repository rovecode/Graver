<?php

require_once(__DIR__ . "/../../backend/include.php");
require_once(__DIR__ . "/../../libs/include_tree-php.php");

TaskController::GetInstance()->DeleteTask($_GET["task_id"]);

if (Action::GetValue("all") == "true")
  Controller::RedirectTo("ProjectPage.php?splash=false&is_all=true&splash_tasks=false&id=".$_GET["project_id"]);
else
  Controller::RedirectTo("ProjectPage.php?splash=false&splash_tasks=false&id=".$_GET["project_id"]."&folder_id=".$_GET["folder_id"]);