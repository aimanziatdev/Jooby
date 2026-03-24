<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search', 'type']))->paginate(6)
        ]);
    }

    public function show(Listing $listing) {
        $myApplication = null;
        if (auth()->check()) {
            $myApplication = \App\Models\Application::where('listing_id', $listing->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('listings.show', [
            'listing' => $listing,
            'myApplication' => $myApplication,
        ]);
    }

    public function create() {
        return view('listings.create');
    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();
        $formFields['type'] = auth()->user()->isCompany() ? 'job' : 'hobby';
        $formFields['salary_min'] = $request->salary_min ?: null;
        $formFields['salary_max'] = $request->salary_max ?: null;

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing) {
        // Ensure only the owner can edit
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing) {
        // Ensure only the owner can update
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            if ($listing->logo && Storage::disk('public')->exists($listing->logo)) {
                Storage::disk('public')->delete($listing->logo);
            }

            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['salary_min'] = $request->salary_min ?: null;
        $formFields['salary_max'] = $request->salary_max ?: null;

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing) {
        // Ensure only the owner can delete
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        if ($listing->logo && Storage::disk('public')->exists($listing->logo)) {
            Storage::disk('public')->delete($listing->logo);
        }

        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings]);
    }
}
