<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPARK</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-gray-600 text-white p-4 shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/spark_logo.png') }}" alt="Spark Logo" class="h-12 mr-3 rounded">
            </div>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('register') }}">
                        <button class="bg-gradient-to-b from-gray-300 to-white hover:from-white hover:to-gray-300 text-gray-800 font-semibold py-2 px-6 rounded shadow">Signup</button>
                    </a></li>
                    <li><a href="{{ route('login') }}">
                        <button class="bg-gradient-to-b from-gray-300 to-white hover:from-white hover:to-gray-300 text-gray-800 font-semibold py-2 px-6 rounded shadow">Login</button>
                    </a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="min-h-screen">
        <div 
            class="flex items-center justify-center min-h-screen bg-cover bg-center bg-no-repeat" 
            style="background-image: url('{{ asset('images/welcome-bg.jpg') }}');"
        >
            <div class="bg-gray-900 bg-opacity-5 p-8 rounded-lg shadow-lg max-w-6xl text-center">
                <img src="{{ asset('images/spark_logo.png') }}" alt="BusNet Logo" class="mx-auto w-72 h-auto mb-4 rounded">
                <h1 class="text-3xl font-semibold text-gray-200">Welcome to SPARK!</h1>
                <p class="mt-2 text-gray-100 mb-8">Your one-stop solution for car park booking.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @php
                        $features = [
                            ['image' => 'images/welcome-car-img.jpg'],
							['image' => 'images/welcome-car-img1.jpg'],
							['image' => 'images/welcome-car-img2.jpg'],
							['image' => 'images/welcome-car-img1.jpg'],
							['image' => 'images/welcome-car-img.jpg'],
							['image' => 'images/welcome-car-img1.jpg'],
							['image' => 'images/welcome-car-img2.jpg'],
							['image' => 'images/welcome-car-img1.jpg'],
							['image' => 'images/welcome-car-img.jpg'],
                        ];
                    @endphp

                    @foreach($features as $feature)
						<div class="bg-gray-100 rounded-xl p-6 shadow-md flex flex-col items-center justify-center text-center">
							<img src="{{ asset($feature['image']) }}" alt="Feature" class="w-24 h-24 object-contain mb-2">
						</div>
					@endforeach
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-200 text-center text-gray-700 py-4 mt-8">
        &copy; {{ date('Y') }} SPARK. All rights reserved.
    </footer>
</body>
</html>
