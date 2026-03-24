@extends('Layout')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

  <!-- Back Button -->
  <a href="/listings/manage" class="inline-flex items-center space-x-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white text-sm font-medium mb-8 group transition-colors">
    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
    <span>Back to Dashboard</span>
  </a>

  <!-- Page Header -->
  <div class="bg-brand-black rounded-2xl px-8 py-7 mb-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-red opacity-5 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <div class="w-1.5 h-1.5 bg-brand-green rounded-full"></div>
          <span class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Applicants</span>
        </div>
        <h1 class="text-2xl font-black text-white">{{ $listing->title }}</h1>
        <p class="text-gray-400 text-sm mt-1">{{ $listing->company }} &middot; {{ $listing->location }}</p>
      </div>
      <div class="flex-shrink-0">
        <div class="bg-white/10 border border-white/10 rounded-xl px-5 py-3 text-center">
          <div class="text-2xl font-black text-white">{{ $applications->count() }}</div>
          <div class="text-xs text-gray-400 font-medium">Total Applicants</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Row -->
  <div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-yellow-500">{{ $applications->where('status', 'pending')->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Pending</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-brand-green">{{ $applications->where('status', 'accepted')->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Accepted</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-brand-red">{{ $applications->where('status', 'rejected')->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Rejected</div>
    </div>
  </div>

  <!-- Applicants List -->
  @unless($applications->isEmpty())

    <div class="space-y-4">
      @foreach($applications as $application)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden card-hover"
             x-data="{ expanded: false }">

          <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">

              <!-- Avatar -->
              <div class="flex-shrink-0">
                @if($application->user->avatar)
                  <img
                    src="{{ asset('storage/' . $application->user->avatar) }}"
                    alt="{{ $application->user->name }}"
                    class="w-14 h-14 rounded-2xl object-cover border-2 border-gray-100 dark:border-gray-600"
                  />
                @else
                  <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center">
                    <i class="fa-solid fa-user text-gray-400 dark:text-gray-500 text-xl"></i>
                  </div>
                @endif
              </div>

              <!-- Info -->
              <div class="flex-1 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                  <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-white">{{ $application->user->name }}</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 font-medium">{{ $application->user->email }}</p>
                  </div>

                  <!-- Status Badge -->
                  @if($application->status === 'accepted')
                    <span class="inline-flex items-center text-xs font-bold text-brand-green bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 px-3 py-1.5 rounded-full self-start">
                      <i class="fa-solid fa-circle-check mr-1.5 text-xs"></i>
                      Accepted
                    </span>
                  @elseif($application->status === 'rejected')
                    <span class="inline-flex items-center text-xs font-bold text-brand-red bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 px-3 py-1.5 rounded-full self-start">
                      <i class="fa-solid fa-circle-xmark mr-1.5 text-xs"></i>
                      Rejected
                    </span>
                  @else
                    <span class="inline-flex items-center text-xs font-bold text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800/30 px-3 py-1.5 rounded-full self-start">
                      <i class="fa-solid fa-clock mr-1.5 text-xs"></i>
                      Pending Review
                    </span>
                  @endif
                </div>

                <!-- Bio -->
                @if($application->user->bio)
                  <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-3 line-clamp-2">{{ $application->user->bio }}</p>
                @endif

                <!-- Links Row -->
                <div class="flex flex-wrap items-center gap-2 mb-3">
                  @if($application->user->linkedin)
                    <a href="{{ $application->user->linkedin }}" target="_blank"
                       class="inline-flex items-center space-x-1.5 text-xs font-semibold text-blue-500 dark:text-blue-400 hover:text-blue-600 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 border border-blue-100 dark:border-blue-800/30 px-2.5 py-1 rounded-lg transition-all">
                      <i class="fa-brands fa-linkedin text-xs"></i>
                      <span>LinkedIn</span>
                    </a>
                  @endif
                  @if($application->user->portfolio)
                    <a href="{{ $application->user->portfolio }}" target="_blank"
                       class="inline-flex items-center space-x-1.5 text-xs font-semibold text-purple-500 dark:text-purple-400 hover:text-purple-600 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 border border-purple-100 dark:border-purple-800/30 px-2.5 py-1 rounded-lg transition-all">
                      <i class="fa-solid fa-globe text-xs"></i>
                      <span>Portfolio</span>
                    </a>
                  @endif
                  <span class="text-xs text-gray-400 dark:text-gray-500 font-medium ml-1">
                    Applied {{ $application->created_at->diffForHumans() }}
                  </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-2">
                  <!-- View Profile -->
                  <a href="/profile/{{ $application->user->id }}"
                     class="inline-flex items-center space-x-1.5 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-black dark:hover:text-white bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-3 py-2 rounded-lg transition-all">
                    <i class="fa-solid fa-user text-xs"></i>
                    <span>View Profile</span>
                  </a>

                  <!-- Show/Hide Message -->
                  @if($application->message)
                    <button
                      @click="expanded = !expanded"
                      class="inline-flex items-center space-x-1.5 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-red bg-gray-100 dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-2 rounded-lg transition-all">
                      <i class="fa-solid fa-message text-xs"></i>
                      <span x-text="expanded ? 'Hide Message' : 'View Message'"></span>
                    </button>
                  @endif

                  @if($application->status !== 'accepted')
                    <!-- Accept -->
                    <form method="POST" action="/applications/{{ $application->id }}/status" class="inline">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="accepted">
                      <button type="submit"
                              class="btn-green text-white font-bold px-3 py-2 rounded-lg text-xs flex items-center space-x-1.5">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>Accept</span>
                      </button>
                    </form>
                  @endif

                  @if($application->status !== 'rejected')
                    <!-- Reject -->
                    <form method="POST" action="/applications/{{ $application->id }}/status"
                          class="inline"
                          onsubmit="return confirm('Are you sure you want to reject this application?')">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="rejected">
                      <button type="submit"
                              class="inline-flex items-center space-x-1.5 text-xs font-bold text-brand-red hover:text-white bg-red-50 dark:bg-red-900/20 hover:bg-brand-red border border-red-100 dark:border-red-800/30 hover:border-brand-red px-3 py-2 rounded-lg transition-all">
                        <i class="fa-solid fa-xmark text-xs"></i>
                        <span>Reject</span>
                      </button>
                    </form>
                  @endif
                </div>
              </div>
            </div>

            <!-- Expandable Message -->
            @if($application->message)
              <div x-show="expanded" x-collapse class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Cover Letter / Message</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $application->message }}</p>
              </div>
            @endif
          </div>
        </div>
      @endforeach
    </div>

  @else

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
      <div class="text-center py-20">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid fa-users text-gray-300 dark:text-gray-600 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No applicants yet</h3>
        <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Share your listing to start receiving applications</p>
        <a href="/listings/{{ $listing->id }}" class="inline-flex items-center space-x-2 text-sm font-semibold text-brand-red hover:text-brand-darkred transition-colors">
          <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
          <span>View Listing</span>
        </a>
      </div>
    </div>

  @endunless

</div>

@endsection
