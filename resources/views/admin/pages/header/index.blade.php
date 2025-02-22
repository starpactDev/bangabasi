@extends('superuser.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .text-danger {
            color: red !important;
        }
    </style>
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Homepage</h1>
                    <p class="breadcrumbs"><span><a href="">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span> Header
                    </p>
                </div>
                <div>

                </div>
            </div>

			<div class="row gap-4">
				<div class="row col-lg-12 gap-x-4">
					<div class="py-4 col-lg-4" >

						@php
							$image = $header['secondRow']['clothing']['stickerOne']['image'];
							$subCategory = $header['secondRow']['clothing']['stickerOne']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Clothing Sticker One </h4>
							<div class="position-relative d-inline-block" style="width : fit-content">
								<input type="hidden" name="parentKey" value="clothing.stickerOne">
							
							</div>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="clothing.stickerOne.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
						
						
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>

						</form>
					</div>

					<!-- Sticker Two -->
					<div class="py-4 col-lg-4" >
						@php
							$image = $header['secondRow']['clothing']['stickerTwo']['image'];
							$subCategory = $header['secondRow']['clothing']['stickerTwo']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Clothing Sticker Two </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="clothing.stickerTwo">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="clothing.stickerTwo.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Three -->
					<div class="py-4 col-lg-4" >
						@php
							$image = $header['secondRow']['clothing']['stickerThree']['image'];
							$subCategory = $header['secondRow']['clothing']['stickerThree']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Clothing Sticker Three </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="clothing.stickerThree">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="clothing.stickerThree.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Four -->
					<div class="py-4 col-lg-4" >
						@php
							$image = $header['secondRow']['clothing']['stickerFour']['image'];
							$subCategory = $header['secondRow']['clothing']['stickerFour']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Clothing Sticker Four </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="clothing.stickerFour">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="clothing.stickerFour.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Five -->
					<div class="py-4 col-lg-4" >
						@php
							$image = $header['secondRow']['clothing']['stickerFive']['image'];
							$subCategory = $header['secondRow']['clothing']['stickerFive']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Clothing Sticker Five </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="clothing.stickerFive">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="clothing.stickerFive.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Six -->
					<div class="py-4 col-lg-4" >
						@php
							$image = $header['secondRow']['clothing']['stickerSix']['image'];
							$subCategory = $header['secondRow']['clothing']['stickerSix']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Clothing Sticker Six </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="clothing.stickerSix">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="clothing.stickerSix.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>
				</div>
				<div class="row col-lg-12 gap-x-4">
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['foodItem']['stickerOne']['image'];
							$subCategory = $header['secondRow']['foodItem']['stickerOne']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Food Item Sticker One </h4>
							<div class="position-relative d-inline-block" style="width : fit-content">
								<input type="hidden" name="parentKey" value="foodItem.stickerOne">
							
							</div>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="foodItem.stickerOne.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>


							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>

						</form>
					</div>

					<!-- Sticker Two -->
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['foodItem']['stickerTwo']['image'];
							$subCategory = $header['secondRow']['foodItem']['stickerTwo']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Food Item Sticker Two </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="foodItem.stickerTwo">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="foodItem.stickerTwo.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Three -->
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['foodItem']['stickerThree']['image'];
							$subCategory = $header['secondRow']['foodItem']['stickerThree']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Food Item Sticker Three </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="foodItem.stickerThree">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="foodItem.stickerThree.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Four -->
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['foodItem']['stickerFour']['image'];
							$subCategory = $header['secondRow']['foodItem']['stickerFour']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Food Item Sticker Four </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="foodItem.stickerFour">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="foodItem.stickerFour.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>
				</div>
				<div class="row col-lg-12 gap-x-4">
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['dashaKarma']['stickerOne']['image'];
							$subCategory = $header['secondRow']['dashaKarma']['stickerOne']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Dasha Karma Sticker One </h4>
							<div class="position-relative d-inline-block" style="width : fit-content">
								<input type="hidden" name="parentKey" value="dashaKarma.stickerOne">
							
							</div>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="dashaKarma.stickerOne.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Two -->
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['dashaKarma']['stickerTwo']['image'];
							$subCategory = $header['secondRow']['dashaKarma']['stickerTwo']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Dasha Karma Sticker Two </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="dashaKarma.stickerTwo">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="dashaKarma.stickerTwo.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Three -->
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['dashaKarma']['stickerThree']['image'];
							$subCategory = $header['secondRow']['dashaKarma']['stickerThree']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Dasha Karma Sticker Three </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="dashaKarma.stickerThree">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="dashaKarma.stickerThree.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>

					<!-- Sticker Four -->
					<div class="py-4 col-lg-3" >
						@php
							$image = $header['secondRow']['dashaKarma']['stickerFour']['image'];
							$subCategory = $header['secondRow']['dashaKarma']['stickerFour']['subCategory'];
						@endphp
						<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4"> Dasha Karma Sticker Four </h4>
							<div class="position-relative d-inline-block mx-auto" style="width : fit-content">
								<input type="hidden" name="parentKey" value="dashaKarma.stickerFour">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="dashaKarma.stickerFour.subCategory" id="head" value="{{$subCategory}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>
				</div>
				
				<div class="row gap-x-4">
					<div class="col-lg-7 p-4">
						@php
							$image = $header['secondRow']['handCrafts']['bannerOne']['image'];
							$head = $header['secondRow']['handCrafts']['bannerOne']['head'];
							$button = $header['secondRow']['handCrafts']['bannerOne']['button'];
							$redirect = $header['secondRow']['handCrafts']['bannerOne']['redirect'];
						@endphp
						<form class="border rounded shadow-sm form-submit bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4">Handcrafts Banner One</h4>
							<div class="position-relative d-inline-block" style="width : fit-content">
								<input type="hidden" name="parentKey" value="handCrafts.bannerOne">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail" style="height: 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="handCrafts.bannerOne.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<label for="button" class="form-label py-2">Button</label>
								<input type="text" name="handCrafts.bannerOne.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
							</div>
							<div class="py-2">
								<label for="redirect" class="form-label py-2">Redirect</label>
								<input type="text" name="handCrafts.bannerOne.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>
					<div class="col-lg-5 p-4">
						@php
							$image = $header['secondRow']['handCrafts']['bannerTwo']['image'];
							$head = $header['secondRow']['handCrafts']['bannerTwo']['head'];
							$button = $header['secondRow']['handCrafts']['bannerTwo']['button'];
							$redirect = $header['secondRow']['handCrafts']['bannerTwo']['redirect'];
						@endphp
						<form class="border rounded shadow-sm form-submit bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}" >
							<h4 class="pb-4">Handcrafts Banner Two</h4>
							<div class="position-relative d-inline-block" style="width : fit-content">
								<input type="hidden" name="parentKey" value="handCrafts.bannerTwo">
								<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail" style="height: 9rem; object-fit: cover; background-color:gray">
								<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
									Select
								</button>
								<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
							</div>
							<div class="py-2">
								<label for="head" class="form-label py-2">Head</label>
								<input type="text" name="handCrafts.bannerTwo.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
							</div>
							<div class="py-2">
								<label for="button" class="form-label py-2">Button</label>
								<input type="text" name="handCrafts.bannerTwo.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
							</div>
							<div class="py-2">
								<label for="redirect" class="form-label py-2">Redirect</label>
								<input type="text" name="handCrafts.bannerTwo.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
							</div>
							<div class="py-2">
								<button type="submit" class="btn btn-primary submit-button">Save</button>
							</div>
						</form>
					</div>
				</div>
				<div class="row gap-x-4 p-4">
					@php
                        $image = $header['secondRow']['comboOffer']['bannerOne']['image'];
                        $head = $header['secondRow']['comboOffer']['bannerOne']['head'];
                        $button = $header['secondRow']['comboOffer']['bannerOne']['button'];
                        $redirect = $header['secondRow']['comboOffer']['bannerOne']['redirect'];
                    @endphp
                    <form  class="border rounded shadow-sm form-submit bg-light p-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
                        <div class="col-md-12 col-lg-5">
                            <h4 class="pb-4">Combo Offer</h4>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Head</label>
                                <input type="text" name="comboOffer.bannerOne.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                            </div>
                            <div class="py-2">
                                <label for="button" class="form-label py-2">Button</label>
                                <input type="text" name="comboOffer.bannerOne.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
                            </div>
                            <div class="py-2">
                                <div class="row align-items-end" >
                                    <div class="col-md-8">
                                        <label for="redirect" class="form-label py-2">Redirect</label>
                                        <input type="text" name="comboOffer.bannerOne.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary submit-button px-4">Save</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>    
                        <div class="col-md-12 col-lg-7">
                            
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="comboOffer.bannerOne">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                        </div>
                    </form>
				</div>
				<div class="row gap-x-4">
					<div class="col-lg-6 p-4">
						@php
							$image = $header['secondRow']['comboOffer']['bannerTwo']['image'];
							$head = $header['secondRow']['comboOffer']['bannerOne']['head'];
							$button = $header['secondRow']['comboOffer']['bannerOne']['button'];
							$redirect = $header['secondRow']['comboOffer']['bannerOne']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Combo Offer</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="comboOffer.bannerTwo.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<label for="button" class="form-label py-2">Button</label>
									<input type="text" name="comboOffer.bannerTwo.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="comboOffer.bannerTwo.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block" style="width : fit-content">
									<input type="hidden" name="parentKey" value="comboOffer.bannerTwo">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-6 py-4">
						@php
							$image = $header['secondRow']['comboOffer']['bannerThree']['image'];
							$head = $header['secondRow']['comboOffer']['bannerOne']['head'];
							$button = $header['secondRow']['comboOffer']['bannerOne']['button'];
							$redirect = $header['secondRow']['comboOffer']['bannerOne']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Combo Offer</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="comboOffer.bannerThree.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<label for="button" class="form-label py-2">Button</label>
									<input type="text" name="comboOffer.bannerThree.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="comboOffer.bannerThree.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block" style="width : fit-content">
									<input type="hidden" name="parentKey" value="comboOffer.bannerThree">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row ">
					<div class="col-lg-6 p-4">
						@php
							$image = $header['secondRow']['machinery']['bannerOne']['image'];
							$head = $header['secondRow']['machinery']['bannerOne']['head'];
							$button = $header['secondRow']['machinery']['bannerOne']['button'];
							$redirect = $header['secondRow']['machinery']['bannerOne']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Machinery</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="machinery.bannerOne.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<label for="button" class="form-label py-2">Button</label>
									<input type="text" name="machinery.bannerOne.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="machinery.bannerOne.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block text-end" style="width : fit-content">
									<input type="hidden" name="parentKey" value="machinery.bannerOne">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-6 p-4">
						@php
							$image = $header['secondRow']['machinery']['bannerTwo']['image'];
							$head = $header['secondRow']['machinery']['bannerTwo']['head'];
							$button = $header['secondRow']['machinery']['bannerTwo']['button'];
							$redirect = $header['secondRow']['machinery']['bannerTwo']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Machinery</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="machinery.bannerTwo.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<label for="button" class="form-label py-2">Button</label>
									<input type="text" name="machinery.bannerTwo.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="machinery.bannerTwo.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block text-end" style="width : fit-content">
									<input type="hidden" name="parentKey" value="machinery.bannerTwo">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-6 p-4">
						@php
							$image = $header['secondRow']['machinery']['bannerThree']['image'];
							$head = $header['secondRow']['machinery']['bannerThree']['head'];
							$button = $header['secondRow']['machinery']['bannerThree']['button'];
							$redirect = $header['secondRow']['machinery']['bannerThree']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Machinery</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="machinery.bannerThree.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<label for="button" class="form-label py-2">Button</label>
									<input type="text" name="machinery.bannerThree.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="machinery.bannerThree.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block text-end" style="width : fit-content">
									<input type="hidden" name="parentKey" value="machinery.bannerThree">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-6 p-4">
						@php
							$image = $header['secondRow']['machinery']['bannerFour']['image'];
							$head = $header['secondRow']['machinery']['bannerFour']['head'];
							$button = $header['secondRow']['machinery']['bannerFour']['button'];
							$redirect = $header['secondRow']['machinery']['bannerFour']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Machinery</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="machinery.bannerFour.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<label for="button" class="form-label py-2">Button</label>
									<input type="text" name="machinery.bannerFour.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button text">  
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="machinery.bannerFour.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block text-end" style="width : fit-content">
									<input type="hidden" name="parentKey" value="machinery.bannerFour">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						@php
							$image = $header['secondRow']['electronics']['bannerOne']['image'];
							$head = $header['secondRow']['electronics']['bannerOne']['head'];
							$redirect = $header['secondRow']['electronics']['bannerOne']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Electronics</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="electronics.bannerOne.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="electronics.bannerOne.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block text-end" style="width : fit-content">
									<input type="hidden" name="parentKey" value="electronics.bannerOne">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-4">
						@php
							$image = $header['secondRow']['electronics']['bannerTwo']['image'];
							$head = $header['secondRow']['electronics']['bannerTwo']['head'];
							$redirect = $header['secondRow']['electronics']['bannerTwo']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Electronics</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="electronics.bannerTwo.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="electronics.bannerTwo.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block text-end" style="width : fit-content">
									<input type="hidden" name="parentKey" value="electronics.bannerTwo">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-4">
						@php
							$image = $header['secondRow']['electronics']['bannerThree']['image'];
							$head = $header['secondRow']['electronics']['bannerThree']['head'];
							$redirect = $header['secondRow']['electronics']['bannerThree']['redirect'];
						@endphp
						<form  class="border rounded shadow-sm form-submit bg-light py-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.header.update') }}">
							<div class="col-md-12 col-lg-5">
								<h4 class="pb-4">Electronics</h4>
								<div class="py-2">
									<label for="head" class="form-label py-2">Head</label>
									<input type="text" name="electronics.bannerThree.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
								</div>
								<div class="py-2">
									<div class="row align-items-end" >
										<div class="col-md-8">
											<label for="redirect" class="form-label py-2">Redirect</label>
											<input type="text" name="electronics.bannerThree.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary submit-button px-4">Save</button>
										</div>
									</div>
									
								</div>
							</div>    
							<div class="col-md-12 col-lg-7">
								
								<div class="position-relative d-inline-block text-end" style="width : fit-content">
									<input type="hidden" name="parentKey" value="electronics.bannerThree">
									<img id="uploadedImage-{{$image}}" src="/user/uploads/header/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 80%; height: 100%; background-color:gray">
									<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
										Select
									</button>
									<input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

