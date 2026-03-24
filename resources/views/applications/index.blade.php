@extends('Layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex gap-6 items-start">

  @include('partials._sidebar')

  <div class="flex-1 min-w-0">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-2xl font-black text-gray-900 dark:text-white">My Applications</h1>
      <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Track the status of your job applications</p>
    </div>
    <a href="/" class="btn-primary text-white font-bold px-5 py-2.5 rounded-xl text-sm flex items-center space-x-2">
      <i class="fa-solid fa-magnifying-glass"></i>
      <span>Browse Jobs</span>
    </a>
  </div>

  <!-- Stats Row -->
  <div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $applications->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Total</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-brand-green">{{ $applications->where('status', 'accepted')->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Accepted</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-yellow-500">{{ $applications->where('status', 'pending')->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Pending</div>
    </div>
  </div>

  <!-- Applications List -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

    @unless($applications->isEmpty())

      <!-- Table Header (desktop) -->
      <div class="hidden md:block px-6 py-4 border-b border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
        <div class="grid grid-cols-12 gap-4 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
          <div class="col-span-5">Position</div>
          <div class="col-span-3">Status</div>
          <div class="col-span-2">Applied</div>
          <div class="col-span-2 text-right">Actions</div>
        </div>
      </div>

      @foreach($applications as $application)
        <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 last:border-0 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors group"
             x-data="{ expanded: false }">

          <div class="grid grid-cols-12 gap-4 items-center">

            <!-- Position Info -->
            <div class="col-span-12 md:col-span-5 flex items-center space-x-3">
              <div class="w-10 h-10 rounded-xl bg-brand-black flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-briefcase text-brand-red text-sm"></i>
              </div>
              <div class="min-w-0">
                <a href="/listings/{{ $application->listing->id }}"
                   class="text-sm font-bold text-gray-900 dark:text-white hover:text-brand-red transition-colors block truncate">
                  {{ $application->listing->title }}
                </a>
                <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">{{ $application->listing->company }}</span>
              </div>
            </div>

            <!-- Status Badge -->
            <div class="col-span-6 md:col-span-3">
              @if($application->status === 'accepted')
                <span class="inline-flex items-center text-xs font-bold text-brand-green bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 px-3 py-1.5 rounded-full">
                  <i class="fa-solid fa-circle-check mr-1.5 text-xs"></i>
                  Accepted
                </span>
                <div class="mt-2 space-x-2">
                  <a href="mailto:{{ $application->listing->email }}" class="inline-flex items-center gap-1 text-xs font-semibold text-white bg-brand-red px-2 py-1.5 rounded-lg">Email</a>
                  @if($application->listing->user && $application->listing->user->phone)
                    <a href="tel:{{ $application->listing->user->phone }}" class="inline-flex items-center gap-1 text-xs font-semibold text-white bg-brand-green px-2 py-1.5 rounded-lg">Phone</a>
                  @endif
                </div>
              @elseif($application->status === 'rejected')
                <span class="inline-flex items-center text-xs font-bold text-brand-red bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 px-3 py-1.5 rounded-full">
                  <i class="fa-solid fa-circle-xmark mr-1.5 text-xs"></i>
                  Rejected
                </span>
              @else
                <span class="inline-flex items-center text-xs font-bold text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800/30 px-3 py-1.5 rounded-full">
                  <i class="fa-solid fa-clock mr-1.5 text-xs"></i>
                  Pending
                </span>
              @endif
            </div>

            <!-- Date -->
            <div class="col-span-6 md:col-span-2">
              <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">
                {{ $application->created_at->format('M d, Y') }}
              </span>
            </div>

            <!-- Expand message -->
            <div class="col-span-12 md:col-span-2 md:text-right">
              @if($application->message)
                <button
                  @click="expanded = !expanded"
                  class="inline-flex items-center space-x-1 text-xs font-semibold text-gray-500 dark:text-gray-400 hover:text-brand-red dark:hover:text-brand-red bg-gray-100 dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-1.5 rounded-lg transition-all">
                  <i class="fa-solid fa-message text-xs"></i>
                  <span x-text="expanded ? 'Hide' : 'Message'"></span>
                </button>
              @endif
            </div>
          </div>

          <!-- Expandable Message -->
          @if($application->message)
            <div x-show="expanded" x-collapse class="mt-4">
              <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Your Message</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $application->message }}</p>
              </div>
            </div>
          @endif
        </div>
      @endforeach

    @else

      <div class="text-center py-20">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid fa-file-circle-xmark text-gray-300 dark:text-gray-600 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No applications yet</h3>
        <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Start applying to jobs and track your progress here</p>
        <a href="/" class="btn-primary text-white font-bold px-6 py-3 rounded-xl text-sm inline-flex items-center space-x-2">
          <i class="fa-solid fa-magnifying-glass"></i>
          <span>Find Jobs</span>
        </a>
      </div>

    @endunless
  </div>

  </div>

  </div>

</div>

@endsection
