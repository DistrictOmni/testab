<?php

namespace App\Modules\Students\Controllers;

use App\Core\Controllers\BaseController;

class StudentController extends BaseController
{
    public function index()
    {
        $data = ['pageTitle' => 'Student Dashboard'];
        
        // Render view with global layout (secured) and a sub-layout for students
        $this->renderWithLayout('students/dashboard', $data, 'sub-layout.php');
    }
    
    public function show($studentId)
    {
        // Render view with global layout (secured) and no sub-layout
        $data = ['pageTitle' => "Student Details for {$studentId}"];
        $this->renderWithLayout('students/details', $data);
    }
}
