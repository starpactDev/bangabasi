
function tabToggle(item){
    const tabs = document.querySelectorAll('.tabs')
    tabs.forEach(function(tab){
        tab.classList.contains('hidden') ? null : tab.classList.add('hidden')
    })
    item.classList.contains('hidden') ? item.classList.remove('hidden') : null
}

const tabList = document.getElementById('tabList')
if(tabList){
    tabList.addEventListener('click', (event)=>{
        Array.from(tabList.children).forEach(function(tab){
            tab.classList.contains('bg-slate-50') ? null : tab.classList.add('bg-slate-50')
            tab.classList.contains('text-orange-600') ? tab.classList.remove('text-orange-600') : null
        })
        event.target.classList.add('text-orange-600')
        event.target.classList.remove('bg-slate-50')
    })
}


const thumbs = document.querySelectorAll('.thumb')
const preview = document.getElementById('preview')

if(preview){
    viewType = preview.getAttribute('data-type')
    function zoomEff(){
        preview.addEventListener('mouseenter', () => {
            if(viewType == 'image'){
               preview.classList.add('zoomed'); 
            }
        });
        
        preview.addEventListener('mouseleave', () => {
            preview.style.backgroundPosition = 'center';
            preview.classList.remove('zoomed');
        });
    
        preview.addEventListener('mousemove', (e)=>{
            if(viewType == 'image'){
                const { left, top, width, height } = preview.getBoundingClientRect();
                const x = e.clientX - left;
                const y = e.clientY - top;
                
                const xPercent = (x / width) * 100;
                const yPercent = (y / height) * 100;
                
                preview.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
            }
        })
    }
    zoomEff()
}


if(thumbs && preview){
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', (e)=>{
            let src = e.target.getAttribute('src')
            console.log(`url(${src})`)

            src = encodeURI(src).replace(/\(/g, '%28').replace(/\)/g, '%29')

            console.log(preview)
            
            preview.style.backgroundImage = `url(${src})`
            preview.setAttribute('data-type', e.target.getAttribute('data-type'))
            viewType = preview.getAttribute('data-type')


            const nativeFrame = document.getElementById('nativeFrame')
            const ytFrame = document.getElementById('ytFrame')
            const playBtn = document.getElementById('playBtn')

            if(e.target.getAttribute('data-type') == 'youtube'){
                
                const ytURL = e.target.getAttribute('yt-url')

                if(playBtn){
                    playBtn.classList.remove('hidden')
                    playBtn.setAttribute('yt-url', ytURL)

                    playBtn.addEventListener('click', (e) => {
                        preview.style.backgroundImage = 'none'
                        const ytLink = e.target.getAttribute('yt-url')

                        if(ytFrame && ytLink){
                            ytFrame.setAttribute('src', ytLink)
                            playBtn.classList.add('hidden')
                            ytFrame.classList.remove('hidden')
                        }
                    })
                }
                
                nativeFrame ? nativeFrame.classList.add('hidden') : null
            }
            else if(e.target.getAttribute('data-type') == 'video'){
                nativeFrame ? nativeFrame.classList.remove('hidden') : null
                preview.style.backgroundImage = 'none'
            }
            else{
                
                nativeFrame ? nativeFrame.classList.add('hidden') : null

                ytFrame ? ytFrame.classList.add('hidden') : null
                playBtn ? playBtn.classList.add('hidden') : null
            }
        })
    })
}



let cartCountElement = document.getElementById('cartCount')
let cartCount

cartCountElement ? cartCount = parseInt(cartCountElement.innerHTML, 10) : null

function upCount(){
    cartCount += 1
    cartCountElement.innerHTML = cartCount
}

function downCount(){
    if(!cartCount <= 0){
        cartCount -= 1
        cartCountElement.innerHTML = cartCount
    }
}

function toggleAuth(tabId, event){

    const navs = document.querySelectorAll('.navs')
    const forms = document.getElementsByTagName('form')

    Array.from(navs).forEach(nav =>{
        nav.classList.remove('border-b-2', 'border-gray-500')
    })

    event.target.classList.add('border-b-2', 'border-gray-500')

    Array.from(forms).forEach(form => {
        console.log(form.getAttribute('id'))
        form.getAttribute('id') == tabId ? form.classList.remove('hidden') : form.classList.add('hidden')
    })

}

function authLoad(xyz){
    const sub = document.getElementById('auth'+xyz)
    const authCont = document.querySelectorAll('.auth-cont')

    Array.from(authCont).forEach(auth => auth.classList.add('hidden'))

    if(sub){
        sub.classList.toggle('hidden')
    }

}