@endsection
@push('script')
<script id="interactiveImage">
    function previewImage(event, targetId) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById(targetId);
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<script>
    document.body.addEventListener('submit', function (e) {
        if(e.target.classList.contains('form-submit')){
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const button = form.querySelector('.submit-button');

            if (button) {
                button.classList.remove('btn-primary');
                button.classList.add('btn-secondary');
                button.textContent = 'Submitting...'; // Change button text to "Submitting..."
            }
            //console.log(formData);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
                })
            .then(response => response.json())
            .then(data => {
                if (button) {
                    button.classList.remove('btn-secondary');
                    button.classList.add('btn-success');
                    button.innerHTML = 'Submited'; // Change the button text back
                    button.disabled = true;

					resetButtonState(button);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (button) {
                    button.classList.remove('btn-secondary');
                    button.classList.add('btn-danger');
                    button.innerHTML = 'Error'; // Reset button text
                    button.disabled = true;

					resetButtonState(button);
                }
            });
        }
    });
	// Function to reset button to its initial state
	function resetButtonState(button) {
		setTimeout(() => {
			if (button) {
				button.disabled = false;
				button.classList.remove('btn-secondary', 'btn-success', 'btn-danger');
				button.classList.add('btn-primary'); // Reset to initial button class
				button.textContent = 'Submit'; // Reset to initial button text
			}
		}, 5000); // 5 seconds timer
	}
</script>
@endpush