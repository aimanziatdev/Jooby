<aside class="hidden lg:block w-60 flex-shrink-0">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-lg overflow-hidden sticky top-20 hidden lg:block">

    <!-- User info -->
    <div class="bg-gradient-to-r from-brand-red to-red-700 px-5 py-4 flex items-center space-x-3">
      <div class="w-9 h-9 rounded-full bg-brand-red flex items-center justify-center flex-shrink-0">
        @if(auth()->user()->avatar)
          <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-9 h-9 rounded-full object-cover">
        @else
          <i class="fa-solid fa-user text-white text-sm"></i>
        @endif
      </div>
      <div class="min-w-0">
        <p class="text-white font-bold text-sm truncate">{{ auth()->user()->name }}</p>
        <p class="text-gray-400 text-xs font-medium">
          @if(auth()->user()->isCompany()) Company @else Person @endif
        </p>
      </div>
    </div>

    <!-- Nav Links -->
    <nav class="p-4 space-y-2">

      <a href="/" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
        <i class="fa-solid fa-house w-5 text-center"></i>
        <span>Browse</span>
      </a>

      <a href="/listings/manage"
        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
          {{ request()->is('listings/manage') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <i class="fa-solid fa-grid-2 w-5 text-center"></i>
        <span>Dashboard</span>
      </a>

      <a href="/listings/create"
        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
          {{ request()->is('listings/create') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <i class="fa-solid fa-plus w-5 text-center"></i>
        @if(auth()->user()->isCompany())
          <span>Post New Job</span>
        @else
          <span>Post Skill / Hobby</span>
        @endif
      </a>

      <div class="pt-3 pb-2 border-t border-gray-200 dark:border-gray-700">
        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4">Activity</p>
      </div>

      @if(auth()->user()->isPerson())
      <a href="/my-applications"
        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
          {{ request()->is('my-applications') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <i class="fa-solid fa-file-lines w-5 text-center"></i>
        <span>My Applications</span>
      </a>

      <a href="/my-offers"
        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
          {{ request()->is('my-offers') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <i class="fa-solid fa-envelope-open-text w-5 text-center"></i>
        <span>Received Offers</span>
        @php $pendingOffers = auth()->user()->offersReceived()->where('status','pending')->count(); @endphp
        @if($pendingOffers > 0)
          <span class="ml-auto bg-brand-red text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingOffers }}</span>
        @endif
      </a>
      @endif

      @if(auth()->user()->isCompany())
      <a href="/sent-offers"
        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
          {{ request()->is('sent-offers') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <i class="fa-solid fa-paper-plane w-5 text-center"></i>
        <span>Sent Offers</span>
        @php $pendingSent = auth()->user()->offersSent()->where('status','pending')->count(); @endphp
        @if($pendingSent > 0)
          <span class="ml-auto bg-yellow-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingSent }}</span>
        @endif
      </a>
      @endif

    </nav>
  </div>
</aside>

<!-- Mobile Sidebar Toggle -->
<button @click="sidebarOpen = !sidebarOpen" class="lg:hidden fixed bottom-32 right-4 z-45 w-14 h-14 bg-brand-red text-white rounded-full flex items-center justify-center shadow-xl hover:shadow-2xl transition-all active:scale-95" title="Menu">
  <i class="fa-solid fa-bars text-lg"></i>
</button>

<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="lg:hidden fixed inset-0 bg-black/50 z-40 transition-opacity" x-transition></div>

<!-- Mobile Sidebar -->
<aside x-show="sidebarOpen" class="lg:hidden fixed left-0 top-0 h-screen w-72 bg-white dark:bg-gray-900 z-50 shadow-2xl overflow-y-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
  <div class="border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10">
    <!-- User info -->
    <div class="bg-brand-red px-5 py-4 flex items-center space-x-3">
      <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
        @if(auth()->user()->avatar)
          <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-9 h-9 rounded-full object-cover">
        @else
          <i class="fa-solid fa-user text-white text-sm"></i>
        @endif
      </div>
      <div class="min-w-0">
        <p class="text-white font-bold text-sm truncate">{{ auth()->user()->name }}</p>
        <p class="text-gray-400 text-xs font-medium">
          @if(auth()->user()->isCompany()) Company @else Person @endif
        </p>
      </div>
      <button @click="sidebarOpen = false" class="ml-auto text-gray-400 hover:text-white">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
    </div>
  </div>

  <!-- Nav Links -->
  <nav class="p-4 space-y-2">

    <a href="/" @click="sidebarOpen = false" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
      <i class="fa-solid fa-house w-5 text-center"></i>
      <span>Browse</span>
    </a>

    <a href="/listings/manage" @click="sidebarOpen = false"
      class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
        {{ request()->is('listings/manage') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
      <i class="fa-solid fa-grid-2 w-5 text-center"></i>
      <span>Dashboard</span>
    </a>

    <a href="/listings/create" @click="sidebarOpen = false"
      class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
        {{ request()->is('listings/create') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
      <i class="fa-solid fa-plus w-5 text-center"></i>
      @if(auth()->user()->isCompany())
        <span>Post New Job</span>
      @else
        <span>Post Skill / Hobby</span>
      @endif
    </a>

    <div class="pt-3 pb-2 border-t border-gray-200 dark:border-gray-700 mt-3">
      <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4">Activity</p>
    </div>

    @if(auth()->user()->isPerson())
    <a href="/my-applications" @click="sidebarOpen = false"
      class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
        {{ request()->is('my-applications') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
      <i class="fa-solid fa-file-lines w-5 text-center"></i>
      <span>My Applications</span>
    </a>

    <a href="/my-offers" @click="sidebarOpen = false"
      class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
        {{ request()->is('my-offers') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
      <i class="fa-solid fa-envelope-open-text w-5 text-center"></i>
      <span>Received Offers</span>
      @php $pendingOffers = auth()->user()->offersReceived()->where('status','pending')->count(); @endphp
      @if($pendingOffers > 0)
        <span class="ml-auto bg-brand-red text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingOffers }}</span>
      @endif
    </a>
    @endif

    @if(auth()->user()->isCompany())
    <a href="/sent-offers" @click="sidebarOpen = false"
      class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
        {{ request()->is('sent-offers') ? 'bg-brand-red text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
      <i class="fa-solid fa-paper-plane w-5 text-center"></i>
      <span>Sent Offers</span>
      @php $pendingSent = auth()->user()->offersSent()->where('status','pending')->count(); @endphp
      @if($pendingSent > 0)
        <span class="ml-auto bg-yellow-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingSent }}</span>
      @endif
    </a>
    @endif

  </nav>
</aside>
