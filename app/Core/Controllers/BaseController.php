<?php
namespace App\Core\Controllers;

use App\Core\Views\ViewRenderer;

class BaseController
{
    protected $view;

    public function __construct()
    {
        $this->view = new ViewRenderer();
    }

    /**
     * Render the view within a layout.
     *
     * @param string $viewName The view file name (without extension).
     * @param array $data The data to be passed to the view.
     * @param bool $useSecondLevelLayout Whether to use a second-level layout.
     */
    protected function render($viewName, $data = [], $useSecondLevelLayout = false)
    {
        // Determine which layout to use
        $layout = 'layouts/top-level-layout.php';  // Default to the top-level layout

        if ($useSecondLevelLayout) {
            $layout = 'layouts/second-level-layout.php';  // Optionally use second-level layout
        }

        // Render the layout with the view injected inside it
        $this->view->render($layout, $viewName, $data);
    }
}
