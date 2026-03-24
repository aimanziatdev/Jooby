@extends('Layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex gap-6 items-start" x-data="{ offerModal: false, addProject: false }">

  @auth
    @include('partials._sidebar')
  @endauth

  <div class="flex-1 min-w-0">

  <a href="/" class="inline-flex items-center space-x-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white text-sm font-medium mb-6 group transition-colors">
    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
    <span>Back to Jobs</span>
  </a>

  <!-- Profile Card -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden mb-6">

    <!-- Header Banner -->
    <div class="bg-brand-black px-8 py-8 relative overflow-hidden">
      <div class="absolute top-0 right-0 w-72 h-72 bg-brand-red opacity-5 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
      <div class="absolute bottom-0 left-0 w-48 h-48 bg-brand-green opacity-5 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>

      <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-6">

        <!-- Avatar -->
        <div class="flex-shrink-0">
          @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
              class="w-24 h-24 rounded-2xl object-cover border-2 border-white/20"/>
          @else
            <div class="w-24 h-24 rounded-2xl bg-white/10 border-2 border-white/20 flex items-center justify-center">
              <i class="fa-solid {{ $user->isCompany() ? 'fa-building' : 'fa-user' }} text-white text-3xl"></i>
            </div>
          @endif
        </div>

        <!-- Info -->
        <div class="text-center sm:text-left flex-1 min-w-0">
          <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-2">
            <h1 class="text-2xl md:text-3xl font-black text-white truncate">
              {{ $user->isCompany() ? $user->company_name : $user->name }}
            </h1>
            @if($user->isCompany())
              <span class="inline-flex items-center self-center text-xs font-bold text-brand-green bg-green-500/10 border border-green-500/20 px-3 py-1 rounded-full">
                <i class="fa-solid fa-building mr-1.5 text-xs"></i>Company
              </span>
            @else
              <span class="inline-flex items-center self-center text-xs font-bold text-blue-400 bg-blue-500/10 border border-blue-500/20 px-3 py-1 rounded-full">
                <i class="fa-solid fa-user mr-1.5 text-xs"></i>Person
              </span>
            @endif
          </div>

          @if($user->bio)
            <p class="text-gray-300 text-sm leading-relaxed max-w-xl mt-2">{{ $user->bio }}</p>
          @else
            <p class="text-gray-500 text-sm italic mt-2">No bio provided.</p>
          @endif

          <!-- Links (persons) -->
          @if($user->isPerson())
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mt-4">
              @if($user->linkedin)
                <a href="{{ $user->linkedin }}" target="_blank"
                   class="inline-flex items-center space-x-2 text-xs font-semibold text-blue-300 hover:text-blue-200 bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/20 px-3 py-1.5 rounded-lg transition-all">
                  <i class="fa-brands fa-linkedin"></i><span>LinkedIn</span>
                </a>
              @endif
              @if($user->portfolio)
                <a href="{{ $user->portfolio }}" target="_blank"
                   class="inline-flex items-center space-x-2 text-xs font-semibold text-purple-300 hover:text-purple-200 bg-purple-500/10 hover:bg-purple-500/20 border border-purple-500/20 px-3 py-1.5 rounded-lg transition-all">
                  <i class="fa-solid fa-globe"></i><span>Portfolio</span>
                </a>
              @endif
              @if($user->phone)
                <span class="inline-flex items-center space-x-2 text-xs font-semibold text-green-300 bg-green-500/10 border border-green-500/20 px-3 py-1.5 rounded-lg">
                  <i class="fa-solid fa-phone"></i><span>{{ $user->phone }}</span>
                </span>
              @endif
            </div>
          @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2 flex-shrink-0">
          @auth
            @if(auth()->user()->isCompany() && $user->isPerson())
              @php
                $acceptedOffer = \App\Models\Offer::where('from_user_id', auth()->id())
                  ->where('to_user_id', $user->id)
                  ->where('status', 'accepted')
                  ->first();
              @endphp
              @if($acceptedOffer)
                <a href="mailto:{{ $user->email }}"
                  class="btn-green text-white font-bold px-5 py-2.5 rounded-xl text-sm flex items-center space-x-2">
                  <i class="fa-solid fa-envelope"></i><span>Email</span>
                </a>
                @if($user->phone)
                  <a href="tel:{{ $user->phone }}"
                    class="inline-flex items-center justify-center space-x-2 font-bold px-5 py-2.5 rounded-xl text-sm border border-green-500/30 text-brand-green hover:bg-green-500/10 transition-all">
                    <i class="fa-solid fa-phone"></i><span>{{ $user->phone }}</span>
                  </a>
                @endif
                <p class="text-green-400 text-xs text-center font-medium flex items-center gap-1 justify-center">
                  <i class="fa-solid fa-circle-check text-xs"></i> Offer accepted
                </p>
              @else
                <button @click="offerModal=true" class="btn-primary text-white font-bold px-5 py-2.5 rounded-xl text-sm flex items-center space-x-2">
                  <i class="fa-solid fa-paper-plane"></i><span>Send Offer</span>
                </button>
              @endif
            @endif
            @if(auth()->id() === $user->id)
              <a href="/profile/edit" class="inline-flex items-center justify-center space-x-2 text-xs font-semibold text-gray-300 hover:text-white bg-white/10 hover:bg-white/20 px-4 py-2.5 rounded-xl transition-all">
                <i class="fa-solid fa-pen"></i><span>Edit Profile</span>
              </a>
            @endif
          @endauth
        </div>

      </div>
    </div>

    <!-- Body -->
    <div class="p-8">
      <div class="flex items-center gap-2 text-xs text-gray-400 mb-8">
        <i class="fa-solid fa-calendar-days text-brand-red"></i>
        <span>Member since {{ $user->created_at->format('F Y') }}</span>
      </div>

      @if($user->isPerson())

        <!-- Projects Section -->
        <div class="mb-8">
          <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-2">
              <div class="w-1 h-6 bg-brand-red rounded-full"></div>
              Projects
            </h2>
            @if(auth()->id() === $user->id)
              <button @click="addProject=!addProject"
                class="btn-primary text-white text-xs font-bold px-4 py-2 rounded-lg flex items-center space-x-1">
                <i class="fa-solid" :class="addProject ? 'fa-xmark' : 'fa-plus'"></i>
                <span x-text="addProject ? 'Cancel' : 'Add Project'"></span>
              </button>
            @endif
          </div>

          <!-- Add Project Form -->
          @if(auth()->id() === $user->id)
          <div x-show="addProject" x-transition class="mb-6 bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600 rounded-2xl p-6">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
              <i class="fa-solid fa-folder-plus text-brand-red"></i>
              New Project
            </h3>
            <form method="POST" action="/projects" enctype="multipart/form-data" class="space-y-4">
              @csrf
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Title <span class="text-brand-red">*</span></label>
                  <input type="text" name="title" required placeholder="e.g. E-commerce App"
                    class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Project Link <span class="text-gray-400 font-normal">(optional)</span></label>
                  <input type="url" name="link" placeholder="https://github.com/..."
                    class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 dark:text-white">
                </div>
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Description <span class="text-gray-400 font-normal">(optional)</span></label>
                <textarea name="description" rows="3" placeholder="What is this project about?"
                  class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 dark:text-white resize-none"></textarea>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Tags <span class="text-gray-400 font-normal">(optional, comma separated)</span></label>
                  <input type="text" name="tags" placeholder="Laravel, Vue.js, TailwindCSS"
                    class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Project Image <span class="text-gray-400 font-normal">(optional)</span></label>
                  <input type="file" name="image" accept="image/*"
                    class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-brand-red hover:file:bg-red-100 cursor-pointer">
                </div>
              </div>
              <div class="flex gap-3 pt-1">
                <button type="submit" class="btn-green text-white font-bold px-5 py-2.5 rounded-xl text-sm flex items-center space-x-2">
                  <i class="fa-solid fa-plus"></i><span>Add Project</span>
                </button>
                <button type="button" @click="addProject=false" class="text-gray-500 text-sm font-medium hover:text-gray-800 dark:hover:text-white transition-colors">Cancel</button>
              </div>
            </form>
          </div>
          @endif

          <!-- Projects Grid -->
          @if($user->projects && $user->projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              @foreach($user->projects as $project)
                <div class="card-hover bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600 rounded-2xl overflow-hidden">
                  @if($project->image)
                    <div class="h-36 overflow-hidden">
                      <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                    </div>
                  @endif
                  <div class="p-5">
                    <div class="flex items-start justify-between gap-2 mb-2">
                      <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $project->title }}</h3>
                      <div class="flex items-center gap-2 flex-shrink-0">
                        @if($project->link)
                          <a href="{{ $project->link }}" target="_blank" class="text-brand-red hover:text-brand-darkred transition-colors" title="View project">
                            <i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>
                          </a>
                        @endif
                        @if(auth()->id() === $user->id)
                          <form method="POST" action="/projects/{{ $project->id }}" onsubmit="return confirm('Delete this project?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors" title="Delete">
                              <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                          </form>
                        @endif
                      </div>
                    </div>
                    @if($project->description)
                      <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-3">{{ $project->description }}</p>
                    @endif
                    @if($project->tags)
                      <div class="flex flex-wrap gap-1.5">
                        @foreach(explode(',', $project->tags) as $tag)
                          <span class="text-xs font-semibold text-brand-red bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 px-2 py-0.5 rounded-full">{{ trim($tag) }}</span>
                        @endforeach
                      </div>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="bg-gray-50 dark:bg-gray-700/30 border border-dashed border-gray-200 dark:border-gray-600 rounded-2xl p-10 text-center">
              <i class="fa-solid fa-folder-open text-gray-300 dark:text-gray-600 text-3xl mb-3 block"></i>
              <p class="text-gray-400 text-sm">No projects shared yet.</p>
              @if(auth()->id() === $user->id)
                <button @click="addProject=true" class="mt-3 text-brand-red text-sm font-semibold hover:underline">Add your first project</button>
              @endif
            </div>
          @endif
        </div>

        <!-- Posted Listings -->
        @if($user->listings && $user->listings->count() > 0)
          <div class="border-t border-gray-100 dark:border-gray-700 pt-8">
            <h2 class="text-xl font-black text-gray-900 dark:text-white mb-5 flex items-center gap-2">
              <div class="w-1 h-6 bg-brand-green rounded-full"></div>
              Posted Listings
            </h2>
            <div class="space-y-3">
              @foreach($user->listings as $listing)
                <a href="/listings/{{ $listing->id }}" class="card-hover flex items-center justify-between bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600 rounded-xl px-5 py-4 group">
                  <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-brand-red transition-colors truncate">{{ $listing->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $listing->company }} · {{ $listing->location }}</p>
                  </div>
                  <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-brand-red transition-colors flex-shrink-0 ml-3 text-xs"></i>
                </a>
              @endforeach
            </div>
          </div>
        @endif

      @endif
    </div>
  </div>

  </div><!-- end flex-1 -->

