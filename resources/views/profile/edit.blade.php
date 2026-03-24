@extends('Layout')

@section('content')

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-12">

  <!-- Back -->
  <a href="/profile/{{ $user->id }}" class="inline-flex items-center space-x-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white text-sm font-medium mb-8 group transition-colors">
    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
    <span>Back to Profile</span>
  </a>

  <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

    <!-- Header -->
    <div class="bg-brand-black px-8 py-6">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-brand-red rounded-xl flex items-center justify-center">
          <i class="fa-solid fa-pen text-white"></i>
        </div>
        <div>
          <h2 class="text-xl font-black text-white">Edit Profile</h2>
          <p class="text-gray-400 text-sm">Update your public profile information</p>
        </div>
      </div>
    </div>

    <div class="p-8 dark:bg-gray-800">

      @if(session('success'))
        <div class="flex items-center space-x-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/40 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6">
          <i class="fa-solid fa-circle-check text-brand-green"></i>
          <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
      @endif

      <form method="POST" action="/profile" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Avatar Upload -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Profile Photo</label>

          <div class="flex items-center gap-5 mb-4">
            <!-- Current Avatar Preview -->
            @if($user->avatar)
              <img
                src="{{ asset('storage/' . $user->avatar) }}"
                alt="Current avatar"
                class="w-16 h-16 rounded-2xl object-cover border-2 border-gray-200 dark:border-gray-600"
              />
            @else
              <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-700 border-2 border-dashed border-gray-200 dark:border-gray-600 flex items-center justify-center">
                @if($user->isCompany())
                  <i class="fa-solid fa-building text-gray-300 dark:text-gray-500 text-xl"></i>
                @else
                  <i class="fa-solid fa-user text-gray-300 dark:text-gray-500 text-xl"></i>
                @endif
              </div>
            @endif

            <div>
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ $user->avatar ? 'Current photo' : 'No photo yet' }}
              </p>
              <p class="text-xs text-gray-400 dark:text-gray-500">Upload a new file to {{ $user->avatar ? 'replace it' : 'set your photo' }}</p>
            </div>
          </div>

          <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-5 text-center hover:border-brand-red transition-colors">
            <i class="fa-solid fa-cloud-arrow-up text-gray-300 dark:text-gray-600 text-2xl mb-2"></i>
            <p class="text-gray-500 dark:text-gray-400 text-xs font-medium mb-2">PNG, JPG up to 2MB</p>
            <input
              type="file"
              name="avatar"
              accept="image/*"
              class="text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 dark:file:bg-red-900/20 file:text-brand-red hover:file:bg-red-100 cursor-pointer"
            />
          </div>
          @error('avatar')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
          @enderror
        </div>

        <div class="border-t border-gray-100 dark:border-gray-700"></div>

        <!-- Name (persons) -->
        @if($user->isPerson())
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              Full Name <span class="text-brand-red">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-user text-gray-400 text-sm"></i>
              </div>
              <input
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                placeholder="Your full name"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600 transition-all"
              />
            </div>
            @error('name')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>
        @endif

        <!-- Company Name (companies) -->
        @if($user->isCompany())
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              Company Name <span class="text-brand-red">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-building text-gray-400 text-sm"></i>
              </div>
              <input
                type="text"
                name="company_name"
                value="{{ old('company_name', $user->company_name) }}"
                placeholder="Your company name"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600 transition-all"
              />
            </div>
            @error('company_name')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>
        @endif

        <!-- Bio -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bio</label>
          <textarea
            name="bio"
            rows="5"
            placeholder="{{ $user->isCompany() ? 'Tell candidates about your company, culture, and mission...' : 'Tell employers about yourself, your skills, and your goals...' }}"
            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600 transition-all resize-none"
          >{{ old('bio', $user->bio) }}</textarea>
          @error('bio')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
          @enderror
        </div>

        <!-- LinkedIn & Portfolio (persons) -->
        @if($user->isPerson())
          <!-- LinkedIn -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">LinkedIn URL</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-brands fa-linkedin text-blue-400 text-sm"></i>
              </div>
              <input
                type="url"
                name="linkedin"
                value="{{ old('linkedin', $user->linkedin) }}"
                placeholder="https://linkedin.com/in/yourprofile"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600 transition-all"
              />
            </div>
            @error('linkedin')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Portfolio -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Portfolio URL</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-globe text-purple-400 text-sm"></i>
              </div>
              <input
                type="url"
                name="portfolio"
                value="{{ old('portfolio', $user->portfolio) }}"
                placeholder="https://yourportfolio.com"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600 transition-all"
              />
            </div>
            @error('portfolio')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>
        @endif

        <!-- Phone (all users) -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number <span class="text-gray-400 font-normal text-xs">(optional)</span></label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
              <i class="fa-solid fa-phone text-brand-green text-sm"></i>
            </div>
            <input
              type="tel"
              name="phone"
              value="{{ old('phone', $user->phone) }}"
              placeholder="+212 6XX XXX XXX"
              class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-700 dark:text-white focus:bg-white dark:focus:bg-gray-600 transition-all"
            />
          </div>
          @error('phone')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
          @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-2 border-t border-gray-100 dark:border-gray-700">
          <button type="submit" class="btn-green text-white font-bold px-8 py-3.5 rounded-xl flex items-center space-x-2 mt-4">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Save Changes</span>
          </button>
          <a href="/profile/{{ $user->id }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white text-sm font-medium transition-colors mt-4">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
