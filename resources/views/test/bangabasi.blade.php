<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample HTML with Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">
    <div class="container mx-auto p-4">
        <!-- Header -->
        <header class="bg-gray-800 text-white py-4 text-center">
            <h1 class="text-2xl font-bold">My Website</h1>
        </header>
        
        <!-- Navigation -->
        <nav class="bg-gray-900 text-white">
            <ul class="flex justify-center space-x-4 py-2">
                <li><a href="#" class="hover:bg-gray-700 px-4 py-2 rounded">Home</a></li>
                <li><a href="#" class="hover:bg-gray-700 px-4 py-2 rounded">About</a></li>
                <li><a href="#" class="hover:bg-gray-700 px-4 py-2 rounded">Services</a></li>
                <li><a href="#" class="hover:bg-gray-700 px-4 py-2 rounded">Contact</a></li>
            </ul>
        </nav>
        
        <!-- Main Content -->
        <div class="flex mt-4">
            <!-- Sidebar -->
            <aside class="w-1/4 bg-gray-200 p-4">
                <h2 class="text-xl font-semibold mb-2">Sidebar Title</h2>
                <p class="text-gray-700">Some text for the sidebar.</p>
            </aside>
            
            <!-- Article -->
            <main class="w-3/4 bg-white p-4 ml-4">
                <h2 class="text-xl font-semibold mb-4">Article Title</h2>
                <p class="text-gray-800 mb-4">This is the main content area. Here you can write about various topics. Make sure to add relevant and engaging content.</p>
                <a href="#" class="inline-block px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Read More</a>
                <p class="bg-yellow-200 p-2 mt-4">Highlighted text example.</p>
            </main>
        </div>
        
        <!-- Footer -->
        <footer class="bg-gray-800 text-white text-center py-4 mt-4">
            <p>&copy; 2024 My Website</p>
        </footer>
    </div>
</body>
</html>
