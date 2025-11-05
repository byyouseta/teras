<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AgendaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index(Request $request)
    {
        return view('agenda.agenda');
    }

    public function dashboard(Request $request)
    {
        return view('dashboard2');
    }

    public function detail(Request $request)
    {
        return view('agenda.detail');
    }
}
