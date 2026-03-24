@extends('Layout')
@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-950 flex items-center justify-center py-16 px-4">
  <div class="w-full max-w-lg">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
      <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-red rounded-2xl mb-4">
          <i class="fa-solid fa-user-plus text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-black text-gray-900 dark:text-white">Join Jobby</h2>
        <p class="text-gray-500 mt-1 text-sm">Job or Hobby — find your place</p>
      </div>
      <div x-data="{ type: '{{ old('type', 'person') }}' }">
        <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 text-center">I am a...</p>
        <div class="grid grid-cols-2 gap-3 mb-6">
          <button type="button" @click="type='person'"
            :class="type==='person' ? 'border-brand-red bg-red-50 dark:bg-red-950' : 'border-gray-200 dark:border-gray-700'"
            class="border-2 rounded-xl p-4 text-center transition-all cursor-pointer">
            <i class="fa-solid fa-user text-2xl mb-2 block" :class="type==='person' ? 'text-brand-red' : 'text-gray-400'"></i>
            <p class="font-bold text-sm" :class="type==='person' ? 'text-brand-red' : 'text-gray-600 dark:text-gray-400'">Person</p>
            <p class="text-xs text-gray-400 mt-0.5">Freelancer / Hobbyist</p>
          </button>
          <button type="button" @click="type='company'"
            :class="type==='company' ? 'border-brand-red bg-red-50 dark:bg-red-950' : 'border-gray-200 dark:border-gray-700'"
            class="border-2 rounded-xl p-4 text-center transition-all cursor-pointer">
            <i class="fa-solid fa-building text-2xl mb-2 block" :class="type==='company' ? 'text-brand-red' : 'text-gray-400'"></i>
            <p class="font-bold text-sm" :class="type==='company' ? 'text-brand-red' : 'text-gray-600 dark:text-gray-400'">Company</p>
            <p class="text-xs text-gray-400 mt-0.5">Employer / Recruiter</p>
          </button>
        </div>
        <form method="POST" action="/users">
          @csrf
          <input type="hidden" name="type" :value="type">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
              <input type="text" name="name" value="{{old('name')}}" placeholder="Your full name"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white transition-all">
              @error('name')<p class="text-brand-red text-xs mt-1 font-medium">{{$message}}</p>@enderror
            </div>
            <div x-show="type==='company'" x-transition>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Company Name *</label>
              <input type="text" name="company_name" value="{{old('company_name')}}" placeholder="Your company name"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white transition-all">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email *</label>
              <input type="email" name="email" value="{{old('email')}}" placeholder="you@example.com"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white transition-all">
              @error('email')<p class="text-brand-red text-xs mt-1 font-medium">{{$message}}</p>@enderror
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password *</label>
              <input type="password" name="password" placeholder="Min. 6 characters"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white transition-all">
              @error('password')<p class="text-brand-red text-xs mt-1 font-medium">{{$message}}</p>@enderror
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm Password *</label>
              <input type="password" name="password_confirmation" placeholder="Repeat password"
                class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-gray-50 dark:bg-gray-800 dark:text-white focus:bg-white transition-all">
            </div>
            <button type="submit" class="btn-primary w-full text-white font-bold py-3.5 rounded-xl text-sm flex items-center justify-center space-x-2">
              <i class="fa-solid fa-rocket"></i><span>Create My Account</span>
            </button>
          </div>
        </form>
        <p class="text-center text-sm text-gray-500 mt-6">Already have an account? <a href="/login" class="text-brand-red font-bold hover:underline">Sign In</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
