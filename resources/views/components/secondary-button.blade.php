<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary btn-sm font-weight-bold text-uppercase tracking-wide shadow-sm']) }}>
    {{ $slot }}
</button>
