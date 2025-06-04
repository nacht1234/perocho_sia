@props([
    'class' => 'h-10 w-auto rounded',
    'src' => 'images/spark_logo.png',
    'alt' => 'App Logo',
])

<img src="{{ asset($src) }}" alt="{{ $alt }}" class="{{ $class }}">
