@extends('Layout')

@section('content')
<div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
   
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">
            Create a jobby
        </h2>
        <p class="mb-4">Post a job or hobby to find what you need</p>
    </header>

    <form method="POST" action="/listings" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="company" class="inline-block text-lg mb-2">Company/developer Name</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="company" value="{{ old('company') }}">
            @error('company')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="title" class="inline-block text-lg mb-2">Jobby Title</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title" placeholder="Example: Senior Laravel Developer" value="{{ old('title') }}">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="location" class="inline-block text-lg mb-2">Jobby Location</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="location" placeholder="Example: Remote, Rabat, etc" value="{{ old('location') }}">
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="email" class="inline-block text-lg mb-2">Contact Email</label>
            <input type="email" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="website" class="inline-block text-lg mb-2">Website/Application URL</label>
            <input type="url" class="border border-gray-200 rounded p-2 w-full" name="website" value="{{ old('website') }}">
            @error('website')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="tags" class="inline-block text-lg mb-2">Tags (Comma Separated)</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags" placeholder="Example: Laravel, Backend, Postgres, etc" value="{{ old('tags') }}">
            @error('tags')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="logo" class="inline-block text-lg mb-2">Company/Project Logo</label>
            <input type="file" class="border border-gray-200 rounded p-2 w-full" name="logo">
            @error('logo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="inline-block text-lg mb-2">Jobby Description</label>
            <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10" placeholder="Include tasks, requirements, salary, etc">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <button type="submit" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">Create jobby</button>
            <a href="/" class="text-black ml-4"> Back </a>
        </div>
    </form>
</div>
@endsection
