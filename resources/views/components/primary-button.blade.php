<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-success font-weight-bold tracking-wide']) }}>
    {{ $slot }}
</button>
