@props(['tagsCsv'])

@php
$tags = explode(',', $tagsCsv);
@endphp

<ul class="flex flex-wrap gap-2">
  @foreach($tags as $tag)
  <li>
    <a href="/?tag={{trim($tag)}}" class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-100 text-gray-600 text-xs font-semibold hover:bg-red-50 hover:text-brand-red transition-colors">
      {{trim($tag)}}
    </a>
  </li>
  @endforeach
</ul>
