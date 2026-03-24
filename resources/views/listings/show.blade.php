@extends('Layout')

@section('content')

<div x-data="{ offerModal: false }">
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

  <!-- Back Button -->
  <a href="/" class="inline-flex items-center space-x-2 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium mb-8 group transition-colors">
    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
    <span>Back to Jobs</span>
  </a>

  <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

    <!-- Header -->
    <div class="bg-brand-black p-8 relative overflow-hidden">
      <div class="absolute top-0 right-0 w-64 h-64 bg-brand-red opacity-5 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
      <div class="absolute bottom-0 left-0 w-48 h-48 bg-brand-green opacity-5 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
      <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">

        <!-- Logo -->
        <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-white/20 bg-white flex items-center justify-center flex-shrink-0">
          <img class="w-full h-full object-contain p-2"
            src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-picture.png')}}"
            alt="{{$listing->company}}"/>
        </div>

        <!-- Info -->
        <div class="text-center md:text-left flex-1 min-w-0">
          <!-- Type badge -->
          <div class="mb-2">
            @if($listing->type === 'hobby')
              <span class="inline-flex items-center text-xs font-bold text-brand-green bg-green-500/10 border border-green-500/20 px-2.5 py-1 rounded-full">
                <i class="fa-solid fa-star mr-1.5 text-xs"></i>Hobby / Skill
              </span>
            @else
              <span class="inline-flex items-center text-xs font-bold text-brand-red bg-red-500/10 border border-red-500/20 px-2.5 py-1 rounded-full">
                <i class="fa-solid fa-briefcase mr-1.5 text-xs"></i>Job Offer
              </span>
            @endif
          </div>

          <h1 class="text-2xl md:text-3xl font-black text-white mb-1">{{$listing->title}}</h1>
          <p class="text-gray-400 font-semibold text-base mb-3">{{$listing->company}}</p>

          <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
            <span class="flex items-center text-gray-300 text-sm font-medium">
              <i class="fa-solid fa-location-dot mr-2 text-brand-red"></i>{{$listing->location}}
            </span>
            <span class="flex items-center text-brand-green text-sm font-bold bg-green-500/10 border border-green-500/20 px-3 py-1 rounded-full">
              <i class="fa-solid fa-circle text-xs mr-1.5" style="font-size:6px"></i>
              {{ $listing->type === 'hobby' ? 'Active' : 'Actively Hiring' }}
            </span>
            @if($listing->salary_min || $listing->salary_max)
              <span class="flex items-center text-yellow-300 text-sm font-bold bg-yellow-500/10 border border-yellow-500/20 px-3 py-1 rounded-full">
                <i class="fa-solid fa-money-bill-wave mr-1.5 text-xs"></i>
                @if($listing->salary_min && $listing->salary_max)
                  {{ number_format($listing->salary_min) }} – {{ number_format($listing->salary_max) }} MAD/mo
                @elseif($listing->salary_min)
                  From {{ number_format($listing->salary_min) }} MAD/mo
                @else
                  Up to {{ number_format($listing->salary_max) }} MAD/mo
                @endif
              </span>
            @endif
          </div>
        </div>

        <!-- Poster / Profile -->
        @if($listing->user)
          <div class="flex-shrink-0 flex flex-col items-center gap-2">
            <a href="/profile/{{ $listing->user->id }}"
              class="flex flex-col items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 px-5 py-3 rounded-xl transition-all group">
              <div class="w-10 h-10 rounded-full overflow-hidden border border-white/20 bg-white/10 flex items-center justify-center">
                @if($listing->user->avatar)
                  <img src="{{ asset('storage/'.$listing->user->avatar) }}" class="w-full h-full object-cover">
                @else
                  <i class="fa-solid fa-user text-white text-sm"></i>
                @endif
              </div>
              <div class="text-center">
                <p class="text-white text-xs font-bold group-hover:text-brand-red transition-colors">{{ $listing->user->name }}</p>
                <p class="text-gray-400 text-xs">View Profile</p>
              </div>
            </a>
            @auth
              @if(auth()->user()->isCompany() && $listing->user->isPerson())
                <button @click="offerModal=true"
                  class="btn-green text-white text-xs font-bold px-4 py-2 rounded-xl flex items-center space-x-1.5 w-full justify-center">
                  <i class="fa-solid fa-paper-plane text-xs"></i><span>Send Offer</span>
                </button>
              @endif
            @endauth
          </div>
        @endif

      </div>
    </div>

    <div class="p-8">

      <!-- Salary Range block (if set) -->
      @if($listing->salary_min || $listing->salary_max)
        <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-800/30 rounded-xl px-5 py-4 mb-8 flex items-center gap-4">
          <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-money-bill-wave text-yellow-600 dark:text-yellow-400"></i>
          </div>
          <div>
            <p class="text-xs font-bold text-yellow-700 dark:text-yellow-500 uppercase tracking-wider mb-0.5">
              {{ $listing->type === 'hobby' ? 'Expected Rate' : 'Salary Range' }}
            </p>
            <p class="text-base font-black text-yellow-800 dark:text-yellow-300">
              @if($listing->salary_min && $listing->salary_max)
                {{ number_format($listing->salary_min) }} – {{ number_format($listing->salary_max) }} MAD / month
              @elseif($listing->salary_min)
                From {{ number_format($listing->salary_min) }} MAD / month
              @else
                Up to {{ number_format($listing->salary_max) }} MAD / month
              @endif
            </p>
          </div>
          <p class="text-xs text-yellow-600 dark:text-yellow-500 ml-auto font-medium">Indicative range</p>
        </div>
      @endif

      <!-- Tags -->
      <div class="mb-8">
        <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">
          {{ $listing->type === 'hobby' ? 'Skills & Tags' : 'Required Skills' }}
        </h3>
        <x-listing-tags :tagsCsv='$listing->tags' />
      </div>

      <div class="border-t border-gray-100 dark:border-gray-700 my-8"></div>

      <!-- Description -->
      <div class="mb-10">
        <h2 class="text-xl font-black text-gray-900 dark:text-white mb-4 flex items-center gap-2">
          <div class="w-1 h-6 bg-brand-red rounded-full"></div>
          {{ $listing->type === 'hobby' ? 'About this Skill / Hobby' : 'Job Description' }}
        </h2>
        <div class="text-gray-600 dark:text-gray-300 leading-relaxed text-base whitespace-pre-line">
          {{$listing->description}}
        </div>
      </div>

      <!-- CTA Buttons -->
      <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">

        @if($listing->user)
          <a href="/profile/{{ $listing->user->id }}"
            class="inline-flex items-center justify-center space-x-2 font-bold py-4 px-8 rounded-xl text-base border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
            <i class="fa-solid fa-user"></i>
            <span>See Profile</span>
          </a>
        @endif

        @if($listing->type === 'job')
          {{-- Job offer posted by company → Person can Apply --}}
          @auth
            @if(auth()->id() === $listing->user_id)
              <div class="flex flex-col gap-3 w-full">
                <div class="inline-flex items-center justify-center w-full text-sm font-bold text-gray-200 bg-gray-700 px-4 py-4 rounded-xl">
                  This is your listing. Review applicants below.
                </div>
                <a href="/listings/{{ $listing->id }}/applicants" class="btn-primary text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center space-x-2 text-base">
                  <i class="fa-solid fa-users"></i>
                  <span>View Applicants</span>
                </a>
              </div>
            @elseif(auth()->user()->isCompany())
              <div class="inline-flex items-center justify-center w-full text-sm font-bold text-gray-200 bg-gray-700 px-4 py-4 rounded-xl">
                Company accounts that are not the owner cannot apply. Use your own job listings section.
              </div>
            @else
              @if($myApplication)
                <div class="flex flex-col gap-2 w-full">
                  <div class="rounded-xl text-sm font-bold px-4 py-3 border border-gray-200 dark:border-gray-700">
                    Your application status: 
                    @if($myApplication->status === 'accepted')
                      <span class="text-brand-green">Accepted</span>
                    @elseif($myApplication->status === 'rejected')
                      <span class="text-brand-red">Rejected</span>
                    @else
                      <span class="text-yellow-600">Pending</span>
                    @endif
                  </div>

                  @if($myApplication->status === 'accepted')
                    <div class="rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-500/20 p-4 text-sm text-green-900 dark:text-green-300">
                      Congratulations! The company accepted your application. Choose a contact method:
                      <div class="mt-3 flex flex-wrap gap-2">
                        <a href="mailto:{{$listing->email}}" class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-brand-red hover:bg-red-600 px-3 py-2 rounded-lg transition-all">
                          <i class="fa-solid fa-envelope"></i>
                          <span>Email: {{$listing->email}}</span>
                        </a>
                        @if($listing->user && $listing->user->phone)
                          <a href="tel:{{$listing->user->phone}}" class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-brand-green hover:bg-green-600 px-3 py-2 rounded-lg transition-all">
                            <i class="fa-solid fa-phone"></i>
                            <span>Phone: {{$listing->user->phone}}</span>
                          </a>
                        @else
                          <span class="inline-flex items-center gap-2 text-xs text-gray-600 dark:text-gray-300 bg-white/80 dark:bg-gray-800/80 px-2 py-1 rounded-lg">Phone unavailable</span>
                        @endif
                      </div>
                    </div>
                  @elseif($myApplication->status === 'rejected')
                    <div class="rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-500/20 p-4 text-sm text-red-900 dark:text-red-300">
                      Your application was rejected. The company may not contact you.
                    </div>
                  @else
                    <div class="rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-500/20 p-4 text-sm text-blue-900 dark:text-blue-300">
                      Your application is pending. The company must accept before detailed contact info is shown.
                    </div>
                  @endif
                </div>
              @else
                <form method="POST" action="/listings/{{ $listing->id }}/apply" class="space-y-3 w-full">
                  @csrf
                  <textarea name="message" rows="4" placeholder="Write a short cover message..." class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-sm text-gray-800 dark:text-gray-100" required></textarea>
                  <button type="submit" class="btn-primary text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center space-x-2 text-base">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Submit Application</span>
                  </button>
                </form>
              @endif
            @endif
          @else
            <a href="/login" class="btn-green text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center space-x-2 text-base">
              <i class="fa-solid fa-right-to-bracket"></i>
              <span>Login to Apply</span>
            </a>
          @endauth

          @if($listing->website)
            <a href="{{$listing->website}}" target="_blank" class="btn-green text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center space-x-2 text-base">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
              <span>Visit Website</span>
            </a>
          @endif

        @else
          {{-- Hobby/Skill posted by person → Company can Give an Offer --}}
          @auth
            @if(auth()->id() === $listing->user_id)
              <div class="inline-flex items-center justify-center w-full text-sm font-bold text-gray-200 bg-gray-700 px-4 py-4 rounded-xl">
                This is your listing. You cannot contact yourself.
              </div>
            @elseif(auth()->user()->isCompany())
              @php
                $existingOffer = $listing->user ? \App\Models\Offer::where('from_user_id', auth()->id())
                  ->where('to_user_id', $listing->user->id)
                  ->latest()->first() : null;
              @endphp
              @if($existingOffer)
                <div class="flex flex-col items-center gap-2">
                  <div class="inline-flex items-center space-x-2 font-bold py-4 px-8 rounded-xl text-base border-2
                    @if($existingOffer->status === 'accepted') border-brand-green text-brand-green bg-green-50 dark:bg-green-900/10
                    @elseif($existingOffer->status === 'rejected') border-brand-red text-brand-red bg-red-50 dark:bg-red-900/10
                    @else border-yellow-400 text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/10
                    @endif">
                    <i class="fa-solid @if($existingOffer->status === 'accepted') fa-circle-check @elseif($existingOffer->status === 'rejected') fa-circle-xmark @else fa-clock @endif"></i>
                    <span>
                      @if($existingOffer->status === 'accepted') Offer Accepted
                      @elseif($existingOffer->status === 'rejected') Offer Declined
                      @else Offer Pending
                      @endif
                    </span>
                  </div>
                  <button @click="offerModal=true" class="text-xs font-semibold text-gray-400 hover:text-brand-red transition-colors underline underline-offset-2">
                    Send a new offer
                  </button>
                </div>
              @else
                <button @click="offerModal=true" class="btn-green text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center space-x-2 text-base">
                  <i class="fa-solid fa-handshake"></i>
                  <span>Give an Offer</span>
                </button>
              @endif
            @else
              <a href="mailto:{{$listing->email}}" class="btn-primary text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center space-x-2 text-base">
                <i class="fa-solid fa-envelope"></i>
                <span>Contact via Email</span>
              </a>
            @endif
          @else
            <a href="/login" class="btn-green text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center space-x-2 text-base">
              <i class="fa-solid fa-handshake"></i>
              <span>Give an Offer</span>
            </a>
          @endauth
          @if($listing->website)
            <a href="{{$listing->website}}" target="_blank" class="inline-flex items-center justify-center space-x-2 font-bold py-4 px-8 rounded-xl text-base border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
              <span>View Portfolio</span>
            </a>
          @endif
        @endif

      </div>

    </div>
  </div>
