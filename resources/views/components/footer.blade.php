<footer class="mt-6">
    <section class="bg-neutral-50">
        <div class="container">
            <div class="grid grid-cols-12 gap-4">
                <!-- Newsletter Section -->
                <div class="col-span-12 sm:col-span-6 lg:col-span-4 p-4" id="newsletterHolder">
                    <h3 class="font-bold text-xl">News Letter</h3>
                    <div id="emailFormDiv">
                        <p class="text-sm min-h-10">Sign up for our newsletter to get the latest updates</p>
                        <form class="border px-4 py-2 my-4 flex justify-between bg-white" action="{{ route('newsletter.subscribe') }}" method="POST" id="newsletter" autocomplete="on">
                            @csrf
                            <input type="email" name="email" placeholder="Enter your email" class="focus:outline-none w-3/4" autocomplete="email" required>
                            <button class="bg-orange-500 text-white px-4 py-2 hover:bg-orange-700">
                                <img src="{{ asset('images/icons/mail_bangabasi.png') }}" alt="" class="w-4 invert">
                            </button>
                        </form>

                    </div>
                    <!-- New form for first name and last name (hidden initially) -->
                    <p class="text-sm hidden" id="responseMessage"></p>
                    <div class="hidden" id="nameForm">
                        
                    <form class="border px-2 py-2 my-2 flex justify-between bg-white" action="{{ route('newsletter.subscribe_complete') }}" method="POST" id="nameDetailsForm" autocomplete="on">
                        @csrf
                        <input type="text" name="first_name" placeholder="First Name" class="px-2 focus:outline-none w-3/4" required autocomplete="given-name">
                        <input type="text" name="last_name" placeholder="Last Name" class="px-2 focus:outline-none w-3/4" required autocomplete="family-name">
                        <button class="bg-orange-500 text-white px-4 py-2 hover:bg-orange-700 ">Subscribe</button>
                    </form>

                    </div>
                </div>

                <!-- Follow Us Section -->
                <div class="col-span-12 sm:col-span-6 lg:col-span-4 p-4">
                    <h3 class="font-bold text-xl">Follow Us</h3>
                    <p class="text-sm min-h-10">Find whats happening in the backend.</p>
                    <div class="my-4 flex justify-start gap-2 py-2 bg-white w-fit px-2">
                        <a href="https://www.facebook.com/bangabasi.co" class="p-2 bg-orange-500 hover:bg-orange-700" target="_blank">
                            <img src="{{ asset('images/icons/facebook_bangabasi.png') }}" alt="" class="w-4 invert">
                        </a>
                        <a href="https://www.instagram.com/bangabasiindia/" class="p-2 bg-orange-500 hover:bg-orange-700" target="_blank">
                            <img src="{{ asset('images/icons/instagram_bangabasi.png') }}" alt="" class="w-4 invert">
                        </a>
                        <a href="https://www.youtube.com/@Bangabasiindia" class="p-2 bg-orange-500 hover:bg-orange-700" target="_blank">
                            <img src="{{ asset('images/icons/youtube_bangabasi.png') }}" alt="" class="w-4 invert">
                        </a>
                        <a href="https://in.pinterest.com/bangabasiindia/" class="p-2 bg-orange-500 hover:bg-orange-700" target="_blank">
                            <img src="{{ asset('images/icons/pinterest_bangabasi.png') }}" alt="" class="w-4 invert">
                        </a>
                        <a href="https://maps.app.goo.gl/BekqTPMAGE6CqbfC8" class="p-2 bg-orange-500" target="_blank">
                            <img src="{{ asset('images/icons/location_bangabasi.png') }}" alt="" class="w-4 invert">
                        </a>
                        <a href="https://whatsapp.com/channel/0029VakhvrpL2AU4lilJCV3R" class="p-2 bg-orange-500 hover:bg-orange-700" target="_blank">
                            <img src="{{ asset('images/icons/whatsapp_bangabasi.png') }}" alt="" class="w-4 invert">
                        </a>
                    </div>
                </div>

                <!-- Order via Whatsapp Section -->
                <div class="col-span-12 sm:hidden md:col-span-6 lg:block lg:col-span-4 p-4">
                    <h3 class="font-bold text-xl">Order via Whatsapp</h3>
                    <p class="text-sm min-h-10">Finding it difficult to order via Website?</p>
                    <div class="my-4 flex justify-start gap-2 text-white">
                        <a class="bg-green-600 hover:bg-green-800 px-4 py-2" href="https://wa.me/+919476168391">
                            Order via Whatsapp
                            <img src="{{ asset('images/icons/whatsapp_bangabasi.png') }}" alt="" class="w-4 invert inline-block mx-4">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-[#c44601] ">
        <div class="container">
            <div class="grid grid-cols-12 gap-4  text-white ">
                <div class="col-span-12 lg:col-span-6  ">
                    <div class="flex py-4 justify-center gap-4 ">
                        @if(isset($logos['2']))
                            <img src="{{ asset('user/uploads/logos/' . $logos['1']->image_path) }}" alt="footer-log" class="w-40">
                        @endif
                        <div class="border-left border border-neutral-200"></div>
                        <img src="{{ asset('images/svg/msme_icon_circle.png') }}" alt="mesme logo" class="border-left h-fit w-10">
                    </div>
                    <div class="text-center">
                        <p class="w-full md:w-3/4 mx-auto font-light text-sm"><b>Bangabasi.com</b>, a virtual gateway to Bengal’s finest offerings. Our mission is to make the crafts, food, apparel, and more of West Bengal accessible to anyone, anywhere.</p>
                    </div>
                    <div class="flex mt-4 gap-4 justify-around flex-wrap">
                        <div class="w-2/5  min-w-60 p-4">
                            <ul class="list-none space-y-2">
                                <li class="flex items-start gap-4">
                                    <img src="{{ asset('images/icons/pin_bangabasi.png')}}" alt="pinterest logo" class="inline w-4 " style="filter: brightness(10);">
                                    <address class="text-sm inline">
                                        0050 Gita Kuthir, Burdwan
                                        <br> Pin 713125 (WB) India
                                    </address>
                                </li>
                                <li class="flex items-center gap-4">
                                    <img src="{{ asset('images/icons/phone_bangabasi.png')}}" alt="phone icon" class="inline w-4 " style="filter: brightness(10);">
                                    <a href="tel:+919476168391">+91 9476 168 391</a>
                                </li>
                                <li class="flex items-center gap-4">
                                    <img src="{{ asset('images/icons/mail_bangabasi_1.png')}}" alt="mail icon" class="inline w-4 invert">
                                    <a href="mailto:info.bangabasi@gmail.com">info.bangabasi@gmail.com</a>
                                </li>
                            </ul>

                        </div>
                        <div class="flex-1  min-w-60 p-4">
                            <h6 class="text-bold "><span>GSTIN : </span>19EKRPD4832A1Z7</h6>
                            <h6 class="text-bold "><span>MSME : </span>UDYAM-WB-03-0025485</h6>
                            <h6 class="text-bold"><span>Trade Reg : </span>SSNOCPZVP36865047N</h6>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 lg:col-span-3 p-4 ">
                    <h3 class="font-bold text-xl">Quick Links</h3>
                    <ul class="list-none text-sm py-4 space-y-2">
                        <li>
                            <a class="hover:text-orange-500" href="{{ route('myprofile') }}">My Profile</a>
                        </li>
                        <li>
                            <a class="hover:text-orange-500" href="{{ route('cart') }}">Cart</a>
                        </li>
                        <li>
                            <a class="hover:text-orange-500" href="{{ route('sellers.index') }}">Shop</a>
                        </li>
                        <li>
                            <a class="hover:text-orange-500" href="{{ route('wishlist')}}">Wishlist</a>
                        </li>
                        <li>
                            <a class="hover:text-orange-500" href="">Track Order</a>
                        </li>
                    </ul>
                </div>
                <div class="col-span-6 lg:col-span-3 p-4 ">
                    <h3 class="font-bold text-xl">Services</h3>
                    <ul class="list-none text-sm py-4 space-y-2">
                        <li>
                            <a href="{{ route('about-us') }}" class="hover:text-orange-500">About Us</a>
                        </li>
                        <li>
                            <a href="{{ route('contact-us') }}" class="hover:text-orange-500">Contact</a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}" class="hover:text-orange-500">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}" class="hover:text-orange-500">Return & Refunds</a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}" class="hover:text-orange-500">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}" class="hover:text-orange-500">Delivery Detail & Charges</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sm:flex justify-center items-center gap-4 space-y-6 sm:space-y-0 text-white pt-0 pb-4 text-center">
                <h6 class="text-bold text-sm text-neutral-300">Pay With</h6>
                <div class="border-l-2 border-gray-500 border-r-2 flex justify-around flex-wrap gap-2 px-4 sm:min-w-80">
                    <img src="{{ asset('/images/svg/visa.png')}}" alt="payment methods" class="w-10">
                    <img src="{{ asset('/images/svg/cirrus.png')}}" alt="payment methods" class="w-10">
                    <img src="{{ asset('/images/svg/american-express.png')}}" alt="payment methods" class="w-10 hidden sm:block">
                    <img src="{{ asset('/images/svg/master-card.png')}}" alt="payment methods" class="w-10">
                    <img src="{{ asset('/images/svg/cirrus.png')}}" alt="payment methods" class="w-10">
                    <img src="{{ asset('/images/svg/paypal.png')}}" alt="payment methods" class="w-10">
                </div>
                @if(isset($logos['2']))
                    <img src="{{ asset('user/uploads/logos/' . $logos['1']->image_path) }}" alt="footer small logo" class="w-24 mx-auto sm:mx-0">
                @endif
            </div>
        </div>
        <div class="text-center border-t-2 border-gray-400 text-neutral-50 space-y-2 text-sm py-4">
            <p>2024 | Bangabasi</p>
            <p>Built with ❤️ by <a href="">Starpact Global Services</a></p>
        </div>
    </section>
</footer>