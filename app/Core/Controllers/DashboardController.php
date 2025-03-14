<?php
namespace App\Controllers;

use App\Core\Controllers\BaseController; // Make sure you use your base controller

class DashboardController extends BaseController
{
    /**
     * Displays the user dashboard.
     */
    public function index()
    {
        // Set the page title for the dashboard
        $this->view->pageTitle = "User Dashboard";

        // Optionally, you can set any data you want to pass to the view
        $data = ['pageTitle' => $this->view->pageTitle];

        // Check if the user is authenticated
        $isAuthenticated = isset($_SESSION['user']); // Adjust based on your auth logic

        // Pass data and render the appropriate layout
        if ($isAuthenticated) {
            // If logged in, render the secured layout
            $this->renderWithLayout('dashboard/index', $data, 'secured');
        } else {
            // If not logged in, render the public layout
            $this->renderWithLayout('dashboard/index', $data, 'auth');
        }
    }
}