</div><!-- end max-w-4xl -->

<!-- Send Offer Modal -->
@auth
  @if($listing->user && auth()->user()->isCompany() && $listing->user->isPerson())
    <div x-show="offerModal"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display:none;">
      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="offerModal=false"></div>
      <div x-show="offerModal"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden z-10">
        <div class="bg-brand-black px-6 py-5 flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="w-9 h-9 bg-brand-green rounded-xl flex items-center justify-center">
              <i class="fa-solid fa-paper-plane text-white text-sm"></i>
            </div>
            <div>
              <h3 class="text-lg font-black text-white">Send a Job Offer</h3>
              <p class="text-gray-400 text-xs">To {{ $listing->user->name }}</p>
            </div>
          </div>
          <button @click="offerModal=false" class="text-gray-400 hover:text-white">
            <i class="fa-solid fa-xmark text-lg"></i>
          </button>
        </div>
        <div class="p-6">
          <form method="POST" action="/offer/{{ $listing->user->id }}" class="space-y-5">
            @csrf
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Subject <span class="text-brand-red">*</span></label>
              <input type="text" name="subject" required
                value="{{ $listing->title }} — Offer"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-gray-50 dark:bg-gray-700 dark:text-white">
            </div>
            <!-- Salary Range -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Proposed Salary <span class="text-gray-400 font-normal text-xs">(optional — indicative range)</span>
              </label>
              <div class="flex items-center gap-2">
                <div class="relative flex-1">
                  <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-medium pointer-events-none">From</span>
                  <input type="number" name="salary_min" min="0"
                    class="w-full pl-12 pr-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-gray-50 dark:bg-gray-700 dark:text-white"
                    placeholder="5000">
                </div>
                <span class="text-gray-400 font-bold">–</span>
                <div class="relative flex-1">
                  <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-medium pointer-events-none">To</span>
                  <input type="number" name="salary_max" min="0"
                    class="w-full pl-8 pr-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-gray-50 dark:bg-gray-700 dark:text-white"
                    placeholder="12000">
                </div>
                <span class="text-gray-400 text-xs font-medium whitespace-nowrap">MAD/mo</span>
              </div>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Message <span class="text-brand-red">*</span></label>
              <textarea name="message" rows="4" required
                placeholder="Introduce yourself and the opportunity..."
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

</div><!-- end x-data -->

@endsection
