@if(session()->has('message'))
<div
  x-data="{show: true}"
  x-init="setTimeout(() => show = false, 4000)"
  x-show="show"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
  x-transition:enter-end="opacity-100 transform translate-y-0"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 flex items-center space-x-3 bg-brand-black text-white px-6 py-3.5 rounded-xl shadow-2xl border border-green-500/30"
>
  <div class="w-6 h-6 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0">
    <i class="fa-solid fa-check text-white text-xs"></i>
  </div>
  <p class="text-sm font-medium">{{session('message')}}</p>
  <button @click="show = false" class="text-gray-400 hover:text-white ml-2">
    <i class="fa-solid fa-xmark text-xs"></i>
  </button>
</div>
@endif
