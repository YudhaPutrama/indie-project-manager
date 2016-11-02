@extends('public.public')
@section('content')
	<section class="projects">
		<div class="container">
			<div class="masonry-loader">
				<div class="col-sm-12 text-center">
					<div class="spinner"></div>
				</div>
			</div>
			@foreach(\App\Post::all()->take('12') as $post)
			<div class="row masonry masonryFlyIn">
				<div class="masonry-item project col-sm-4" data-filter="People">
					<div class="image-tile hover-tile text-center">
						<img alt="image" class="background-image" src="img/home17.jpg">
						<div class="hover-state">
							<a href="#">
								<h4 class="uppercase mb8">Office Space</h4>
								<h6 class="uppercase">Technology / Photography</h6>
							</a>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</section><a id="testimonial" class="in-page-link"></a>
@endsection