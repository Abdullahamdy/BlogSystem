@extends('layouts.app')

@section('title', 'Our awesome home page title')
@section('maincontent')
    <!-- BANNER -->
    <section class="banner_sec">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="row">

                        @forelse ($categories as $category)
                            <div class="col-12 col-md-4 col-lg-4">
                                <a href="">
                                    <div class="banner_box">
                                        <i class="fab fa-laravel"></i>
                                        <h3 class="banner_box_h3">{{ $category->categoryName }}</h3>
                                        {{-- <p>The Toptal Blog is the top hub for developers.</p> --}}
                                    </div>
                                </a>
                            </div>
                        @empty
                        @endforelse



                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BANNER -->

    <!-- BODY -->
    <div class="home_body">
        <div class="container">
            <div class="latest_post">
                <div class="latest_post_top">
                    <h1 class="latest_post_h1 brdr_line">Latest Blog</h1>
                </div>
                <div class="row">
                    @forelse ($blogs as $blog)
                    <div class="col-12 col-md-6 col-lg-4">
                        <a href="/blog/{{ $blog->slug }}">
                            <div class="home_card">
                                <div class="home_card_top">
                                    <img src="img/card3.jpg" alt="image">
                                </div>
                                <div class="home_card_bottom">
                                    <div class="home_card_bottom_text">
                                        <ul class="home_card_bottom_text_ul">
                                            @if($blog && count($blog->cat) > 0 )
                                            @forelse ($blog->cat as $blogcategory)
                                            <li>
                                                <a href="blog_post.html">{{ $blogcategory->categoryName }}</a>
                                                <span><i class="fas fa-angle-right"></i></span>
                                            </li>
                                            @empty

                                            @endforelse
                                            @endif
                                        </ul>
                                        <a href="">
                                            <h2 class="home_card_h2">{{ $blog->title }}</h2>
                                        </a>
                                        <p class="post_p">
                                            {{ $blog->post_excerpt }}
                                        </p>
                                        <div class="home_card_bottom_tym">
                                            <div class="home_card_btm_left">
                                                <img src="img/man1.jpg" alt="image">
                                            </div>
                                            <div class="home_card_btm_r8">
                                                <a href="contact_me.html">
                                                    <p class="author_name">{{ $blog->user->fullName }}</p>
                                                </a>
                                                <ul class="home_card_btm_r8_ul">
                                                    <li>Dec 4, 2019</li>
                                                    <li><span class="dot"></span>3 Min Read</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                @endforelse


                </div>

              <div class="text-center">
                <a href="/allblogs"><button class="btn btn-primary"> All Blogs</button></a>
              </div>
            </div>
        </div>
        <!-- PAGINATION -->
        
        <!-- PAGINATION -->
    </div>
    <!-- BODY -->

@endsection
