@props(['listing'])

<div class="card-hover bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:border-red-100 dark:hover:border-gray-600 cursor-pointer group">
  <div class="flex items-start space-x-4">
    <!-- Logo -->
    <div class="flex-shrink-0">
      <div class="w-14 h-14 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 flex items-center justify-center">
        <img
          class="w-full h-full object-contain p-1"
          src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-picture.png')}}"
          alt="{{$listing->company}}"
        />
      </div>
    </div>

    <!-- Info -->
    <div class="flex-1 min-w-0">
      <div class="flex items-start justify-between gap-2">
        <div class="min-w-0">
          <!-- Type Badge -->
          <div class="mb-1.5">
            @if($listing->type === 'hobby')
              <span class="inline-flex items-center text-xs font-bold text-brand-green bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800/40 px-2 py-0.5 rounded-full">
                <i class="fa-solid fa-star mr-1 text-xs"></i> Hobby / Skill
              </span>
            @else
              <span class="inline-flex items-center text-xs font-bold text-brand-red bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/40 px-2 py-0.5 rounded-full">
                <i class="fa-solid fa-briefcase mr-1 text-xs"></i> Job Offer
              </span>
            @endif
          </div>
          <h3 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-brand-red transition-colors truncate">
            <a href="/listings/{{$listing->id}}">{{$listing->title}}</a>
          </h3>
          <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mt-0.5">{{$listing->company}}</p>
        </div>
        <a href="/listings/{{$listing->id}}" class="flex-shrink-0 btn-primary text-white text-xs font-semibold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all">
          {{ $listing->type === 'hobby' ? 'View' : 'Apply' }}
        </a>
      </div>

      <!-- Tags -->
      <div class="mt-3">
        <x-listing-tags :tagsCsv="$listing->tags" />
      </div>

      <!-- Location & Status & Poster -->
      <div class="flex items-center gap-4 mt-3">
        <span class="flex items-center text-gray-400 dark:text-gray-500 text-xs font-medium">
          <i class="fa-solid fa-location-dot mr-1.5 text-brand-red"></i>
          {{$listing->location}}
        </span>
        <span class="flex items-center text-brand-green text-xs font-semibold bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded-full">
          <i class="fa-solid fa-circle text-xs mr-1.5" style="font-size:5px"></i>
          Active
        </span>
        @if($listing->user)
          <a href="/profile/{{$listing->user->id}}" class="text-xs text-gray-400 dark:text-gray-500 hover:text-brand-red transition-colors ml-auto">
            <i class="fa-solid fa-user mr-1"></i>{{$listing->user->name}}
          </a>
        @endif
      </div>
    </div>
  </div>
</div>
