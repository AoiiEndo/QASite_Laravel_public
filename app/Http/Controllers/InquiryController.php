<?php

namespace App\Http\Controllers;

use App\Enums\InquiryType;
use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of the inquiries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inquiries = Inquiry::all()->map(function ($inquiry) {
            $inquiry->status = InquiryStatus::getDescription($inquiry->status);
            $inquiry->inquiry_type = InquiryType::getDescription($inquiry->inquiry_type);
            return $inquiry;
        });
    
        return view('inquiries.index', compact('inquiries'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'inquiry_id' => 'required|exists:inquiries,id',
            'answer' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $inquiry = Inquiry::find($request->inquiry_id);
        $inquiry->status = $request->status;
        $inquiry->answer = $request->answer;

        $inquiry->save();

        return response()->json(['message' => 'お問い合わせ内容が更新されました。']);
    }
}
