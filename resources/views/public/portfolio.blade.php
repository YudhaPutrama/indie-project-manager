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
						<img alt="image" class="background-image" src="{{ Config::get('image.dir.postThumb').$post['image'] }}">
						<div class="hover-state">
							<a href="{{ route('post-public',['post'=>$post]) }}">
								<h4 class="uppercase mb8">{{ $post['title'] }}</h4>
								<h6 class="uppercase">{{ $post->category['name'] }}</h6>
							</a>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</section><a id="testimonial" class="in-page-link"></a>
@endsection