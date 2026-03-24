<?php
namespace App\Http\Controllers;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OfferController extends Controller {
    public function store(Request $request, User $user) {
        if(!auth()->user()->isCompany()) abort(403, 'Only companies can send offers.');
        $fields = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        Offer::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $user->id,
            'subject' => $fields['subject'],
            'message' => $fields['message'],
            'salary_min' => $request->salary_min ?: null,
            'salary_max' => $request->salary_max ?: null,
        ]);
        return back()->with('message', 'Offer sent to '.$user->name.'!');
    }

    public function myOffers() {
        $offers = auth()->user()->offersReceived()->with('sender')->latest()->get();
        return view('offers.index', compact('offers'));
    }

    public function sentOffers() {
        if(!auth()->user()->isCompany()) abort(403);
        $offers = auth()->user()->offersSent()->with('receiver')->latest()->get();
        return view('offers.sent', compact('offers'));
    }

    public function updateStatus(Request $request, Offer $offer) {
        if($offer->to_user_id != auth()->id()) abort(403);
        $offer->update(['status' => $request->status]);
        return back()->with('message', 'Offer '.$request->status.'!');
    }
}
