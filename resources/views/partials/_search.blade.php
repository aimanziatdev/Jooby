<div id="listings" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-16 z-40 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
    <form action="/#listings" method="GET">
      @if(request('type'))
        <input type="hidden" name="type" value="{{ request('type') }}">
      @endif
      <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
          </div>
          <input type="text" name="search" value="{{ request('search') }}"
            class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-gray-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium placeholder-gray-400 focus:bg-white dark:focus:bg-gray-700 transition-all"
            placeholder="Search job title, skills, company..."/>
        </div>
        <button type="submit" class="btn-primary text-white font-semibold px-6 py-3 rounded-xl text-sm whitespace-nowrap">
          <i class="fa-solid fa-search mr-1"></i> Search
        </button>
        @if(request('search') || request('type'))
          <a href="/#listings" class="flex items-center justify-center px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-500 dark:text-gray-400 hover:text-gray-700 text-sm font-medium transition-all">
            <i class="fa-solid fa-xmark mr-1"></i> Clear
          </a>
        @endif
      </div>
    </form>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 mt-3">
      <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 mr-1">Filter:</span>
      <a href="/?{{ request('search') ? 'search='.request('search') : '' }}#listings"
        class="text-xs font-bold px-3 py-1.5 rounded-full transition-all {{ !request('type') ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
        <i class="fa-solid fa-border-all mr-1"></i> All
      </a>
      <a href="/?type=job{{ request('search') ? '&search='.request('search') : '' }}#listings"
        class="text-xs font-bold px-3 py-1.5 rounded-full transition-all {{ request('type') === 'job' ? 'bg-brand-red text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
        <i class="fa-solid fa-briefcase mr-1"></i> Jobs
      </a>
      <a href="/?type=hobby{{ request('search') ? '&search='.request('search') : '' }}#listings"
        class="text-xs font-bold px-3 py-1.5 rounded-full transition-all {{ request('type') === 'hobby' ? 'bg-brand-green text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
        <i class="fa-solid fa-star mr-1"></i> Hobbies & Skills
      </a>
    </div>
  </div>
</div>
