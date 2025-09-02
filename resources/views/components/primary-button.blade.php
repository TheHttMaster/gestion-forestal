<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-sky-600 dark:bg-sky-500/80 border border-transparent rounded-md font-semibold text-xs text-white  uppercase tracking-widest hover:bg-sky-600 dark:hover:bg-sky-700 focus:bg-sky-700 dark:focus:bg-sky-600 active:bg-sky-700/70 dark:active:bg-sky-800/70 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
