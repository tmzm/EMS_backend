<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        self::ok(Report::create([
            "user_id" => $request->user()->id,
            "trademark_id" => $request['trademark_id'],
            "type" => $request['type'],
        ]));
    }

    public function index(Request $request)
    {
        self::ok(Report::latest()->where('trademark_id',$request->user()->id)->get());
    }

    public function index_trademark_reports(Request $request)
    {
        self::ok(Report::latest()->where('trademark_id',$request['user_id'])->get());
    }

    public function index_reports_on_user(Request $request)
    {
        self::ok(Report::latest()->where('user_id',$request['user_id'])->get());
    }

    public function show($report_id)
    {
        $report = Report::find($report_id);
        $report ? self::ok($report) : self::notFound();
    }

    public function destroy($report_id)
    {
        $report = Report::find($report_id);

        if($report){
            $report->delete();

            self::ok();
        }

        self::notFound();
    }
}
