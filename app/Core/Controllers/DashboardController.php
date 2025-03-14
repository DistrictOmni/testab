<?php
namespace App\Controllers;

use App\Core\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        // Render dashboard or appropriate content for /test route
        $data = ['pageTitle' => 'Test Page'];
        $this->render('test-page', $data);
    }
}
