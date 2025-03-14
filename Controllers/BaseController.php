<?php

class BaseController
{
    /**
     * Helper function to render a view.
     *
     * @param string $view The view file to render.
     * @param array $data The data to pass to the view.
     */
    protected function view($viewPath, $data = [])
    {
        extract($data);
        ob_start(); // Start output buffering
        require_once __DIR__ . '/../views/' . $viewPath . '.php';
        $content = ob_get_clean();
        require "views/layout.php";
        ob_end_flush(); // Flush the output buffer
    }

    /**
     * Helper function to handle redirections.
     *
     * @param string $url The URL to redirect to.
     */
    protected function redirect($url)
    {
        ob_start(); // Start output buffering
        header("Location: $url");
        ob_end_flush(); // Flush the output buffer
        exit;
    }
}
?>