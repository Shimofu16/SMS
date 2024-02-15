<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class StudentDashboard extends \Filament\Pages\Dashboard
{
    protected static string $routePath = '/dashboard';

    protected static ?string $title = 'Student dashboard';
}
