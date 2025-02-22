<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Starpact - Admin Dashboard ">

		<title>Bangabasi-Admin Signin</title>

		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

		<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

		<link rel="stylesheet" href="{{url('/')}}/admin/assets/css/spstyle.css" class="stylesheet">
		<!-- Starpact CSS -->
		<link id="ekka-css" rel="stylesheet" href="{{url('/')}}/admin/assets/css/starpact.css" />

		<!-- FAVICON -->
		<link href="{{url('/')}}/admin/assets/img/bangabasi_favicon.png" rel="shortcut icon" />
	</head>

	<body class="sign-inup" id="body">
		<div class="text-center d-flex align-items-center justify-content-center" style="height : 25vh;">
		</div>
		<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px" style="height : 65vh">
			<div class="row justify-content-center">
				<div class="col-lg-10 col-md-10">
					<div class="card" style="border : 1px solid 1px solid #eae9ef; box-shadow: 0 0 10px 0 #c5c2d1;" >
						<div class="card-header" style="background-color : #bcbdf266; padding: 1.25rem 1rem !important; ">
							<div class="ec-brand">
								<a href="" title="Starpact">
									@if(isset($logos['4']))
										<img class="ec-brand-icon" src="{{ asset('user/uploads/logos/' . $logos['6']->image_path) }}" alt="" style="max-width:180px !important; width : unset"/>
									@endif
								</a>
							</div>
						</div>
						<div class="card-body p-5" id="authContainer">
							<h4 class="text-dark mb-5">Admin Sign In</h4>

                            @if(session('success'))
									<div class="alert alert-success">
										{{ session('success') }}
									</div>
								@endif
                            @if(session('error'))
									<div class="alert alert-danger">
										{{ session('error') }}
									</div>
								@endif
							@if ($errors->any())
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<form method="post" action="{{route('admin_login_submit')}}" autocomplete="off">
								@csrf
								<div class="row">
									<div class="form-group col-md-12 mb-4">
										<input type="email" class="form-control" id="email" name="email" placeholder="Username">

									</div>

									<div class="form-group col-md-12 ">
										<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									</div>

									<div class="col-md-12">

										<div class="d-flex my-2 justify-content-between">
											<!--	<p>
														<a class="text-blue" href="#" id="forgotPassword">Forgot Password?</a>
													</p>
											-->
										</div>

										<button type="submit" class="btn btn-primary btn-block mb-4" style="background-color:#6466e8">Sign In</button>
									</div>
								</div>
								@if(session('logout_message'))
									<div class="alert alert-success">
										{{ session('logout_message') }}
									</div>
								@endif
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>

		<!-- Javascript -->

		<!-- Javascript -->
		<script src="{{ url('/') }}/admin/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
		<script src="{{ url('/') }}/admin/assets/js/bootstrap.bundle.min.js"></script>
		<script src="{{ url('/') }}/admin/assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
		<script src="{{ url('/') }}/admin/assets/plugins/slick/slick.min.js"></script>

		<!-- Ekka Custom -->
		<script src="{{ url('/') }}/admin/assets/js/ekka.js"></script>
		<script>
			const authContainer = document.querySelector('#authContainer')

			document.querySelector('#forgotPassword').addEventListener('click', function(event){
				event.preventDefault()

				const xhr = new XMLHttpRequest()
				xhr.open('GET', '/forgot-password-view', true)
				xhr.setRequestHeader('Content-Type', 'text/html')

				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							authContainer.innerHTML = xhr.responseText
							loadOTPView()
						}
						else{
							console.error('Error fetching the file:', xhr.status, xhr.statusText)
						}
					}
				}
				xhr.send()
			})

            function loadOTPView() {
				document.getElementById('forgotPasswordFrom').addEventListener('submit', function(event) {
					event.preventDefault();

					const formData = new FormData(this);
					const xhr = new XMLHttpRequest();
					const csrfContent = document.querySelector('input[name="_token"]').value

					console.log(formData)
					xhr.open('POST', '/otp-view', true);
					xhr.setRequestHeader('X-CSRF-TOKEN', csrfContent)

					xhr.onload = function() {
						if (xhr.readyState === 4) {
							if (xhr.status === 200) {
								authContainer.innerHTML = xhr.responseText
								loadChangePasswordView()
							} else {
								responseDiv.innerHTML = `<p>Error: ${xhr.statusText}</p>`
								console.error('Error fetching the file:', xhr.status, xhr.statusText)
							}
						}
					}
					xhr.send(formData)
				})
			}

			function loadChangePasswordView(){
				document.getElementById('fillOTPForm').addEventListener('submit', function(event) {
                    event.preventDefault()
					const formData = new FormData(this)
					const xhr = new XMLHttpRequest()
					const csrfContent = document.querySelector('input[name="_token"]').value
					xhr.open('POST', '/change-password', true)

					console.log(formData)
					xhr.setRequestHeader('X-CSRF-TOKEN', csrfContent)
					xhr.onload = function() {
						if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                authContainer.innerHTML = xhr.responseText
								setChangePassword()
                            } else {
                            	authContainer.innerHTML = `<p>Error: ${xhr.statusText}</p>`
                                console.error('Error fetching the file:', xhr.status, xhr.statusText)
                            }
                        }
                    }
					xhr.send(formData)
				})
			}

			function setChangePassword(){
				document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
                    event.preventDefault()

                    const formData = new FormData(this)
                    const xhr = new XMLHttpRequest()
                    const csrfContent = document.querySelector('input[name="_token"]').value
                    xhr.open('POST', '/reset-password', true)

					xhr.setRequestHeader('X-CSRF-TOKEN', csrfContent)
					xhr.onload = function() {
						if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                authContainer.innerHTML = xhr.responseText

                            } else {
                                authContainer.innerHTML = `<p>Error: ${xhr.statusText}</p>`
                                console.error('Error fetching the file:', xhr.status, xhr.statusText)
                            }
                        }
                    }
                    xhr.send(formData)
				})
			}

			function setLspace(){
				const fieldOTP = document.querySelector('#fieldOTP')
				fieldOTP.style.letterSpacing = "3ch"
				console.log('done')
			}


	</body>
</html>
