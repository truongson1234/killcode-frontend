<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Carbon\Carbon;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $timeRange = $request->input('time_range', 'today');

        switch ($timeRange) {
            case 'today':
                $date = Carbon::today();
                break;
            case '1day':
                $date = Carbon::today()->subDay();
                break;
            case '7days':
                $date = Carbon::today()->subDays(7);
                break;
            case '1month':
                $date = Carbon::today()->subMonth();
                break;
            default:
                $date = Carbon::today()->subDays(7);
                break;
        }

        $posts = Question::where('created_at', '>=', $date)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                        ->orWhere('body', 'like', "%$keyword%");
            })
            ->with('user', 'tags')
            ->withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }])
            ->get();

        return $posts;
    }
}