function toggleCoupon(xyz){
    const sub = document.getElementById(xyz+'Cont')
    sub.classList.toggle('hidden')
}

if(typeof Swiper !== 'undefined'){

    const swiper = new Swiper(".popular-picks", {
        slidesPerView: 1,
        spaceBetween: 60,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1440: {
                slidesPerView: 4,
                spaceBetween: 40,
            }
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next", 
            prevEl: ".swiper-button-prev", 
        },
        loop: true,
    });
    

    const swiper2 = new Swiper(".after-grooming", {
        slidesPerView: 1,
        spaceBetween: 60,
        autoplay: {
            delay: 2500,
            reverseDirection: true,
            disableOnInteraction: true,
        },
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1440: {
                slidesPerView: 4,
                spaceBetween: 40,
            }
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next", 
            prevEl: ".swiper-button-prev", 
        },
        loop : true,

    });

    const swiper3 = new Swiper(".most", {
        slidesPerView: 1,
        spaceBetween: 40,
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 20,
            }
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next", 
            prevEl: ".swiper-button-prev",
        },
        loop : true

    })

    const swiper4 = new Swiper(".marquee", {
        slidesPerView: 1,
        spaceBetween: 0,
        loop : true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        }
    })

    const swiper5 = new Swiper(".brand", {
        slidesPerView: 2,
        spaceBetween: 10,
        loop: true,
        autoplay: {
            delay: 2500,
            reverseDirection: true,
            disableOnInteraction: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 6,
                spaceBetween: 10,
            }
        }
    });

    const swiper6 = new Swiper(".blog", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop : true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            }
        }

    });

    const swiper7 = new Swiper(".related", {
        slidesPerView: 1,
        spaceBetween: 80,
        loop : true,
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 80,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 80,
            }
        }

    });

    const swiper8 = new Swiper(".interested", {
        slidesPerView: 2,
        spaceBetween: 20,
        loop : true,
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 80,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 80,
            }
        }
    });

    const swiper9 = new Swiper(".may-interest", {
        slidesPerView: 2,
        spaceBetween: 30,
        loop : true,
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        },
        breakpoints: {
            425: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 40,
            }
        }
    });

    const swiper10 = new Swiper(".welcome", {
        spaceBetween: 30,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
          },
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        },
    });

    const swiper11 = new Swiper(".dashkarma-swiper", {
        slidesPerView: 1,
        spaceBetween: 40,
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 40,
            },
            1440: {
                slidesPerView: 6,
                spaceBetween: 40,
            }
        },
        autoplay: {
            delay: 2500,
            
            disableOnInteraction: true,
        },
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        }
    });

    const swiper12 = new Swiper(".machinery-swiper", {
        slidesPerView: 1,
        spaceBetween: 40,
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 40,
            },
            1440: {
                slidesPerView: 6,
                spaceBetween: 40,
            }
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        }
    });

    const swiper13 = new Swiper(".clothing-swiper", {
        slidesPerView: 1,
        spaceBetween: 40,
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 40,
            },
            1440: {
                slidesPerView: 6,
                spaceBetween: 40,
            }
        },
        autoplay: {
            delay: 2500,
            
            disableOnInteraction: true,
          },
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        }
    });

    const swiper14 = new Swiper(".food-swiper", {
        slidesPerView: 1,
        spaceBetween: 40,
        breakpoints: {
            425: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 40,
            },
            1440: {
                slidesPerView: 6,
                spaceBetween: 40,
            }
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        pagination: {
          el: ".swiper-pagination",
          dynamicBullets: true,
          clickable: true,
        }
    });

}

/* My Profile Page */

// Get all necessary DOM elements
const editButton = document.getElementById('editButton');
const updateButton = document.getElementById('updateButton');
const profileForm = document.getElementById('profileForm');
const actionButtons = document.getElementById('actionButtons');
const openFormButton = document.getElementById('open-form-button');
const addressForm = document.getElementById('address-form');
const savedAddresses = document.getElementById('saved-addresses');

// Function to toggle edit mode
function toggleEditMode(isEditing) {
    // Toggle the classes for all input containers
    document.querySelectorAll('.input-container').forEach(container => {
        container.classList.toggle('border-gray-300', isEditing);
        container.classList.toggle('border-transparent', !isEditing);
        container.classList.toggle('bg-transparent', isEditing);
        container.classList.toggle('bg-white', !isEditing);
    });

    // Toggle the readonly attribute on all inputs
    document.querySelectorAll('input').forEach(input => {
        input.readOnly = !isEditing;
        input.classList.toggle('cursor-text', isEditing); // Change cursor for editable state
    });

    // Show or hide the update button and action buttons
    actionButtons.classList.toggle('hidden', !isEditing);
    editButton.classList.toggle('hidden', isEditing);
}

