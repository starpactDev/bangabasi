<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#f97417">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Explore the rich culture of Bengal with Bangabasi.com. Discover authentic Bengali crafts, food, apparel, and more, supporting talented artisans and connecting you to Bengal’s heritage worldwide." />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')

    @stack('css')
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="icon" href="/images/bangabasi_favicon.png" sizes="32x32" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    @yield('head')
</head>

<body class="overflow-x-hidden " >

    @include('parts.header')

    @yield('content')
    
    <x-footer />
    <x-navbar />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @stack('scripts')
    <script type="text/javascript" src="/js/script.js" async></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function initLazyLoading() {
                const images = document.querySelectorAll('img');

                images.forEach(img => {
                    if (img.hasAttribute('data-src')) return;

                    const originalSrc = img.getAttribute('src');
                    img.setAttribute('data-src', originalSrc);
                    img.setAttribute('src', '/images/placeholder.png'); // Path to your transparent placeholder

                    //console.log('Image setup for lazy loading:', img);
                });

                const lazyImages = [].slice.call(document.querySelectorAll('img[data-src]'));

                if ("IntersectionObserver" in window) {
                    const lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                const lazyImage = entry.target;
                                lazyImage.src = lazyImage.dataset.src;
                                lazyImage.classList.remove('lazy');
                                lazyImageObserver.unobserve(lazyImage);

                                
                            }
                        });
                    });

                    lazyImages.forEach(function(lazyImage) {
                        lazyImageObserver.observe(lazyImage);
                    });
                } else {
                    const lazyLoad = function() {
                        lazyImages.forEach(function(lazyImage) {
                            if (lazyImage.getBoundingClientRect().top < window.innerHeight && lazyImage
                                .getBoundingClientRect().bottom > 0) {
                                lazyImage.src = lazyImage.dataset.src;
                                lazyImage.classList.remove('lazy');

                                
                            }
                        });
                    };

                    lazyLoad();
                    window.addEventListener('scroll', lazyLoad);
                    window.addEventListener('resize', lazyLoad);
                }
            }
            initLazyLoading();
        });
    </script>
    <script>
        function searchProducts() {
            let query = document.getElementById('search_bar').value;

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('search.subcategories') }}", // Laravel route
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        let results = data.products;
                        let searchResultDiv = document.getElementById('search_result');
                        let resultsContainer = document.getElementById('results_container');
                        let searchHeader = document.getElementById('search_header');

                        resultsContainer.innerHTML = '';

                        if (results.length > 0) {
                            searchHeader.querySelector('div:first-child').innerText = 'Results for "' + query +
                                '"';
                            results.forEach(product => {
                                // Check if product is an object and has `sub_category`
                                if (typeof product === 'object' && product.name) {
                                    resultsContainer.innerHTML += `
                            <div class="w-full flex items-center gap-4 hover:bg-gray-200/30 hover:cursor-pointer mt-2 py-2 px-4"
                                 data-subcategory="${product.id}"
                                 >
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                                <div class="text-md text-red-600 font-semibold">${product.name}</div>
                            </div>`;
                                }
                            });
                        } else {
                            searchHeader.querySelector('div:first-child').innerText = 'No results found for "' +
                                query + '"';
                        }

                        searchResultDiv.style.display = 'block';
                    },
                    error: function(xhr) {
                        console.error("Search failed:", xhr.responseText);
                        // Optionally display an error message to the user
                    }
                });
            } else {
                document.getElementById('search_result').style.display = 'none';
            }
        }
    </script>
    <script type="text/javascript" id="searchCategory">
        document.addEventListener('DOMContentLoaded', function() {
            const searchBar = document.getElementById('search_bar');
            const searchResult = document.getElementById('search_result');

            searchBar.addEventListener('focus', function() {
                // Show the search results when the input is focused

                searchResult.style.display = 'block';
            });

            searchBar.addEventListener('blur', function() {
                // Add a delay to avoid immediate hiding when clicking inside search results
                setTimeout(function() {
                    if (!searchResult.contains(document.activeElement)) {
                        searchResult.style.display = 'none';
                    }
                }, 100);
            });

            searchResult.addEventListener('mousedown', function(event) {

                let subCategoryName = event.target.closest('[data-subcategory]')?.getAttribute(
                    'data-subcategory');

                if (subCategoryName) {

                    redirectToSubcategory(subCategoryName); // Call the redirect function
                }
                event.stopPropagation(); // Prevent clicks inside search results from closing it
            });

            function redirectToSubcategory(subCategoryId) {
                if (subCategoryId) {

                    // Dynamically generate the URL using Laravel's route helper
                    let productsUrl = "{{ route('user.products') }}";
                    // Append the sub_category_id as a query parameter to the URL
                    productsUrl += `?sub_category=${subCategoryId}`;
                    // Redirect to the constructed URL
                    window.location.href = productsUrl;
                }
            }


            document.addEventListener('click', function(event) {
                // Hide search results when clicking outside the search bar and search results
                if (!searchBar.contains(event.target) && !searchResult.contains(event.target)) {
                    searchResult.style.display = 'none';
                }
            });
        });
    </script>
    <script id="searchCategory">
        document.addEventListener('DOMContentLoaded', function() {
            // Handle category dropdown change
            document.getElementById('categoryDropdown').addEventListener('change', function() {
                const selectedValue = this.value;

                if (selectedValue !== 'all-categories') {
                    // Use the route helper to generate the base URL for the route
                    let baseUrl = `{{ route('user.products') }}`;

                    // Append the sub_category as a query parameter
                    let url = `${baseUrl}?sub_category=${encodeURIComponent(selectedValue)}`;

                    // Redirect to the constructed URL
                    window.location.href = url;
                }
            });
        });
    </script>
    <script>
        function redirectToCart(event) {
                event.stopPropagation(); // Prevent the click from bubbling up to the <a> tag
                window.location.href = "{{ route('cart') }}"; // Redirect to the cart
            }

    </script>
</body>

</html>
