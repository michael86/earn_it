<?php

function basePath(string $path = ''): string
{
    return BASE_PATH . ltrim($path, DIRECTORY_SEPARATOR);
}

function loadPage(string $viewPage): void
{
    $pagePath = basePath("views/pages/{$viewPage}.php");

    if (file_exists($pagePath)) {
        require_once $pagePath;
        return;
    }

    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        inspectAndDie($viewPage, $pagePath);
    }
}

function loadPartial(string $partialName): void
{
    $partialPath = basePath("views/partials/{$partialName}.php");

    if (file_exists($partialPath)) {
        require_once $partialPath;
        return;
    }

    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        inspectAndDie($partialName, $partialPath);
    }
}

function loadController(string $controllerName): void
{
    $controllerPath = basePath("controllers/{$controllerName}.php");

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        return;
    }

    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        inspectAndDie($controllerName, $controllerPath);
    }
}

function loadConfig(string $file): void
{
    $configPath = basePath("config/{$file}.php");

    if (file_exists($configPath)) {
        
        require_once $configPath;
        return;
    }

    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        inspectAndDie($file, $configPath);
    }
}
