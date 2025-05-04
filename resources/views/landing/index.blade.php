<!DOCTYPE html>
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html lang="en-US" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="UTF-8"/>
    <title>Booking Core - Ultimate Booking System</title>
    <link rel="icon" type="image/png" href="{{url('icon/favicon.png')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600" rel="stylesheet">
    <link rel="stylesheet" href="{{url('landing')}}/bs/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{url('landing')}}/owlcarousel/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="{{url('landing')}}/css/main.css"/>
    <link rel="icon" type="image/png" href="{{url('images/favicon.png')}}" />
</head>
<body>
{!! setting_item('body_scripts') !!}

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			xfbml            : true,
			version          : 'v3.3'
		});
	};
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<!-- Load Facebook SDK for JavaScript -->

<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="2280007165584589">
</div>

<div class="header parallax">
    <div id="main-menu" class="sticky">
        <div class="container">
            <div class="row">
                <div class="col-xs-3">
                    <h1><a target="_blank" href="{{url('intro')}}"><img src="{{url('images')}}/logo.svg"
                                                                 alt="Booking Core Logo"/></a></h1>
                </div>
                <div class="col-xs-9">
                    <div class="dropdown dropdown-main-menu">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-menu-hamburger"></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="https://www.facebook.com/bookingcore/" target="_blank">Support</a>
                            <a target="_blank" class="dropdown-item" href="http://docs.bookingcore.org">Documentation</a>
                            <a target="_blank" href="{{config('landing.item_url')}}" class="dropdown-item btn-buynow">BUY NOW</a></li>
                        </div>
                    </div>
                    <ul class="menu">
                        <li>
                            <a target="_blank" href="{{config('landing.item_url')}}" class="btn-buynow">BUY NOW</a></li>
                        <li><a target="_blank" href="https://www.facebook.com/bookingcore/">Support</a></li>
                        <li><a target="_blank" href="http://docs.bookingcore.org">Documentation</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row ld-full-height">
            <div class="col-lg-6">
                <h2 class="heading">
                    <span>Ultimate</span>
                    Booking System<br/>
                    based on Laravel
                </h2>
                {{--<p class="desc">Trusted by <span>6000+</span> happy customers</p>--}}
                {{--<p class="desc">Completed OTA Booking System for Hotel, Room, Tour, Car, Rental, Activity likes--}}
                    {{--Booking.com, Agoda.com, Viator.com, Getyourguide.com..</p>--}}
            </div>
            <div class="col-lg-6 hidden-md hidden-sm hidden-xs">
                <img src="{{url('landing/img/header_img.png')}}" class="effectSwing img-rounder"/>
            </div>
        </div>
    </div>
</div>

<div class="full-demo">
    <div class="text-heading">
        <h3>Full Website Demo</h3>
        <p>Easy Demo Importer,<br />all features in all demos can be combined.</p>

    </div>
    <div class="demo-grid">
        <div class="container">
            <div class="demo-tab-wrapper">
                @foreach(config('landing.list_demo') as $demo)
                    <div class="modern-layout item-tab active">
                        @include('landing.view.item')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="demo-plugin">
    <h3>Exclusive  Features</h3>
    <div class="demo-plugin-content">
        <div class="container">
            <div class="row">
                @foreach(config('landing.exclusive_features') as $feature)
                    <div class="col-lg-6 col-md-6">
                        <div class="item">
                            <img src="{{url('landing')}}/{{$feature['thumb']}}" alt="Plugin"/>
                            <div class="plugin-info">
                                <h5>{{$feature['name']}}</h5>
                                <div class="desc">{{$feature['desc']}}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<div class="demo-theme-option">
    @foreach(config('landing.screenshots') as $k=>$screenshot)
        <div class="feature-theme-option feature-services">
            <div class="container">
                <div class="row ld-flex justify-content-center">
                    <div class="col-md-6 col-sm-6 col-left @if($k % 2 == 1) col-img  @endif">
                        @if($k % 2 == 0)
                            <h3>{!! $screenshot['name'] !!}</h3>
                            <div class="desc">{!! $screenshot['desc'] !!}
                            </div>
                        @else
                            <div class="col-pull-left">
                                <img src="{{asset('landing/'.$screenshot['thumb'])}}" class="img-responsive"/>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6 col-right">
                        @if($k % 2 == 1)
                            <h3>{!! $screenshot['name'] !!}</h3>
                            <div class="desc">{!! $screenshot['desc'] !!}
                            </div>
                        @else
                            <div class="col-pull-right">
                                <img src="{{asset('landing/'.$screenshot['thumb'])}}" class="img-responsive"/>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>



<div class="other-feature">
    <h3>Other Features</h3>
    <div class="other-content">
        <div class="container">
            <div class="row">
                @foreach(config('landing.other_features') as $item)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        @if($item['type'] == 'more')
                        <div class="item more">
                            <img src="{{asset('landing/'.$item['thumb'])}}" />
                            <h5>{{$item['name']}}</h5>
                        </div>
                        @else
                        <div class="item">
                            <img src="{{asset('landing/'.$item['thumb'])}}" />
                            <h5>{{$item['name']}}</h5>
                            <p class="desc">{{$item['desc']}}</p>
                        </div>
                        @endif
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="footer">
<!--<img src="<?php /*echo $url . '/img/footer-corrner.png'; */?>" class="footer-corrner"/>-->
    <div class="container">
        <h3>Creating your own Booking<br />System with <span>Aryadsstr</span> is super<br />fast and easy <img src="{{url('landing/img/hand.svg')}}" /></h3>
    </div>
</div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115740936-4"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-115740936-4');
</script>
<script src="{{url('landing')}}/js/jquery.min.js"></script>
<script src="{{url('landing')}}/js/bootstrap.min.js"></script>
<script src="{{url('landing')}}/owlcarousel/owl.carousel.min.js"></script>
<script src="{{url('landing')}}/js/jquery.marquee.min.js"></script>
<script src="{{url('landing')}}/js/scrollreveal.js"></script>
<script src="{{url('landing')}}/js/jquery.matchHeight.js"></script>
<script src="{{url('landing')}}/js/main.js"></script>
</body>
</html>