// Handle the 'Edit Profile' and 'Cancel' button functionality
if (editButton) {
    editButton.addEventListener('click', function() {
        const isEditing = this.textContent === 'Edit Profile';
        toggleEditMode(isEditing);

        // Toggle the button text
        this.textContent = isEditing ? 'Cancel' : 'Edit Profile';
    });
}

// Handle the 'Update Profile' button functionality
if (updateButton) {
    updateButton.addEventListener('click', () => {
        alert('Profile updated!');

        // Set all inputs to read-only after updating
        const inputs = profileForm.querySelectorAll('input');
        inputs.forEach(input => {
            input.setAttribute('readonly', true);
        });

        editButton.textContent = 'Edit Profile'; // Reset button text
        editButton.classList.remove('hidden');
        actionButtons.classList.add('hidden');
    });
}

// Handle the 'Open Form' button functionality
if (openFormButton) {
    openFormButton.addEventListener('click', () => {
        if (addressForm) addressForm.classList.toggle('hidden');
        if (savedAddresses) savedAddresses.classList.toggle('hidden');
    });
}

// Handle clicking on input fields to enable editing
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('click', () => {
        // Check if the form is in edit mode
        if(editButton){
            if (editButton.textContent === 'Edit Profile') {
                editButton.click(); // Trigger the edit button if it's not in edit mode
            }
        }

    });
});


function scrollToSection(sectionId) {
    const target = document.getElementById(sectionId);
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' });
    } else {
      console.error(`No element found with ID: ${sectionId}`);
    }
}


document.addEventListener('DOMContentLoaded', function() {
    // Ensure the form element exists
    const form = document.getElementById('newsletter');
    const newsletterHolder = document.getElementById('newsletterHolder');
    const emailFormDiv = document.getElementById('emailFormDiv');
    const nameForm = document.getElementById('nameForm');
    const responseMessage = document.getElementById('responseMessage');

    if (form && newsletterHolder && emailFormDiv ) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the email input value
            const email = form.querySelector('input[name="email"]').value;

            // Send the POST request using fetch
            fetch(form.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => response.json()) // Parse JSON response
            .then(data => {
                if(data.status === 'success'){
                    emailFormDiv.remove(); // Remove the email form
                    responseMessage.classList.remove('hidden', 'text-red-600');
                    responseMessage.classList.add('text-green-600');
                    responseMessage.textContent = data.message;
                    if(nameForm){
                        nameForm.classList.remove('hidden');
                    }
                }
                else{
                    responseMessage.classList.remove('hidden');
                    responseMessage.classList.add('text-red-600');
                    responseMessage.textContent = data.message;
                }
                
            })
            .catch(error => {
                // Create an error message element
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('text-red-500', 'p-2');
                errorMessage.textContent = 'Something went wrong. Please try again later.';
                
                // Append the error message to the newsletterHolder
                newsletterHolder.appendChild(errorMessage);
            });
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // Handle the name form submission
    const nameForm = document.getElementById('nameDetailsForm');
    const newsletterHolder = document.getElementById('newsletterHolder');

    if (nameForm) {
        nameForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the first and last name input values
            const firstName = nameForm.querySelector('input[name="first_name"]').value;
            const lastName = nameForm.querySelector('input[name="last_name"]').value;

            // Send the POST request using fetch
            fetch(nameForm.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    first_name: firstName,
                    last_name: lastName
                })
            })
            .then(response => response.json()) // Parse JSON response
            .then(data => {
                // Show success or error message
                const message = document.createElement('p');
                if (data.status === 'success') {
                    newsletterHolder.innerHTML = '<h3 class="font-bold text-xl">News Letter</h3>';
                    message.classList.add('text-green-500', 'py-2');
                    message.textContent = data.message;
                } else {
                    message.classList.add('text-red-500', 'py-2');
                    message.textContent = data.message;
                }

                // Append the message to the newsletterHolder
                newsletterHolder.appendChild(message);
            })
            .catch(error => {
                // Show error if the fetch fails
                newsletterHolder.innerHTML = `<div class="text-red-500 p-2">Something went wrong. Please try again later.</div>`;
            });
        });
    }
});