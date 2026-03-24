<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {
    public function show(User $user) {
        return view('profile.show', ['user' => $user]);
    }

    public function edit() {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request) {
        $user = auth()->user();
        $rules = [
            'bio' => 'nullable|string|max:1000',
            'linkedin' => 'nullable|url',
            'portfolio' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
        ];
        if($user->isCompany()) {
            $rules['company_name'] = 'required|min:3';
        } else {
            $rules['name'] = 'required|min:3';
        }
        $formFields = $request->validate($rules);
        if($request->hasFile('avatar')) {
            if($user->avatar) Storage::disk('public')->delete($user->avatar);
            $formFields['avatar'] = $request->file('avatar')->store('avatars','public');
        }
        $user->update($formFields);
        return back()->with('message', 'Profile updated successfully!');
    }

    public function storeProject(Request $request) {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'tags' => 'nullable|string',
        ]);
        $fields['user_id'] = auth()->id();
        if($request->hasFile('image')) {
            $fields['image'] = $request->file('image')->store('projects','public');
        }
        Project::create($fields);
        return back()->with('message', 'Project added successfully!');
    }

    public function destroyProject(Project $project) {
        if($project->user_id != auth()->id()) abort(403);
        if($project->image) Storage::disk('public')->delete($project->image);
        $project->delete();
        return back()->with('message', 'Project deleted!');
    }
}
