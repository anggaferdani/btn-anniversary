@extends('frontend.templates.pages')
@section('title', 'Home')
@section('content')
<div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('eventtalk/images/bg_1.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
                data-scrollax-parent="true">
                <div class="col-xl-10 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                    <h1 class="mb-4 text-xl" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"> 
                        <strong>BTN</strong><br>
                        <span>ANNIVERSARY 2024</span>
                    </h1>
                    <p class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">October 15,
                        2024. Jakarta, Indonesia</p>
                    <div id="timer" class="d-flex mb-3">
                        <div class="time" id="days"></div>
                        <div class="time pl-4" id="hours"></div>
                        <div class="time pl-4" id="minutes"></div>
                        <div class="time pl-4" id="seconds"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section event-details-section bg-light py-5" id="detailacara">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-10 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 event-details d-block text-center p-4">
                        <div class="media-body">
                            <h2 class="heading mb-4 text-primary font-weight-bold">BTN Anniversary 2024</h2>
                            <p class="event-date mb-2"><strong>Date:</strong> October 15, 2024</p>
                            <p class="event-location mb-2"><strong>Location:</strong> Grand Hall, Jakarta, Indonesia</p>
                            <p class="event-description mb-4">
                                Join us for a grand celebration as we commemorate BTN's journey and achievements! The BTN Anniversary promises an evening of joy, inspiration, and vibrant festivities.
                            </p>
                            
                            <h4 class="subheading mb-3 text-success font-weight-bold">Highlights of the Event</h4>
                            <ul class="highlights-list mb-4 list-unstyled">
                                <li><strong>Gala Dinner:</strong> A delightful feast featuring gourmet cuisine.</li>
                                <li><strong>Award Ceremony:</strong> Recognizing outstanding contributions from our community.</li>
                                <li><strong>Live Performances:</strong> Enjoy captivating performances by renowned artists.</li>
                                <li><strong>Guest Speakers:</strong> Insightful talks from leading industry figures.</li>
                                <li><strong>Networking Opportunities:</strong> Connect with peers and industry leaders.</li>
                            </ul>
    
                            <h4 class="subheading mb-3 text-warning font-weight-bold">Special Features</h4>
                            <p>
                                Experience an engaging Event atmosphere with:
                            </p>
                            <ul class="features-list mb-4 list-unstyled">
                                <li><strong>Photo Booths:</strong> Capture memorable moments with colleagues.</li>
                                <li><strong>Live Polls:</strong> Engage in discussions throughout the event.</li>
                                <li><strong>Exhibition Area:</strong> Explore innovations from BTN and partners.</li>
                            </ul>
                            
                            <h4 class="subheading mb-3 text-danger font-weight-bold">Registration Information</h4>
                            <p>
                                Reserve your spot for this exceptional evening! Register by <strong>Oktober 10, 2024</strong>. 
                                For details and registration, please visit our <a href="#registration" class="text-info">registration page</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="ftco-counter img" id="section-counter">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-6 d-flex">
                    <div class="img d-flex align-self-stretch" style="background-image:url({{ asset('eventtalk/images/about.jpg') }});"></div>
                </div>
                <div class="col-md-6 pl-md-5 py-5">
                    <div class="row justify-content-start pb-3">
                        <div class="col-md-12 heading-section ftco-animate">
                            <span class="subheading">Fun Facts</span>
                            <h2 class="mb-4"><span>Fun</span> Facts</h2>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center py-4 bg-light mb-4">
                                <div class="text">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="flaticon-guest"></span>
                                    </div>
                                    <strong class="number" data-number="30">0</strong>
                                    <span>Speakers</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center py-4 bg-light mb-4">
                                <div class="text">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="flaticon-handshake"></span>
                                    </div>
                                    <strong class="number" data-number="200">0</strong>
                                    <span>Sponsor</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center py-4 bg-light mb-4">
                                <div class="text">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="flaticon-chair"></span>
                                    </div>
                                    <strong class="number" data-number="2500">0</strong>
                                    <span>Total Seats</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center py-4 bg-light mb-4">
                                <div class="text">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="flaticon-idea"></span>
                                    </div>
                                    <strong class="number" data-number="40">0</strong>
                                    <span>Topics</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <span class="subheading">Speaker</span>
                    <h2 class="mb-4"><span>Our</span> Speakers</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="carousel-testimony owl-carousel">
                        <div class="item">
                            <div class="speaker">
                                <img src="{{ asset('eventtalk/images/speaker-1.jpg') }}" class="img-fluid" alt="Colorlib HTML5 Template">
                                <div class="text text-center py-3">
                                    <h3>John Adams</h3>
                                    <span class="position">Web Developer</span>
                                    <ul class="ftco-social mt-3">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="speaker">
                                <img src="{{ asset('eventtalk/images/speaker-2.jpg') }}" class="img-fluid" alt="Colorlib HTML5 Template">
                                <div class="text text-center py-3">
                                    <h3>Paul George</h3>
                                    <span class="position">Web Developer</span>
                                    <ul class="ftco-social mt-3">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="speaker">
                                <img src="{{ asset('eventtalk/images/speaker-3.jpg') }}" class="img-fluid" alt="Colorlib HTML5 Template">
                                <div class="text text-center py-3">
                                    <h3>James Smith</h3>
                                    <span class="position">Web Developer</span>
                                    <ul class="ftco-social mt-3">
                                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                                        <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a>
                                        </li>
                                        <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="ftco-section bg-light" id="jadwalacara">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <span class="subheading">Schedule</span>
                    <h2 class="mb-4"><span>Event</span> Schedule</h2>
                </div>
            </div>
            <div class="ftco-search">
                <div class="row">
                    <div class="col-md-12 nav-link-wrap">
                        <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link ftco-animate active" id="v-pills-1-tab" data-toggle="pill"
                                href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Day 01
                                <span>21 Dec. 2019</span></a>

                            <a class="nav-link ftco-animate" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2"
                                role="tab" aria-controls="v-pills-2" aria-selected="false">Day 02 <span>22 Dec.
                                    2019</span></a>

                            <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3"
                                role="tab" aria-controls="v-pills-3" aria-selected="false">Day 03 <span>23 Dec.
                                    2019</span></a>

                            <a class="nav-link ftco-animate" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4"
                                role="tab" aria-controls="v-pills-4" aria-selected="false">Day 04 <span>24 Dec.
                                    2019</span></a>

                        </div>
                    </div>
                    <div class="col-md-12 tab-wrap">

                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel"
                                aria-labelledby="day-1-tab">
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_1.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Introduction to Wordpress 5.0</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_2.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Best Practices For Programming WordPress</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_3.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Web Performance For Third Party Scripts</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-2" role="tabpanel"
                                aria-labelledby="v-pills-day-2-tab">
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_1.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Introduction to Wordpress 5.0</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_2.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Best Practices For Programming WordPress</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_3.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Web Performance For Third Party Scripts</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-3" role="tabpanel"
                                aria-labelledby="v-pills-day-3-tab">
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_1.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Introduction to Wordpress 5.0</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_2.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Best Practices For Programming WordPress</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_3.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Web Performance For Third Party Scripts</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-4" role="tabpanel"
                                aria-labelledby="v-pills-day-4-tab">
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_1.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Introduction to Wordpress 5.0</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_2.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Best Practices For Programming WordPress</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                                <div class="speaker-wrap ftco-animate d-flex">
                                    <div class="img speaker-img" style="background-image: url({{ asset('eventtalk/images/person_3.jpg') }});">
                                    </div>
                                    <div class="text pl-md-5">
                                        <span class="time">08: - 10:00</span>
                                        <h2><a href="#">Web Performance For Third Party Scripts</a></h2>
                                        <p>A small river named Duden flows by their place and supplies it with the
                                            necessary regelialia. It is a paradisematic country, in which roasted parts
                                            of sentences fly into your mouth.</p>
                                        <h3 class="speaker-name">&mdash; <a href="#">Brett Morgan</a> <span
                                                class="position">Founder of Wordpress</span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-gallery">
        <div class="container-wrap">
            <div class="row no-gutters">
                <div class="col-md-3 ftco-animate">
                    <a href="images/image_1.jpg" class="gallery image-popup img d-flex align-items-center"
                        style="background-image: url({{ asset('eventtalk/images/image_1.jpg') }});">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 ftco-animate">
                    <a href="images/image_2.jpg" class="gallery image-popup img d-flex align-items-center"
                        style="background-image: url({{ asset('eventtalk/images/image_2.jpg') }});">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 ftco-animate">
                    <a href="{{ asset('eventtalk/images/image_3.jpg') }}" class="gallery image-popup img d-flex align-items-center"
                        style="background-image: url({{ asset('eventtalk/images/image_3.jpg') }});">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 ftco-animate">
                    <a href="{{ asset('eventtalk/images/image_4.jpg') }}" class="gallery image-popup img d-flex align-items-center"
                        style="background-image: url({{ asset('eventtalk/images/image_4.jpg') }});">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection