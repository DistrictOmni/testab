<?php
namespace App\Core\Views;

class ViewRenderer
{
    /**
     * Render the layout and inject the view content.
     *
     * @param string $layout The layout file to be used.
     * @param string $viewName The name of the view to be included in the layout.
     * @param array $data The data to be passed to the view.
     */
    public function render($layout, $viewName, $data = [])
    {
        // Extract data to be available as variables inside the view
        extract($data);

        // Include the layout file (it will internally include the view)
        include_once $layout;
    }
}
