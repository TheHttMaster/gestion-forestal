@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'space-y-1 text-sm']) }}>
        @foreach ((array) $messages as $message)
            <li class="bg-red-400/10 border-2 border-red-600/50 dark:bg-red-400/10 dark:border-red-500/50 rounded-lg p-2 text-red-500 font-medium">{{ $message }}</li>
        @endforeach
    </ul>
@endif