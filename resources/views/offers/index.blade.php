@extends('Layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex gap-6 items-start">

  @include('partials._sidebar')

  <div class="flex-1 min-w-0">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-2xl font-black text-gray-900 dark:text-white">My Offers</h1>
      <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Job offers sent to you by companies</p>
    </div>
    @if($offers->count() > 0)
      <div class="flex items-center gap-2 bg-brand-green/10 border border-brand-green/20 px-4 py-2 rounded-xl">
        <i class="fa-solid fa-envelope-open-text text-brand-green text-sm"></i>
        <span class="text-sm font-bold text-brand-green">{{ $offers->count() }} {{ Str::plural('offer', $offers->count()) }}</span>
      </div>
    @endif
  </div>

  <!-- Stats Row -->
  <div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $offers->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Total</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-brand-green">{{ $offers->where('status', 'accepted')->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Accepted</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
      <div class="text-2xl font-black text-yellow-500">{{ $offers->where('status', 'pending')->count() }}</div>
      <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Awaiting Reply</div>
    </div>
  </div>

  <!-- Offers List -->
  @unless($offers->isEmpty())

    <div class="space-y-4">
      @foreach($offers as $offer)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden card-hover"
             x-data="{ expanded: false }">

          <!-- Top accent stripe based on status -->
          <div class="h-1 w-full
            @if($offer->status === 'accepted') bg-brand-green
            @elseif($offer->status === 'rejected') bg-brand-red
            @else bg-yellow-400
            @endif">
          </div>

          <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">

              <!-- Company Icon / Avatar -->
              <a href="/profile/{{ $offer->sender->id }}" class="flex-shrink-0 group">
                <div class="w-12 h-12 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 bg-brand-black flex items-center justify-center">
                  @if($offer->sender->avatar)
                    <img src="{{ asset('storage/'.$offer->sender->avatar) }}" class="w-full h-full object-cover">
                  @else
                    <i class="fa-solid fa-building text-brand-red text-lg"></i>
                  @endif
                </div>
              </a>

              <!-- Content -->
              <div class="flex-1 min-w-0">

                <!-- Header Row -->
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-3">
                  <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-white">{{ $offer->subject }}</h3>
                    <a href="/profile/{{ $offer->sender->id }}"
                      class="text-sm font-semibold text-brand-red hover:underline mt-0.5 inline-flex items-center gap-1">
                      <i class="fa-solid fa-building text-xs"></i>
                      {{ $offer->sender->company_name ?? $offer->sender->name }}
                    </a>
                  </div>

                  <!-- Status Badge -->
                  @if($offer->status === 'accepted')
                    <span class="inline-flex items-center text-xs font-bold text-brand-green bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 px-3 py-1.5 rounded-full self-start flex-shrink-0">
                      <i class="fa-solid fa-circle-check mr-1.5 text-xs"></i>
                      Accepted
                    </span>
                  @elseif($offer->status === 'rejected')
                    <span class="inline-flex items-center text-xs font-bold text-brand-red bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 px-3 py-1.5 rounded-full self-start flex-shrink-0">
                      <i class="fa-solid fa-circle-xmark mr-1.5 text-xs"></i>
                      Declined
                    </span>
                  @else
                    <span class="inline-flex items-center text-xs font-bold text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800/30 px-3 py-1.5 rounded-full self-start flex-shrink-0">
                      <i class="fa-solid fa-clock mr-1.5 text-xs"></i>
                      Awaiting Reply
                    </span>
                  @endif
                </div>

                <!-- Message Preview / Expand -->
                <div class="mb-4">
                  <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed"
                     x-show="!expanded">{{ Str::limit($offer->message, 160) }}</p>
                  <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line"
                     x-show="expanded" style="display:none">{{ $offer->message }}</p>

                  @if(strlen($offer->message) > 160)
                    <button
                      @click="expanded = !expanded"
                      class="text-xs font-semibold text-brand-red hover:text-brand-darkred mt-1.5 transition-colors">
                      <span x-text="expanded ? 'Show less' : 'Read full message'"></span>
                      <i class="fa-solid fa-chevron-down text-xs ml-1 transition-transform" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                  @endif
                </div>

                <!-- Meta + Actions Row -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                  <span class="text-xs text-gray-400 dark:text-gray-500 font-medium flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar-days text-xs"></i>
                    Received {{ $offer->created_at->format('M d, Y') }} &middot; {{ $offer->created_at->diffForHumans() }}
                  </span>

                  <!-- Action Buttons -->
                  @if($offer->status === 'pending')
                    <div class="flex items-center gap-2">
                      <!-- See Company -->
                      <a href="/profile/{{ $offer->sender->id }}"
                        class="inline-flex items-center space-x-1.5 text-xs font-bold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-xl transition-all">
                        <i class="fa-solid fa-building text-xs"></i>
                        <span>See Company</span>
                      </a>
                      <!-- Accept -->
                      <form method="POST" action="/offers/{{ $offer->id }}/status" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit"
                                class="btn-green text-white font-bold px-4 py-2 rounded-xl text-xs flex items-center space-x-1.5">
                          <i class="fa-solid fa-check text-xs"></i>
                          <span>Accept Offer</span>
                        </button>
                      </form>

                      <!-- Decline -->
                      <form method="POST" action="/offers/{{ $offer->id }}/status"
                            class="inline"
                            onsubmit="return confirm('Are you sure you want to decline this offer?')">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit"
                                class="inline-flex items-center space-x-1.5 text-xs font-bold text-brand-red hover:text-white bg-red-50 dark:bg-red-900/20 hover:bg-brand-red border border-red-100 dark:border-red-800/30 hover:border-brand-red px-4 py-2 rounded-xl transition-all">
                          <i class="fa-solid fa-xmark text-xs"></i>
                          <span>Decline</span>
                        </button>
                      </form>
                    </div>
                  @elseif($offer->status === 'accepted')
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-brand-green">
                      <i class="fa-solid fa-circle-check"></i>
                      <span>You accepted this offer</span>
                    </div>
                  @else
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 dark:text-gray-500">
                      <i class="fa-solid fa-circle-xmark"></i>
                      <span>Offer declined</span>
                    </div>
                  @endif
                </div>

              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

  @else

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
      <div class="text-center py-20">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid fa-envelope-open text-gray-300 dark:text-gray-600 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No offers yet</h3>
        <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Complete your profile so companies can find and reach out to you</p>
        <a href="/profile/edit" class="btn-primary text-white font-bold px-6 py-3 rounded-xl text-sm inline-flex items-center space-x-2">
          <i class="fa-solid fa-pen"></i>
          <span>Update Profile</span>
        </a>
      </div>
    </div>

  @endunless

  </div>

</div>

@endsection
