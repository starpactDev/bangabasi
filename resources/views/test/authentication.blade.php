<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bangabasi Authentication</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <section class="authentication h-screen">
        <div class="container">
            <div class="grid grid-cols-12 ">
                <div class="col-span-12 logo mx-auto w-1/4 min-w-72 my-4">
                    <img src="/images/bangabasi_logo_black.png" alt="bangabasi_logo">
                </div>
                <div class="col-span-12 mx-auto  min-w-80 w-2/5 max-w-96 py-4 rounded-lg auth-container">
                    <ul class="flex justify-around px-4">
                        <li class="flex-1 py-4 text-center border-b border-b-2 border-gray-500 hover:border-gray-400 hover:border-b-2 navs" onclick="toggleAuth('authIn', event)">Sign In</li>
                        <li class="flex-1 py-4 text-center border-b hover:border-gray-400 hover:border-b-2 navs" onclick="toggleAuth('authUp', event)">Sign Up</li>
                    </ul>
                    <form id="authIn" action="" class="signin px-6 py-8 min-h-96 ">
                        <input type="text" class="w-full rounded leading-10 px-6 my-4 " placeholder="Username or email">
                        <input type="password" class="w-full rounded leading-10 px-6 my-4 " placeholder="Password">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember" class="mx-2">Remember Me</label>
                        <input type="submit" value="Sign In" class="leading-10 bg-orange-500 rounded w-full text-white text-center my-4 hover:bg-orange-600 active:bg-orange-700">
                        <a href="" class="text-center text-blue-700">Lost Your Password ?</a>
                    </form>
                    <form id="authUp" action="" class="signup px-6 py-8 min-h-96 hidden">
                        <input type="text" class="w-full rounded leading-10 px-6 my-2 " placeholder="Full name">
                        <input type="tel" class="w-full rounded leading-10 px-6 my-2 " placeholder="Phone number">
                        <input type="email" class="w-full rounded leading-10 px-6 my-2 " placeholder="Username or email">
                        <input type="password" class="w-full rounded leading-10 px-6 my-2 " placeholder="password">
                        <input type="password" class="w-full rounded leading-10 px-6 my-2 " placeholder="Confirm password">
                        <input type="submit" value="Sign Up" class="leading-10 bg-orange-500 rounded w-full text-white text-center my-4 hover:bg-orange-600 active:bg-orange-700">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="/js/script.js" async></script>
</body>
</htmnl>