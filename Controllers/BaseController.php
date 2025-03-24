<?php

// class BaseController
// {
//     /**
//      * Helper function to render a view.
//      *
//      * @param string $view The view file to render.
//      * @param array $data The data to pass to the view.
//      */
//     protected function view($viewPath, $data = [])
//     {
//         // Ensure $employees is defined
//         if (!isset($data['employees'])) {
//             $data['employees'] = [];
//         }

//         extract($data);
//         ob_start(); // Start output buffering
//         require_once __DIR__ . '/../views/' . $viewPath . '.php';
//         $content = ob_get_clean();
//         require "views/layout.php";
//         ob_end_flush(); // Flush the output buffer
//     }

//     /**
//      * Helper function to handle redirections.
//      *
//      * @param string $url The URL to redirect to.
//      */
//     protected function redirect($url)
//     {
//         ob_start(); // Start output buffering
//         header("Location: $url");
//         ob_end_flush(); // Flush the output buffer
//         exit;
//     }
// }


            //Test code1  working--------------------------------------------------------------
class BaseController {
    protected function view($viewPath, $data = []) {
        if (!isset($data['employees'])) {
            $data['employees'] = [];
        }
        $viewFile = __DIR__ . '/../views/' . trim($viewPath, '/') . '.php';
        if (!file_exists($viewFile)) {
            die("Error: View file not found at: " . $viewFile);
        }
        extract($data);
        ob_start();
        require_once $viewFile;
        $content = ob_get_clean();
        $layoutFile = __DIR__ . '/../views/layout.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            die("Error: Layout file not found at: " . $layoutFile);
        }
        ob_end_flush();
    }
    protected function redirect($url) {
        ob_start();
        header("Location: $url");
        ob_end_flush();
        exit;
    }
}

?>