<?php

function basePath(string $path = ''): string
{
    return BASE_PATH . ltrim($path, DIRECTORY_SEPARATOR);
}

function loadPage(string $viewPage): void
{
    $pagePath = basePath("App/views/pages/{$viewPage}.php");

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
    $partialPath = basePath("App/views/partials/{$partialName}.php");

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
    $controllerPath = basePath("App/controllers/{$controllerName}.php");

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
    $configPath = basePath("Config/{$file}.php");

    if (file_exists($configPath)) {
        
        require_once $configPath;
        return;
    }

    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        inspectAndDie($file, $configPath);
    }
}

function loadFramework(string $file): void
{
    $frameworkPath = basePath("Framework/{$file}.php");

    if (file_exists($frameworkPath)) {
        
        require_once $frameworkPath;
        return;
    }

    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        inspectAndDie($file, $frameworkPath);
    }
}
