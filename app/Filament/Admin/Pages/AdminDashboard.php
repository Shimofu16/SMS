<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class AdminDashboard extends \Filament\Pages\Dashboard
{
    protected static string $routePath = '/dashboard';

    protected static ?string $title = 'Admin dashboard';
}

