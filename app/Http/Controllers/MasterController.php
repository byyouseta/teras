<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MasterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function masterUnit(Request $request)
    {
        return view('master.unit');
    }

    public function masterPegawai(Request $request)
    {
        return view('master.pegawai');
    }

    public function masterRuangan(Request $request)
    {
        return view('master.ruangan');
    }

    public function masterUsers(Request $request)
    {
        return view('master.user');
    }

    public function logUsers(Request $request)
    {
        return view('master.log-users');
    }
}
