@extends('Layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex gap-6 items-start">

  @include('partials._sidebar')

  <div class="flex-1 min-w-0">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        @if(auth()->user()->isCompany())
          <h1 class="text-2xl font-black text-gray-900 dark:text-white">My Job Listings</h1>
          <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage and track your posted job offers</p>
        @else
          <h1 class="text-2xl font-black text-gray-900 dark:text-white">My Skills & Hobbies</h1>
          <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage your posted skills and hobby listings</p>
        @endif
      </div>
      <a href="/listings/create" class="btn-primary text-white font-bold px-5 py-2.5 rounded-xl text-sm flex items-center space-x-2">
        <i class="fa-solid fa-plus"></i>
        @if(auth()->user()->isCompany())
          <span>Post New Job</span>
        @else
          <span>Post New Skill</span>
        @endif
      </a>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-3 gap-4 mb-6">
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
        <div class="text-2xl font-black text-gray-900 dark:text-white">{{$listings->count()}}</div>
        <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Total</div>
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
        <div class="text-2xl font-black text-brand-green">{{$listings->count()}}</div>
        <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Active</div>
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 text-center shadow-sm">
        <div class="text-2xl font-black text-brand-red">0</div>
        <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-1">Expired</div>
      </div>
    </div>

    <!-- Listings Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
      @unless($listings->isEmpty())

      <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
        <div class="grid grid-cols-12 gap-4 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
          <div class="col-span-6">{{ auth()->user()->isCompany() ? 'Job Title' : 'Skill / Hobby' }}</div>
          <div class="col-span-3 hidden sm:block">Status</div>
          <div class="col-span-3 text-right">Actions</div>
        </div>
      </div>

      @foreach($listings as $listing)
      <div class="px-6 py-5 border-b border-gray-50 dark:border-gray-700/50 last:border-0 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors group">
        <div class="grid grid-cols-12 gap-4 items-center">
          <div class="col-span-6 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 flex-shrink-0">
              <img class="w-full h-full object-contain p-1"
                src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-picture.png')}}"
                alt=""/>
            </div>
            <div class="min-w-0">
              <a href="/listings/{{$listing->id}}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-brand-red transition-colors block truncate">
                {{$listing->title}}
              </a>
              <div class="flex items-center gap-2 mt-0.5">
                <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">{{$listing->company}}</span>
                @if($listing->type === 'hobby')
                  <span class="text-xs font-bold text-brand-green bg-green-50 dark:bg-green-900/20 px-1.5 py-0.5 rounded-full">Hobby</span>
                @else
                  <span class="text-xs font-bold text-brand-red bg-red-50 dark:bg-red-900/20 px-1.5 py-0.5 rounded-full">Job</span>
                @endif
              </div>
            </div>
          </div>

          <div class="col-span-3 hidden sm:block">
            <span class="inline-flex items-center text-xs font-bold text-brand-green bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 px-2.5 py-1 rounded-full">
              <i class="fa-solid fa-circle text-xs mr-1.5" style="font-size:5px"></i>
              Active
            </span>
          </div>

          <div class="col-span-6 sm:col-span-3 flex items-center justify-end gap-2">
            <a href="/listings/{{$listing->id}}/edit"
              class="inline-flex items-center space-x-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-black dark:hover:text-white bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-3 py-1.5 rounded-lg transition-all">
              <i class="fa-solid fa-pen text-xs"></i>
              <span>Edit</span>
            </a>
            <form method="POST" action="/listings/{{$listing->id}}" onsubmit="return confirm('Delete this listing?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="inline-flex items-center space-x-1 text-xs font-semibold text-brand-red hover:text-white bg-red-50 dark:bg-red-900/20 hover:bg-brand-red px-3 py-1.5 rounded-lg transition-all">
                <i class="fa-solid fa-trash text-xs"></i>
                <span>Delete</span>
              </button>
            </form>
          </div>
        </div>
      </div>
      @endforeach

      @else
      <div class="text-center py-20">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid {{ auth()->user()->isCompany() ? 'fa-briefcase' : 'fa-star' }} text-gray-300 dark:text-gray-600 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Nothing posted yet</h3>
        <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">
          {{ auth()->user()->isCompany() ? 'Post your first job offer and start finding candidates' : 'Showcase your first skill or hobby to get discovered' }}
        </p>
        <a href="/listings/create" class="btn-primary text-white font-bold px-6 py-3 rounded-xl text-sm inline-flex items-center space-x-2">
          <i class="fa-solid fa-plus"></i>
          <span>{{ auth()->user()->isCompany() ? 'Post Your First Job' : 'Post Your First Skill' }}</span>
        </a>
      </div>
      @endunless
    </div>

  </div>
</div>

@endsection
