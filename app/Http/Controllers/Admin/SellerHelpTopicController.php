<?php

namespace App\Http\Controllers\Admin;

use App\Model\HelpTopic;
use Illuminate\Http\Request;
use App\Model\SellerHelpTopic;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class SellerHelpTopicController extends Controller
{
    

    public function add_new()
    {
        return view('admin-views.help-topics.add-new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer'   => 'required',
            'ranking'   => 'required',
        ], [
            'question.required' => 'Question name is required!',
            'answer.required'   => 'Question answer is required!',
        ]);
        $helps = new SellerHelpTopic;
        $helps->question = $request->question;
        $helps->answer = $request->answer;
        $request->has('status')? $helps->status = 1 : $helps->status = 0;
        $helps->ranking = $request->ranking;
        $helps->save();

        Toastr::success(translate('FAQ_added_successfully'));
        return back();
    }
    public function status($id)
    {
        $helps = SellerHelpTopic::findOrFail($id);
        if ($helps->status == 1) {
            $helps->update(["status" => 0]);

        } else {
            $helps->update(["status" => 1]);

        }
        return response()->json(['success' => translate('status_change_successfully')]);
    }
    public function edit($id)
    {
        $helps = SellerHelpTopic::findOrFail($id);
        return response()->json($helps);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer'   => 'required',
        ], [
            'question.required' => 'Question name is required!',
            'answer.required'   => 'Question answer is required!',

        ]);
        $helps = SellerHelpTopic::find($id);
        $helps->question = $request->question;
        $helps->answer = $request->answer;
        $helps->ranking = $request->ranking;
        $helps->update();
        Toastr::success(translate('FAQ_Update_successfully'));
        return back();
    }

    function list() {
        $helps = SellerHelpTopic::latest()->get();

        return view('admin-views.seller-help-topics.list', compact('helps'));
    }

    public function destroy(Request $request)
    {

        $helps = SellerHelpTopic::find($request->id);
        $helps->delete();
        return response()->json();
    }



}
