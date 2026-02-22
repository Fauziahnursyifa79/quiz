<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Materi;
use App\Models\Questions;
use App\Models\Quiz;
use App\Models\Results;
use App\Models\User_answer;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->roles->first()->name == 'admin') {
            //ketika user hak akses admin maka di arahkan ke route admin dashboard
            return redirect()->route('admin.dashboard');
        }elseif (Auth::user()->roles->first()->name == 'viewer') {
            //ketika user hak akses viewer maka di arahkan ke route viewer dasboard
            return redirect()->route('viewer.materi.index');
        }else {
            //ketika bukan viewer / admin maka kita arahkan ke halaman awal
            return redirect()->route('welcome');
        }
    }


    public function admin()
    {
        $data = [
            'total_quiz'         => Quiz::count(),
            'total_questions'    => Questions::count(),
            'total_user_answers' => User_answer::count(),
            'total_results'      => Results::count(),
        ];

        return view('home', $data);
    }


    public function viewer()
    {
        // Mengambil semua data materi
        $materis = Materi::all();

        // Mengirim data ke view dashboard.blade.php
        return view('view.materi.dashboard', compact('materis'));

    }


}
