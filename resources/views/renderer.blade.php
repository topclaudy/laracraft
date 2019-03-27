@extends($theme)

@foreach($regions as $region) {{-- The 'regions' variable is injected from LaracraftServiceProvider (via the 'registerViewComposer' method) --}}
    @section($region->name)
        <div class="region-{{ $region->machine_name }}">
        @foreach($region->blocks ?: [] as $block)
            <div class="block-{{ $block->machine_name }}">
            @block($block->machine_name)
            </div>
        @endforeach
        </div>
    @endsection
@endforeach