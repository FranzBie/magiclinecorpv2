<?php

namespace App\Http\Controllers;
use App\Models\Mannequin;
use App\Models\Category;
use App\Models\Company;
use App\Models\Type;
use App\Models\User;
use App\Models\AuditTrail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $mannequins = Mannequin::all(); // Super users see all data
        $companies = Company::all();

        return view('dashboard')->with([
            'categories' => $categories,
            'mannequins' => $mannequins,
            'companies' => $companies,
        ]);
    }
}
