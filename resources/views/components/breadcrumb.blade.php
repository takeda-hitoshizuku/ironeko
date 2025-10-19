@if(count($items) > 0)
<nav class="breadcrumb-container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">🏠 ホーム</a>
        </li>
        @foreach($items as $item)
            @if(!$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                </li>
            @else
                <li class="breadcrumb-item active">
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif
