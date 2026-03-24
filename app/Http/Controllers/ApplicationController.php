<?php
namespace App\Http\Controllers;
use App\Models\Application;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApplicationController extends Controller {
    public function store(Request $request, Listing $listing) {
        if($listing->user_id == auth()->id()) return back()->with('error', 'You cannot apply to your own listing.');
        $exists = Application::where('listing_id',$listing->id)->where('user_id',auth()->id())->exists();
        if($exists) return back()->with('error', 'You already applied to this job.');
        Application::create([
            'listing_id' => $listing->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);
        return back()->with('message', 'Application submitted successfully!');
    }

    public function myApplications() {
        $applications = auth()->user()->applications()->with('listing')->latest()->get();
        return view('applications.index', compact('applications'));
    }

    public function listingApplicants(Listing $listing) {
        if($listing->user_id != auth()->id()) abort(403);
        $applications = $listing->applications()->with('user')->latest()->get();
        return view('applications.applicants', compact('listing','applications'));
    }

    public function updateStatus(Request $request, Application $application) {
        if($application->listing->user_id != auth()->id()) abort(403);
        $application->update(['status' => $request->status]);
        return back()->with('message', 'Application status updated!');
    }
}