<!-- Send Offer Modal -->
@auth
  @if(auth()->user()->isCompany() && $user->isPerson())
    <div x-show="offerModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display:none;">
      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="offerModal=false"></div>
      <div x-show="offerModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden z-10">
        <div class="bg-brand-black px-6 py-5 flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="w-9 h-9 bg-brand-green rounded-xl flex items-center justify-center"><i class="fa-solid fa-paper-plane text-white text-sm"></i></div>
            <div><h3 class="text-lg font-black text-white">Send a Job Offer</h3><p class="text-gray-400 text-xs">To {{ $user->name }}</p></div>
          </div>
          <button @click="offerModal=false" class="text-gray-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>
        <div class="p-6">
          <form method="POST" action="/offer/{{ $user->id }}" class="space-y-5">
            @csrf
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Subject <span class="text-brand-red">*</span></label>
              <input type="text" name="subject" required placeholder="e.g. Frontend Developer Opportunity"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-gray-50 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Message <span class="text-brand-red">*</span></label>
              <textarea name="message" rows="5" required placeholder="Introduce yourself and the opportunity..."
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-gray-50 dark:bg-gray-700 dark:text-white resize-none"></textarea>
            </div>
            <div class="flex items-center gap-3 pt-1">
              <button type="submit" class="btn-green text-white font-bold px-6 py-3 rounded-xl flex items-center space-x-2 text-sm">
                <i class="fa-solid fa-paper-plane"></i><span>Send Offer</span>
              </button>
              <button type="button" @click="offerModal=false" class="text-gray-500 hover:text-gray-800 dark:hover:text-white text-sm font-medium transition-colors">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
@endauth

</div><!-- end outer flex -->

@endsection
