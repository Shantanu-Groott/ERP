<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], ?string $layout = null): void
    {
        extract($data);

        $viewPath = dirname(dirname(__DIR__)) . '/app/Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "View [{$view}] not found at {$viewPath}.";
            return;
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout !== null) {
            $layoutPath = dirname(dirname(__DIR__)) . '/app/Views/layouts/' . $layout . '.php';
            if (file_exists($layoutPath)) {
                require $layoutPath;
                return;
            }
        }

        echo $content;
    }

    public static function csrfField(): string
    {
        $token = Session::token();
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function escape($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}
