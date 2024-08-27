@props([
    "messages",
])

@if ($messages)
    <ul
        {{ $attributes->merge(["class" => "text-sm text-red-600 space-y-1"]) }}
    >
        @foreach ((array) $messages as $message)
            @if (is_array($message))
                @foreach ($message as $arrayMessage)
                    <li>{{ $arrayMessage }}</li>
                @endforeach
            @else
                <li>{{ $message }}</li>
            @endif
        @endforeach
    </ul>
@endif
