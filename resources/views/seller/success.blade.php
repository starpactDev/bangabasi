<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/bangabasi_favicon.png" sizes="32x32" />
    <title>Bangabasi | Seller Registration</title>
    @vite('resources/css/app.css')
    @stack('css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg text-center">
        <img src="/images/bangabasi_logo_short.png" alt="Bangabasi Logo" class="mx-auto h-20 mb-6">
        
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Congratulations!</h1>
        
        <p class="text-gray-600 mb-6">
            Your seller account has been successfully registered. Please wait for admin approval.
        </p>
        
        <p class="text-gray-500 mb-8">
            Once approved, you'll be able to access your vendor dashboard and start managing your products.
        </p>
        
        <div class="flex justify-center gap-4">
            <a href="{{ route('home')}}" class="bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg px-6 py-3 transition duration-300"> Go Back to Home </a>
            <a href="{{ route('seller_dashboard') }}" class="bg-gray-300 text-gray-800 hover:bg-gray-400 rounded-lg px-6 py-3 transition duration-300"> Seller </a>
        </div>
    </div>
</body>

</html>
