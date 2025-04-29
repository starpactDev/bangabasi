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
                        <span><i class="mdi mdi-chevron-right"></i></span> Homepage
                    </p>
                </div>
                <div>

                </div>
            </div>

			<div class="row gap-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Validation Error:</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="py-4 col-lg-12" >
					@php
						
                        $head = $homepage['subCategorySection']['head'];
                        $description = $homepage['subCategorySection']['description'];
                     
					@endphp
                    
					<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                        <h4 class="pb-4"> kaleidoscopic Section </h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="subCategorySection">
                          
                        </div>
                        <div class="py-2">
                            <label for="head" class="form-label py-2">Head</label>
                            <input type="text" name="subCategorySection.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                        </div>
                        <div class="py-2">
                            <label for="description" class="form-label py-2">Description</label>
                            <input type="text" name="subCategorySection.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                        </div>
                       
                       
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button">Save</button>
                        </div>

					</form>
				</div>
                <div class="py-4 col-lg-12 row" > 
                    <div class="py-4 col-lg-4" >
                        @php
                            $image = $homepage['sub1']['image'];
                            $head = $homepage['sub1']['head'];
                           
                            $redirect = $homepage['sub1']['redirect'];
                        @endphp
                        
                        <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                            <h4 class="pb-4">Sub 1</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="sub1">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 10rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Head</label>
                                <input type="text" name="sub1.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                            </div>
                            
                           
                            <div class="py-2">
                                <label for="redirect" class="form-label py-2">Redirect</label>
                                <input type="text" name="sub1.redirect" value="{{$redirect}}" class="form-control" id="">
                            </div>
                            <div class="py-2">
                                <button type="submit" class="btn btn-primary submit-button">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="py-4 col-lg-4" >
                        @php
                            $image = $homepage['sub2']['image'];
                            $title = $homepage['sub2']['title'];
                           
                            $redirect = $homepage['sub2']['redirect'];
                        @endphp
                        
                        <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                            <h4 class="pb-4">Sub 2</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="sub2">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 10rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Title</label>
                                <input type="text" name="sub2.head" id="head" value="{{$title}}" class="form-control" placeholder="Enter head">
                            </div>
                            
                           
                            <div class="py-2">
                                <label for="redirect" class="form-label py-2">Redirect</label>
                                <input type="text" name="sub2.redirect" value="{{$redirect}}" class="form-control" id="">
                            </div>
                            <div class="py-2">
                                <button type="submit" class="btn btn-primary submit-button">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="py-4 col-lg-4" >
                        @php
                            $image = $homepage['sub3']['image'];
                            $title = $homepage['sub3']['title'];
                           
                            $redirect = $homepage['sub3']['redirect'];
                        @endphp
                        
                        <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                            <h4 class="pb-4">Sub 3</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="sub3">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 10rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Title</label>
                                <input type="text" name="sub3.head" id="head" value="{{$title}}" class="form-control" placeholder="Enter head">
                            </div>
                            
                           
                            <div class="py-2">
                                <label for="redirect" class="form-label py-2">Redirect</label>
                                <input type="text" name="sub3.redirect" value="{{$redirect}}" class="form-control" id="">
                            </div>
                            <div class="py-2">
                                <button type="submit" class="btn btn-primary submit-button">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="py-4 col-lg-4" >
                        @php
                            $image = $homepage['sub4']['image'];
                            $title = $homepage['sub4']['title'];
                           
                            $redirect = $homepage['sub4']['redirect'];
                        @endphp
                        
                        <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                            <h4 class="pb-4">Sub 4</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="sub4">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 10rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Title</label>
                                <input type="text" name="sub4.head" id="head" value="{{$title}}" class="form-control" placeholder="Enter head">
                            </div>
                            
                           
                            <div class="py-2">
                                <label for="redirect" class="form-label py-2">Redirect</label>
                                <input type="text" name="sub4.redirect" value="{{$redirect}}" class="form-control" id="">
                            </div>
                            <div class="py-2">
                                <button type="submit" class="btn btn-primary submit-button">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="py-4 col-lg-4" >
                        @php
                            $image = $homepage['sub5']['image'];
                            $title = $homepage['sub5']['title'];
                           
                            $redirect = $homepage['sub5']['redirect'];
                        @endphp
                        
                        <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                            <h4 class="pb-4">Sub 5</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="sub5">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 10rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Title</label>
                                <input type="text" name="sub5.head" id="head" value="{{$title}}" class="form-control" placeholder="Enter head">
                            </div>
                            
                           
                            <div class="py-2">
                                <label for="redirect" class="form-label py-2">Redirect</label>
                                <input type="text" name="sub5.redirect" value="{{$redirect}}" class="form-control" id="">
                            </div>
                            <div class="py-2">
                                <button type="submit" class="btn btn-primary submit-button">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="py-4 col-lg-4" >
                        @php
                            $image = $homepage['sub6']['image'];
                            $title = $homepage['sub6']['title'];
                           
                            $redirect = $homepage['sub6']['redirect'];
                        @endphp
                        
                        <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                            <h4 class="pb-4">Sub 6</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="sub6">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 10rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Title</label>
                                <input type="text" name="sub6.head" id="head" value="{{$title}}" class="form-control" placeholder="Enter head">
                            </div>
                            
                           
                            <div class="py-2">
                                <label for="redirect" class="form-label py-2">Redirect</label>
                                <input type="text" name="sub6.redirect" value="{{$redirect}}" class="form-control" id="">
                            </div>
                            <div class="py-2">
                                <button type="submit" class="btn btn-primary submit-button">Save</button>
                            </div>
                        </form>
                    </div>
				</div>
                <div class="py-4 col-lg-6" >
					@php
						$image = $homepage['traditionalSectionLeftSide']['image'];
                        $head = $homepage['traditionalSectionLeftSide']['head'];
                        $description = $homepage['traditionalSectionLeftSide']['description'];
                        $button = $homepage['traditionalSectionLeftSide']['button'];
                        $redirect = $homepage['traditionalSectionLeftSide']['redirect'];
					@endphp
                    
					<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
                        <h4 class="pb-4">Traditional Section Left Side</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="traditionalSectionLeftSide">
                            <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 25rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
                        <div class="py-2">
                            <label for="head" class="form-label py-2">Head</label>
                            <input type="text" name="traditionalSectionLeftSide.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                        </div>
                        <div class="py-2">
                            <label for="description" class="form-label py-2">Description</label>
                            <input type="text" name="traditionalSectionLeftSide.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                        </div>
                        <div class="py-2">
                            <label for="button" class="form-label py-2">Button</label>
                            <input type="text" name="traditionalSectionLeftSide.button" id="button" value="{{$button}}" class="form-control" placeholder="Enter button">
                        </div>
                        <div class="py-2">
                            <label for="redirect" class="form-label py-2">Redirect</label>
                            <input type="text" name="traditionalSectionLeftSide.redirect" id="redirect" value="{{$redirect}}" class="form-control" placeholder="Enter redirect">
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button">Save</button>
                        </div>

					</form>
				</div>
				<div class="py-4 col-lg-6" >
					@php
						$image = $homepage['traditionalSectionRightSide']['image'];
                        $head = $homepage['traditionalSectionRightSide']['head'];
                        $description = $homepage['traditionalSectionRightSide']['description'];
                        $button = $homepage['traditionalSectionRightSide']['button'];
                        $redirect = $homepage['traditionalSectionRightSide']['redirect'];
					@endphp
                    
					<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" >
					    <h4 class="pb-4">Traditional Section Right Side</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="traditionalSectionRightSide">
                            <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height : 25rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
                        <div class="py-2">
                            <label for="head" class="form-label py-2">Head</label>
                            <input type="text" name="traditionalSectionRightSide.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                        </div>
                        <div class="py-2">
                            <label for="description" class="form-label py-2">Description</label>
                            <input type="text" name="traditionalSectionRightSide.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                        </div>
                        <div class="py-2">
                            <label for="button" class="form-label py-2">Button</label>
                            <input type="text" name="traditionalSectionRightSide.button" value="{{$button}}" class="form-control" id="">
                        </div>
                        <div class="py-2">
                            <label for="redirect" class="form-label py-2">Redirect</label>
                            <input type="text" name="traditionalSectionRightSide.redirect" value="{{$redirect}}" class="form-control" id="">
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button">Save</button>
                        </div>
					</form>
				</div>
				<div class="col-lg-12 py-4">
					@php
						$image = $homepage['dontMissSectionDashaKarma']['image'];
						$head = $homepage['dontMissSectionDashaKarma']['head'];
						$description = $homepage['dontMissSectionDashaKarma']['description'];
						$button = $homepage['dontMissSectionDashaKarma']['button'];
						$redirect = $homepage['dontMissSectionDashaKarma']['redirect'];
					@endphp
                    
					<form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" style="min-height: 15rem">
                        <h4 class="pb-4">Dont Miss Section - Dasha Karma</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
							<input type="hidden" name="parentKey" value="dontMissSectionDashaKarma">
							<img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; background-color:gray">
							<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
						<div class="py-2">
							<label for="head" class="form-label py-2">Head</label>
							<input type="text" name="dontMissSectionDashaKarma.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
						</div>
						
						<div class="py-2">
							<label for="description" class="form-label py-2">Description</label>
							<input type="text" name="dontMissSectionDashaKarma.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
						</div>
						<div class="py-2">
							<label for="button" class="form-label py-2">Button</label>
							<input type="text" name="dontMissSectionDashaKarma.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">
						</div>
						<div class="py-2">
							<label for="redirect" class="form-label py-2">Redirect</label>
							<input type="text" name="dontMissSectionDashaKarma.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">
						</div>
						<div class="py-2">
							<button type="submit" class="btn btn-primary submit-button">Save</button>
						</div>
					</form>
				</div>
                <div class="col-lg-12 p-4 ">
                    @php
                        $image = $homepage['newestSection']['image'];
                        $head = $homepage['newestSection']['head'];
                        $description = $homepage['newestSection']['description'];
                        $button = $homepage['newestSection']['button'];
                        $redirect = $homepage['newestSection']['redirect'];
                    @endphp
                    <form  class="border rounded shadow-sm form-submit bg-light p-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}">
                        <div class="col-md-12 col-lg-5">
                            <h4 class="pb-4">Newest Section</h4>
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Head</label>
                                <input type="text" name="newestSection.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                            </div>
                            <div class="py-2">
                                <label for="description" class="form-label py-2">Description</label>
                                <input type="text" name="newestSection.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                            </div>
                            <div class="py-2">
                                <label for="button" class="form-label py-2">Button</label>
                                <input type="text" name="newestSection.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">  
                            </div>
                            <div class="py-2">
                                <div class="row align-items-end" >
                                    <div class="col-md-8">
                                        <label for="redirect" class="form-label py-2">Redirect</label>
                                        <input type="text" name="newestSection.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary submit-button px-4">Save</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>    
                        <div class="col-md-12 col-lg-7">
                            
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="newestSection">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 100%; height: 100%; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 py-2">
                    @php
                        $image = $homepage['dontMissSectionMachinery']['image'];
                        $head = $homepage['dontMissSectionMachinery']['head'];
                        $description = $homepage['dontMissSectionMachinery']['description'];
                        $button = $homepage['dontMissSectionMachinery']['button'];
                        $redirect = $homepage['dontMissSectionMachinery']['redirect'];
                    @endphp
                    <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" style="min-height: 15rem">
                        <h4 class="pb-4">Dont Miss Section - Machinery</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="dontMissSectionMachinery">
                            <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
                        <div class="py-2">
                            <label for="head" class="form-label py-2">Head</label>
                            <input type="text" name="dontMissSectionMachinery.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                        </div>
                        
                        <div class="py-2">
                            <label for="description" class="form-label py-2">Description</label>
                            <input type="text" name="dontMissSectionMachinery.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                        </div>
                        <div class="py-2">
                            <label for="button" class="form-label py-2">Button</label>
                            <input type="text" name="dontMissSectionMachinery.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">
                        </div>
                        <div class="py-2">
                            <label for="redirect" class="form-label py-2">Redirect</label>
                            <input type="text" name="dontMissSectionMachinery.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 py-2">
                    @php
                        $image = $homepage['dontMissSectionClothing']['image'];
                        $head = $homepage['dontMissSectionClothing']['head'];
                        $description = $homepage['dontMissSectionClothing']['description'];
                        $button = $homepage['dontMissSectionClothing']['button'];
                        $redirect = $homepage['dontMissSectionClothing']['redirect'];
                    @endphp
                    <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" style="min-height: 15rem">
                        <h4 class="pb-4">Dont Miss Section - Clothing</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="dontMissSectionClothing">
                            <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
                        <div class="py-2">
                            <label for="head" class="form-label py-2">Head</label>
                            <input type="text" name="dontMissSectionClothing.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                        </div>
                        <div class="py-2">
                            <label for="description" class="form-label py-2">Description</label>
                            <input type="text" name="dontMissSectionClothing.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                        </div>
                        <div class="py-2">
                            <label for="button" class="form-label py-2">Button</label>
                            <input type="text" name="dontMissSectionClothing.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">
                        </div>
                        <div class="py-2">
                            <label for="redirect" class="form-label py-2">Redirect</label>
                            <input type="text" name="dontMissSectionClothing.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 py-2">
                    @php
                        $image = $homepage['dontMissSectionFoodItem']['image'];
                        $head = $homepage['dontMissSectionFoodItem']['head'];
                        $description = $homepage['dontMissSectionFoodItem']['description'];
                        $button = $homepage['dontMissSectionFoodItem']['button'];
                        $redirect = $homepage['dontMissSectionFoodItem']['redirect'];
                    @endphp
                    <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" style="min-height: 15rem">
                        <h4 class="pb-4">Dont Miss Section - Food Item</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="dontMissSectionFoodItem">
                            <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
                        <div class="py-2">
                            <label for="head" class="form-label py-2">Head</label>
                            <input type="text" name="dontMissSectionFoodItem.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                        </div>
                        <div class="py-2">
                            <label for="description" class="form-label py-2">Description</label>
                            <input type="text" name="dontMissSectionFoodItem.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                        </div>
                        <div class="py-2">
                            <label for="button" class="form-label py-2">Button</label>
                            <input type="text" name="dontMissSectionFoodItem.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">
                        </div>
                        <div class="py-2">
                            <label for="redirect" class="form-label py-2">Redirect</label>
                            <input type="text" name="dontMissSectionFoodItem.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-8 p-4">
                    @php
                        $image = $homepage['heroSection']['image'];
                        $head = $homepage['heroSection']['head'];
                        $description = $homepage['heroSection']['description'];
                        $button = $homepage['heroSection']['button'];
                        $redirect = $homepage['heroSection']['redirect'];
                    @endphp
                    <form class="border rounded shadow-sm form-submit bg-light p-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}">
                        <div class="col-md-12 col-lg-6">
                            <h4 class="pb-4">Hero Section</h4>
                            <div class="position-relative d-inline-block" style="width: fit-content">
                                <input type="hidden" name="parentKey" value="heroSection">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail" style="object-fit: cover; width: 100%; height: 20rem; background-color: gray;">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Head</label>
                                <input type="text" name="heroSection.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                            </div>
                            <div class="py-2">
                                <label for="description" class="form-label py-2">Description</label>
                                <input type="text" name="heroSection.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                            </div>
                            <div class="py-2">
                                <label for="button" class="form-label py-2">Button</label>
                                <input type="text" name="heroSection.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">
                            </div>
                            <div class="py-2">
                                <div class="row align-items-end">
                                    <div class="col-md-8">
                                        <label for="redirect" class="form-label py-2">Redirect</label>
                                        <input type="text" name="heroSection.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary submit-button px-4">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-lg-4 p-4">
                    @php
                        $image = $homepage['mostWishesSection']['image'];
                    @endphp
                    <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" style="min-height: 15rem">
                        <h4 class="pb-4">Most Wishes Section</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="mostWishesSection">
                            <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style="height:17rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button px-4">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 py-2">
                    @php
                        $image = $homepage['handpickedSection']['image'];
                        $head = $homepage['handpickedSection']['head'];
                        $description = $homepage['handpickedSection']['description'];
                        $button = $homepage['handpickedSection']['button'];
                        $redirect = $homepage['handpickedSection']['redirect'];
                    @endphp
                    <form class="form-submit card bg-light p-4" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}" style="min-height: 15rem">
                        <h4 class="pb-4">Handpicked Section</h4>
                        <div class="position-relative d-inline-block" style="width : fit-content">
                            <input type="hidden" name="parentKey" value="handpickedSection">
                            <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                        </div>
                        <div class="py-2">
                            <label for="head" class="form-label py-2">Head</label>
                            <input type="text" name="handpickedSection.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                        </div>
                        <div class="py-2">
                            <label for="description" class="form-label py-2">Description</label>
                            <input type="text" name="handpickedSection.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                        </div>
                        <div class="py-2">
                            <label for="button" class="form-label py-2">Button</label>
                            <input type="text" name="handpickedSection.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">  
                        </div>
                        <div class="py-2">
                            <label for="redirect" class="form-label py-2">Redirect</label>
                            <input type="text" name="handpickedSection.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary submit-button">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 p-4 ">
                    @php
                        $image = $homepage['heroSideSection']['image'];
                        $head = $homepage['heroSideSection']['head'];
                        $description = $homepage['heroSideSection']['description'];
                        $button = $homepage['heroSideSection']['button'];
                        $redirect = $homepage['heroSideSection']['redirect'];
                    @endphp
                    <form  class="border rounded shadow-sm form-submit bg-light p-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}">
                        <div class="col-md-12 col-lg-8">
                            <h4 class="pb-4">Hero Side Section</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="heroSideSection">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 100%; height: 100%; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Head</label>
                                <input type="text" name="heroSideSection.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                            </div>
                            <div class="py-2">
                                <label for="description" class="form-label py-2">Description</label>
                                <input type="text" name="heroSideSection.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                            </div>
                            <div class="py-2">
                                <label for="button" class="form-label py-2">Button</label>
                                <input type="text" name="heroSideSection.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">  
                            </div>
                            <div class="py-2">
                                <div class="row align-items-end" >
                                    <div class="col-md-8">
                                        <label for="redirect" class="form-label py-2">Redirect</label>
                                        <input type="text" name="heroSideSection.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary submit-button px-4">Save</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 p-4 ">
                    @php
                        $image = $homepage['heroSideSection']['image'];
                        $head = $homepage['heroSideSection']['head'];
                        $description = $homepage['heroSideSection']['description'];
                        $button = $homepage['heroSideSection']['button'];
                        $redirect = $homepage['heroSideSection']['redirect'];
                    @endphp
                    <form  class="border rounded shadow-sm form-submit bg-light p-4 row" method="POST" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}">
                        <div class="col-md-12 col-lg-8">
                            <h4 class="pb-4">Hero Side Section</h4>
                            <div class="position-relative d-inline-block" style="width : fit-content">
                                <input type="hidden" name="parentKey" value="heroSideSection">
                                <img id="uploadedImage-{{$image}}" src="/user/uploads/homepage/{{$image}}" alt="Uploaded Image" class="img-thumbnail " style=" object-fit: cover; width: 100%; height: 100%; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{$image}}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{$image}}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{$image}}')">
                            </div>
                            
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="py-2">
                                <label for="head" class="form-label py-2">Head</label>
                                <input type="text" name="heroSideSection.head" id="head" value="{{$head}}" class="form-control" placeholder="Enter head">
                            </div>
                            <div class="py-2">
                                <label for="description" class="form-label py-2">Description</label>
                                <input type="text" name="heroSideSection.description" id="description" value="{{$description}}" class="form-control" placeholder="Enter description">
                            </div>
                            <div class="py-2">
                                <label for="button" class="form-label py-2">Button</label>
                                <input type="text" name="heroSideSection.button" id="" value="{{$button}}" class="form-control" placeholder="Enter button text">  
                            </div>
                            <div class="py-2">
                                <div class="row align-items-end" >
                                    <div class="col-md-8">
                                        <label for="redirect" class="form-label py-2">Redirect</label>
                                        <input type="text" name="heroSideSection.redirect" id="" value="{{$redirect}}" class="form-control" placeholder="Enter redirect link">  
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary submit-button px-4">Save</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-12 p-4 my-4">
                    <h4 class="mb-3">Manage Marquees</h4>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Validation Error:</strong> {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                
                    {{-- Loop through each marquee --}}
                    @foreach($marquees as $marquee)
                    <form action="{{ route('admin.homepage.update.marquee') }}" method="POST" class="mb-3 marquee-form">
                        @csrf
                        @method('PUT')
                
                        <input type="hidden" name="id" value="{{ $marquee->id }}">
                
                        <div class="row g-2 align-items-start">
                            <div class="col-lg-9 col-md-8 col-12">
                                <input type="text" name="text" class="form-control" value="{{ $marquee->text }}" required>
                            </div>
                
                            <div class="col-lg-3 col-md-4 col-12 d-grid d-md-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100 w-md-auto">Update</button>
                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>
                                              

			</div>
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
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
            console.log(button);
            //  button.disabled = true;
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
