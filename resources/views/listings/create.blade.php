@extends('Layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex gap-6 items-start">

  @include('partials._sidebar')

  <div class="flex-1 min-w-0 max-w-2xl">

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
      <!-- Header -->
      <div class="bg-brand-black px-8 py-6">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 {{ auth()->user()->isCompany() ? 'bg-brand-red' : 'bg-brand-green' }} rounded-xl flex items-center justify-center">
            <i class="fa-solid {{ auth()->user()->isCompany() ? 'fa-briefcase' : 'fa-star' }} text-white"></i>
          </div>
          <div>
            @if(auth()->user()->isCompany())
              <h2 class="text-xl font-black text-white">Post a Job Offer</h2>
              <p class="text-gray-400 text-sm">Reach thousands of qualified candidates</p>
            @else
              <h2 class="text-xl font-black text-white">Post a Skill / Hobby</h2>
              <p class="text-gray-400 text-sm">Get discovered by companies looking for your talent</p>
            @endif
          </div>
        </div>
      </div>

      <div class="p-8">
        @if(session('success'))
        <div class="flex items-center space-x-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/30 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6">
          <i class="fa-solid fa-circle-check text-brand-green"></i>
          <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
        @endif

        <form method="POST" action="/listings" enctype="multipart/form-data" class="space-y-6">
          @csrf
          <!-- Auto-set type based on user type -->
          <input type="hidden" name="type" value="{{ auth()->user()->isCompany() ? 'job' : 'hobby' }}">

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                {{ auth()->user()->isCompany() ? 'Company Name' : 'Your Name / Alias' }}
                <span class="text-brand-red">*</span>
              </label>
              <input type="text" name="company" value="{{ old('company', auth()->user()->isCompany() ? auth()->user()->company_name : auth()->user()->name) }}"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                placeholder="{{ auth()->user()->isCompany() ? 'e.g. Google, TechCorp...' : 'e.g. Your name or username' }}">
              @error('company')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
              @enderror
            </div>

            <!-- Title -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                {{ auth()->user()->isCompany() ? 'Job Title' : 'Skill / Hobby Title' }}
                <span class="text-brand-red">*</span>
              </label>
              <input type="text" name="title" value="{{ old('title') }}"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                placeholder="{{ auth()->user()->isCompany() ? 'e.g. Senior Laravel Developer' : 'e.g. Graphic Design, Guitar, Photography' }}">
              @error('title')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
              @enderror
            </div>

            <!-- Location -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Location <span class="text-brand-red">*</span></label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                  <i class="fa-solid fa-location-dot text-gray-400 text-sm"></i>
                </div>
                <input type="text" name="location" value="{{ old('location') }}"
                  class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                  placeholder="Remote, Casablanca, etc">
              </div>
              @error('location')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
              @enderror
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Contact Email <span class="text-brand-red">*</span></label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                  <i class="fa-solid fa-envelope text-gray-400 text-sm"></i>
                </div>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                  class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                  placeholder="contact@example.com">
              </div>
              @error('email')
              <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Salary Range -->
          @if(auth()->user()->isCompany())
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              Salary Range <span class="text-gray-400 font-normal text-xs">(optional — indicative, not exact)</span>
            </label>
            <div class="flex items-center gap-3">
              <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 text-sm font-medium pointer-events-none">From</span>
                <input type="number" name="salary_min" value="{{ old('salary_min') }}" min="0"
                  class="w-full pl-14 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                  placeholder="5000">
              </div>
              <span class="text-gray-400 font-bold flex-shrink-0">–</span>
              <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 text-sm font-medium pointer-events-none">To</span>
                <input type="number" name="salary_max" value="{{ old('salary_max') }}" min="0"
                  class="w-full pl-8 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                  placeholder="12000">
              </div>
              <span class="text-gray-400 text-sm font-medium flex-shrink-0">MAD/mo</span>
            </div>
          </div>
          @endif

          <!-- Website -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              {{ auth()->user()->isCompany() ? 'Website / Application URL' : 'Portfolio / Project URL' }}
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-globe text-gray-400 text-sm"></i>
              </div>
              <input type="url" name="website" value="{{ old('website') }}"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                placeholder="https://...">
            </div>
            @error('website')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Tags -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              {{ auth()->user()->isCompany() ? 'Required Skills & Tags' : 'Skills & Tags' }}
              <span class="text-brand-red">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-tags text-gray-400 text-sm"></i>
              </div>
              <input type="text" name="tags" value="{{ old('tags') }}"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all"
                placeholder="{{ auth()->user()->isCompany() ? 'Laravel, PHP, MySQL (comma separated)' : 'Guitar, Music, Composition (comma separated)' }}">
            </div>
            @error('tags')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Logo / Image -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              {{ auth()->user()->isCompany() ? 'Company Logo' : 'Cover Image (optional)' }}
            </label>
            <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-6 text-center hover:border-brand-red dark:hover:border-brand-red transition-colors cursor-pointer">
              <i class="fa-solid fa-cloud-arrow-up text-gray-300 dark:text-gray-600 text-3xl mb-2"></i>
              <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">
                {{ auth()->user()->isCompany() ? 'Upload your company logo' : 'Upload a cover image' }}
              </p>
              <p class="text-gray-400 dark:text-gray-500 text-xs mb-3">PNG, JPG up to 2MB</p>
              <input type="file" name="logo" class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-brand-red hover:file:bg-red-100 cursor-pointer">
            </div>
            @error('logo')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
              {{ auth()->user()->isCompany() ? 'Job Description' : 'About this Skill / Hobby' }}
              <span class="text-brand-red">*</span>
            </label>
            <textarea name="description" rows="8"
              class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-700 transition-all resize-none"
              placeholder="{{ auth()->user()->isCompany() ? 'Describe the role, responsibilities, requirements and benefits...' : 'Describe your skill or hobby, your experience level, what you can offer...' }}">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
            @enderror
          </div>

          <!-- Actions -->
          <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="{{ auth()->user()->isCompany() ? 'btn-primary' : 'btn-green' }} text-white font-bold px-8 py-3.5 rounded-xl flex items-center space-x-2">
              <i class="fa-solid fa-paper-plane"></i>
              <span>{{ auth()->user()->isCompany() ? 'Publish Job' : 'Publish Skill' }}</span>
            </button>
            <a href="/listings/manage" class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white text-sm font-medium transition-colors">Cancel</a>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

@endsection
