@extends('Layout')

@section('content')
@include('partials._hero')
@include('partials._search')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

  @if(request('search'))
  <div class="mb-6 flex items-center justify-between">
    <p class="text-gray-600 text-sm">
      Showing results for <span class="font-bold text-gray-900">"{{request('search')}}"</span>
      — <span class="text-brand-red font-semibold">{{$listings->total()}} jobs found</span>
    </p>
  </div>
  @else
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h2 class="text-2xl font-black text-gray-900">Latest Opportunities</h2>
      <p class="text-gray-500 text-sm mt-1">Discover your next career move</p>
    </div>
    <span class="bg-red-50 text-brand-red text-sm font-bold px-3 py-1.5 rounded-full">
      {{$listings->total()}} Jobs
    </span>
  </div>
  @endif

  @unless(count($listings) == 0)
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    @foreach($listings as $listing)
      <x-listing-card :listing="$listing"/>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-10 flex justify-center">
    <div class="pagination-wrapper">
      {{$listings->links()}}
    </div>
  </div>

  @else
  <div class="text-center py-24">
    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
      <i class="fa-solid fa-briefcase text-gray-300 text-3xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">No Jobs Found</h3>
    <p class="text-gray-500 mb-6">Try adjusting your search or browse all listings.</p>
    <a href="/" class="btn-primary text-white font-semibold px-6 py-3 rounded-xl inline-block">
      Browse All Jobs
    </a>
  </div>
  @endunless

</div>
@endsection
