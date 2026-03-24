@extends('Layout')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-16 px-4">
  <div class="w-full max-w-md">

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-black rounded-2xl mb-4">
          <i class="fa-solid fa-arrow-right-to-bracket text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-black text-gray-900">Welcome Back</h2>
        <p class="text-gray-500 mt-1 text-sm">Sign in to manage your job listings</p>
      </div>

      <form method="POST" action="/users/authenticate">
        @csrf

        <div class="space-y-5">
          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-envelope text-gray-400 text-sm"></i>
              </div>
              <input type="email" name="email" value="{{old('email')}}"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-900 placeholder-gray-400 bg-gray-50 focus:bg-white transition-all"
                placeholder="you@example.com" />
            </div>
            @error('email')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{$message}}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
              </div>
              <input type="password" name="password"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-900 placeholder-gray-400 bg-gray-50 focus:bg-white transition-all"
                placeholder="••••••••" />
            </div>
            @error('password')
            <p class="text-brand-red text-xs mt-1.5 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{$message}}</p>
            @enderror
          </div>

          <!-- Submit -->
          <button type="submit" class="btn-primary w-full text-white font-bold py-3.5 rounded-xl text-sm flex items-center justify-center space-x-2 mt-2">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
            <span>Sign In</span>
          </button>
        </div>
      </form>

      <!-- Divider -->
      <div class="my-6 flex items-center gap-4">
        <div class="flex-1 h-px bg-gray-100"></div>
        <span class="text-gray-400 text-xs font-medium">New to Jobby?</span>
        <div class="flex-1 h-px bg-gray-100"></div>
      </div>

      <a href="/register" class="block w-full text-center border-2 border-gray-200 text-gray-700 font-bold py-3 rounded-xl text-sm hover:border-brand-red hover:text-brand-red transition-all">
        Create an Account
      </a>
    </div>

  </div>
</div>

@endsection
