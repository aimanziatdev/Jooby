@extends('Layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex gap-6 items-start">

  @include('partials._sidebar')

  <div class="flex-1 min-w-0">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-black text-gray-900 dark:text-white">Sent Offers</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Track the offers you sent and their responses</p>
      </div>
      <a href="/" class="btn-primary text-white font-bold px-5 py-2.5 rounded-xl text-sm flex items-center space-x-2">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span>Find Talent</span>
      </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4 mb-6">
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
        <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $offers->count() }}</div>
        <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Total Sent</div>
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
        <div class="text-2xl font-black text-brand-green">{{ $offers->where('status','accepted')->count() }}</div>
        <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Accepted</div>
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
        <div class="text-2xl font-black text-yellow-500">{{ $offers->where('status','pending')->count() }}</div>
        <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Awaiting Reply</div>
      </div>
    </div>

    <!-- Offers List -->
    @unless($offers->isEmpty())
      <div class="space-y-4">
        @foreach($offers as $offer)
          <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

            <!-- Status stripe -->
            <div class="h-1 w-full
              @if($offer->status === 'accepted') bg-brand-green
              @elseif($offer->status === 'rejected') bg-brand-red
              @else bg-yellow-400
              @endif">
            </div>

            <div class="p-5 flex flex-col sm:flex-row sm:items-center gap-4">

              <!-- Recipient avatar -->
              <a href="/profile/{{ $offer->receiver->id }}" class="flex-shrink-0">
                <div class="w-12 h-12 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 flex items-center justify-center">
                  @if($offer->receiver->avatar)
                    <img src="{{ asset('storage/'.$offer->receiver->avatar) }}" class="w-full h-full object-cover">
                  @else
                    <i class="fa-solid fa-user text-gray-400 text-lg"></i>
                  @endif
                </div>
              </a>

              <!-- Info -->
              <div class="flex-1 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                  <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-white">{{ $offer->subject }}</h3>
                    <a href="/profile/{{ $offer->receiver->id }}"
                      class="text-sm font-semibold text-brand-red hover:underline mt-0.5 block">
                      {{ $offer->receiver->name }}
                    </a>
                  </div>

                  <!-- Status badge -->
                  @if($offer->status === 'accepted')
                    <span class="inline-flex items-center text-xs font-bold text-brand-green bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 px-3 py-1.5 rounded-full self-start flex-shrink-0">
                      <i class="fa-solid fa-circle-check mr-1.5 text-xs"></i>Accepted
                    </span>
                  @elseif($offer->status === 'rejected')
                    <span class="inline-flex items-center text-xs font-bold text-brand-red bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 px-3 py-1.5 rounded-full self-start flex-shrink-0">
                      <i class="fa-solid fa-circle-xmark mr-1.5 text-xs"></i>Declined
                    </span>
                  @else
                    <span class="inline-flex items-center text-xs font-bold text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800/30 px-3 py-1.5 rounded-full self-start flex-shrink-0">
                      <i class="fa-solid fa-clock mr-1.5 text-xs"></i>Awaiting Reply
                    </span>
                  @endif
                </div>

                <!-- Salary + message preview -->
                <div class="mt-2 flex flex-wrap items-center gap-3">
                  @if($offer->salary_min || $offer->salary_max)
                    <span class="inline-flex items-center text-xs font-bold text-yellow-700 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 px-2.5 py-1 rounded-full">
                      <i class="fa-solid fa-money-bill-wave mr-1.5 text-xs"></i>
                      @if($offer->salary_min && $offer->salary_max)
                        {{ number_format($offer->salary_min) }} – {{ number_format($offer->salary_max) }} MAD/mo
                      @elseif($offer->salary_min)
                        From {{ number_format($offer->salary_min) }} MAD/mo
                      @else
                        Up to {{ number_format($offer->salary_max) }} MAD/mo
                      @endif
                    </span>
                  @endif
                  <span class="text-xs text-gray-400 dark:text-gray-500">
                    <i class="fa-solid fa-calendar-days mr-1"></i>
                    Sent {{ $offer->created_at->format('M d, Y') }} · {{ $offer->created_at->diffForHumans() }}
                  </span>
                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                  {{ Str::limit($offer->message, 120) }}
                </p>

                @if($offer->status === 'accepted')
                  <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <a href="mailto:{{ $offer->receiver->email }}"
                      class="btn-green text-white font-bold px-4 py-2 rounded-xl text-xs flex items-center space-x-1.5">
                      <i class="fa-solid fa-envelope text-xs"></i><span>Email</span>
                    </a>
                    @if($offer->receiver->phone)
                      <a href="tel:{{ $offer->receiver->phone }}"
                        class="inline-flex items-center space-x-1.5 text-xs font-bold text-brand-green border border-green-300 dark:border-green-700 hover:bg-green-50 dark:hover:bg-green-900/20 px-4 py-2 rounded-xl transition-all">
                        <i class="fa-solid fa-phone text-xs"></i><span>{{ $offer->receiver->phone }}</span>
                      </a>
                    @endif
                    <a href="/profile/{{ $offer->receiver->id }}"
                      class="inline-flex items-center space-x-1.5 text-xs font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-xl transition-all">
                      <i class="fa-solid fa-user text-xs"></i><span>See Profile</span>
                    </a>
                  </div>
                @endif
              </div>

            </div>
          </div>
        @endforeach
      </div>

    @else
      <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
        <div class="text-center py-20">
          <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-paper-plane text-gray-300 dark:text-gray-600 text-2xl"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">No offers sent yet</h3>
          <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Browse talent and send your first offer</p>
          <a href="/?type=hobby" class="btn-primary text-white font-bold px-6 py-3 rounded-xl text-sm inline-flex items-center space-x-2">
            <i class="fa-solid fa-star"></i>
            <span>Browse Talent</span>
          </a>
        </div>
      </div>
    @endunless

  </div>
</div>

@endsection
