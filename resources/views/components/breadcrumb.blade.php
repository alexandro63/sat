@props(['title' => null])

@php
    $segments = Request::segments();
    $url = url('/');
@endphp

<div class="page-header">
    <h4 class="page-title">{{ $title ?? ucfirst(end($segments)) }}</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ url('/') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>

        @foreach ($segments as $index => $segment)
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>

            @php
                $url .= '/' . $segment;
                $isLast = $loop->last;
            @endphp

            <li class="nav-item {{ $isLast ? 'active' : '' }}">
                @if ($isLast)
                    <span>{{ ucfirst(str_replace('-', ' ', $segment)) }}</span>
                @else
                    <a href="{{ $url }}">{{ ucfirst(str_replace('-', ' ', $segment)) }}</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
