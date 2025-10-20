@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => ' text-green-600 dark:text-green-400 border-2 border-green-600/50 bg-green-400/10 dark:bg-green-500/10 dark:border-green-500/50 rounded-lg p-2 text-green-500 font-medium']) }}>
        {{ $status }}
    </div>
@endif
