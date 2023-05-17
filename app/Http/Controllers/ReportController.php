<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::with('user', 'post')->get()->map(function ($report) {
            $report->sender = [
                'name' => $report->user->name,
                'avatar' => 'http://localhost:8000/images/' . $report->user->avatar,
                'route' => [
                    'name' => 'InfoUser',
                    'params' => [
                        'id' => $report->user->id
                    ]
                ]
            ];

            $report->violator = [
                'name' => $report->post->user->name,
                'avatar' => 'http://localhost:8000/images/' . $report->post->user->avatar,
                'route' => [
                    'user' => [
                        'name' => 'InfoUser',
                        'params' => [
                            'id' => $report->post->user->id
                        ]
                    ],
                    'post' => [
                        'name' => 'PostDetail',
                        'params' => [
                            'id' => $report->post->id
                        ]
                    ]
                ]
            ];

            unset($report->user);
            unset($report->post);

            return $report;
        });

        return response()->json($reports);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Report $report)
    {
        if (auth()->user()->hasPermissionTo('write-report')) {
            $report->create([
                'user_id' => $request->input('user_id'),
                'post_id' => $request->input('post_id'),
                'reason' => $request->input('reason')
            ]);
            
            return response()->json([
                'status' => 1,
                'message' => 'Đã gửi báo cáo.'
            ], 201);
        } else {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => 'Bạn không có quyền viết tố cáo!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report, $id)
    {
        if (auth()->user()->hasPermissionTo('delete-report')) {
            $report->find($id)->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Xóa thành công báo cáo.'
            ]);
        } else {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => 'Bạn không có quyền tạo bài viết!'
            ]);
        }
    }
}
