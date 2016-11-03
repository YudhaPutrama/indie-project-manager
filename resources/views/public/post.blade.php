@extends('public.public')
@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="post-snippet mb64">
						<img class="mb24" alt="Post Image" src="{{ Config::get('image.dir.post').$post['image'] }}">
						<div class="post-title">
							<span class="label">{{ (new \Carbon\Carbon($post['created_ar']))->diffForHumans() }}</span>
							<h4 class="inline-block">{{ $post['title'] }}</h4>
						</div>
						<ul class="post-meta">
							<li>
								<i class="ti-user"></i>
								<span>Written by
									<a href="#">{{ $post->user['fullname'] }}</a>
								</span>
							</li>
							<li>
								<i class="ti-tag"></i>
								<span>Tagged as
									@foreach($post['tags'] as $tag)<a href="#">{{ $tag['name'] }}</a>@endforeach
								</span>
							</li>
						</ul>
						<hr>
						<p class="lead">
							{{ $post['summary'] }}
						</p>
						<p>
							{{ $post['body'] }}
						</p>
						{{--<blockquote>--}}
							{{----}}
						{{--</blockquote>--}}
					</div>
					<hr>
				</div>

			</div>

		</div>

	</section>
@endsection