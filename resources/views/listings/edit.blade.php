@extends('Layout')

@section('content')

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-12">

  <!-- Back -->
  <a href="/listings/manage" class="inline-flex items-center space-x-2 text-gray-500 hover:text-gray-900 text-sm font-medium mb-8 group transition-colors">
    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
    <span>Back to Dashboard</span>
  </a>

  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="bg-brand-black px-8 py-6">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-brand-red rounded-xl flex items-center justify-center">
          <i class="fa-solid fa-pen text-white"></i>
        </div>
        <div>
          <h2 class="text-xl font-black text-white">Edit Job Listing</h2>
          <p class="text-gray-400 text-sm truncate max-w-xs">{{$listing->title}}</p>
        </div>
      </div>
    </div>

    <div class="p-8">
      @if(session('success'))
      <div class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
        <i class="fa-solid fa-circle-check text-brand-green"></i>
        <span class="font-medium text-sm">{{ session('success') }}</span>
      </div>
      @endif

      <form method="POST" action="/listings/{{$listing->id}}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <!-- Company -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Company / Developer Name <span class="text-brand-red">*</span></label>
            <input type="text" name="company" value="{{$listing->company}}"
              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all">
            @error('company')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Title -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Job Title <span class="text-brand-red">*</span></label>
            <input type="text" name="title" value="{{$listing->title}}"
              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all">
            @error('title')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Location -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-location-dot text-gray-400 text-sm"></i>
              </div>
              <input type="text" name="location" value="{{$listing->location}}"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all">
            </div>
            @error('location')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Email -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-envelope text-gray-400 text-sm"></i>
              </div>
              <input type="email" name="email" value="{{$listing->email}}"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all">
            </div>
            @error('email')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Salary Range -->
        @if($listing->type === 'job')
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Salary Range <span class="text-gray-400 font-normal text-xs">(optional — indicative)</span>
          </label>
          <div class="flex items-center gap-3">
            <div class="relative flex-1">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 text-sm font-medium pointer-events-none">From</span>
              <input type="number" name="salary_min" value="{{ $listing->salary_min }}" min="0"
                class="w-full pl-14 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all"
                placeholder="5000">
            </div>
            <span class="text-gray-400 font-bold flex-shrink-0">–</span>
            <div class="relative flex-1">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 text-sm font-medium pointer-events-none">To</span>
              <input type="number" name="salary_max" value="{{ $listing->salary_max }}" min="0"
                class="w-full pl-8 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all"
                placeholder="12000">
            </div>
            <span class="text-gray-400 text-sm font-medium flex-shrink-0">MAD/mo</span>
          </div>
        </div>
        @endif

        <!-- Website -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Website / Application URL</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
              <i class="fa-solid fa-globe text-gray-400 text-sm"></i>
            </div>
            <input type="url" name="website" value="{{$listing->website}}"
              class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all">
          </div>
          @error('website')
          <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
          @enderror
        </div>

        <!-- Tags -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Skills & Tags</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
              <i class="fa-solid fa-tags text-gray-400 text-sm"></i>
            </div>
            <input type="text" name="tags" value="{{$listing->tags}}"
              class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all">
          </div>
          @error('tags')
          <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
          @enderror
        </div>

        <!-- Logo -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Update Logo</label>
          <div class="flex items-center gap-4 mb-3">
            <img
              class="w-14 h-14 rounded-xl object-contain border border-gray-100 bg-gray-50 p-1"
              src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-picture.png')}}"
              alt="Current logo"
            />
            <div>
              <p class="text-sm font-medium text-gray-700">Current logo</p>
              <p class="text-xs text-gray-400">Upload a new file to replace it</p>
            </div>
          </div>
          <input type="file" name="logo" class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-brand-red hover:file:bg-red-100 cursor-pointer">
          @error('logo')
          <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
          @enderror
        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Job Description</label>
          <textarea name="description" rows="8"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium bg-gray-50 focus:bg-white transition-all resize-none">{{$listing->description}}</textarea>
          @error('description')
          <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
          @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-2">
          <button type="submit" class="btn-green text-white font-bold px-8 py-3.5 rounded-xl flex items-center space-x-2">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Save Changes</span>
          </button>
          <a href="/listings/manage" class="text-gray-500 hover:text-gray-800 text-sm font-medium transition-colors">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
