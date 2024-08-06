<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        if(User::find($request['user_id'])?->role != 'user') self::unHandledError('Must report on normal user only');

        self::ok(Report::create([
            "trademark_id" => $request->user()->id,
            "user_id" => $request['user_id'],
            "type" => $request['type'],
        ]));
    }

    public function index(Request $request)
    {
        if(!isset($request['user_id'])){

            if($request->user()->role == "trademark_owner")
                self::ok(Report::latest()->where('trademark_id',$request->user()->id)->get());
            else
                self::ok(Report::latest()->where('user_id',$request->user()->id));

        }else if(isset($request['user_id'])){

            $user = User::find($request['user_id']);

            if(!$user) self::notFound();

            if($user->role == "trademark_owner")
                self::ok(Report::latest()->where('trademark_id',$request->user()->id)->get());
            else
                self::ok(Report::latest()->where('user_id',$request->user()->id));

        }else{
            self::unHandledError("Invalid request");
        }
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
