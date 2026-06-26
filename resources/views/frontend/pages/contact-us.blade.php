@extends('frontend.layout.master')
@section('content')
<!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{url ('assets/img/breadcrumb/breadcrumb.png')}}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
    Contact Area
    ============================== -->
    <section class="contact-layout1 space">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="title-area wow fadeInUp wow-animated" data-wow-delay="0.3s">
                        <span class="sec-subtitle">CONTACT US</span>
                        <h2 class="sec-title">Your Wellness Journey Starts with a Conversation</h2>
                    </div>
                    <div class="vs-comment-form">
                        <div id="respond" class="comment-respond">
                            <div class="form-title">
                                <p class="form-text">Have questions? Our team is here to guide you with the right support for better health.
</p>
                            </div>
                            <form action="mail.php" method="post" class="form-style3 ajax-contact">
                                <div class="row">
                                    <div class="col-12  form-group">
                                        <textarea name="message" class="form-control" placeholder="Message" required=""></textarea>
                                      </div>
                                    <div class="col-md-6 form-group">
                                    <input name="fname" type="text" class="form-control" placeholder="Name" required="">
                                  </div>
                                  <div class="col-6 form-group">
                                    <input name="email" type="email" class="form-control" placeholder="Email Address" required="">
                                  </div>
                                  <div class="col-12 ">
                                    <div class="custom-checkbox notice">
                                        <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">
                                        <label for="wp-comment-cookies-consent"> Save my name, email, and website in this browser for the next time I comment.</label>
                                    </div>
                                </div>
                                  <div class="col-12 form-group">
                                    <button class="vs-btn" type="submit">
                                      Send Message
                                    </button>
                                  </div>
                                </div>
                            </form>
                            <p class="form-messages mb-0 mt-3"></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="contact-left">
                        <div class="auther-inner">
                            <div class="auther-img">
                                <img src="assets/img/about/about-author.png" alt="about">
                            </div>
                            <div class="auther-content">
                                <h6 class="name">Thomas Walkar</h6>
                                <span class="designation">founde - CEO</span>
                                <img src="assets/img/about/contact-signature.png" alt="contact">
                            </div>
                        </div>
                        <div class="team-media">
                            <h2 class="contact-title">Professional Skills</h2>
                            <div class="media-style1">
                                <div class="media-icon"><img src="assets/img/icon/icon-1-1.png" alt="icon"></div>
                                <div class="media-body">
                                    <h3 class="media-title">Phone No:</h3>
                                    <p class="media-info"><a href="tel:{{ $settings['phone1']}}">{{ $settings['phone1'] ?? '9999999999' }}</a></p>
                                </div>
                            </div>
                            <div class="media-style1">
                                <div class="media-icon"><img src="assets/img/icon/icon-1-2.png" alt="icon"></div>
                                <div class="media-body">
                                    <h3 class="media-title">Email Address:</h3>
                                    <p class="media-info"> <a href="mailto:{{ $settings['email'] ?? '' }}" 
       style="word-break: break-all;">
        {{ $settings['email'] ?? 'example@domain.com' }}
    </a></p>
                                </div>
                            </div>
                            <div class="media-style1">
                                <div class="media-icon"><img src="assets/img/icon/icon-1-3.png" alt="icon"></div>
                                <div class="media-body">
                                    <h3 class="media-title">Locatoin:</h3>
                                    <p class="media-info">{{ $settings['location'] ?? 'Default Location' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="map">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d877425.8485629065!2d74.02410421376932!3d30.790160565115244!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e6!4m5!1s0x391964aa569e7355%3A0x8fbd263103a38861!2sPunjab!3m2!1d31.1471305!2d75.34121789999999!4m5!1s0x391791c7acabb8af%3A0xf5bddab4da2c834e!2sDC%20DAV%20SEN%20SEC%20PUBLIC%20SCHOOL%2C%20C27G%2B8MQ%2C%20Freedom%20Fighter%20Rd%2C%20Canal%20Colony%2C%20Fazilka%2C%20Punjab%20152123!3m2!1d30.4132763!2d74.0264679!5e0!3m2!1sen!2sin!4v1777017128182!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <!--==============================
    Faq Area
    ============================== -->
    <section class="faq-layout1 space-bottom">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-12">
                    <div class="title-area text-center wow fadeInUp wow-animated" data-wow-delay="0.3s">
                        <span class="sec-subtitle">Any Question Please?</span>
                        <h2 class="sec-title">Frequently Asked Questions</h2>
                    </div>
                    <div class="accordion-style1">
                        <div class="accordion" id="accordionExample">
                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What is VSR Wellness?
                              </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                               VSR Wellness is a wellness-focused brand offering a range of health and personal care products designed to support everyday well-being.
                              </div>
                            </div>
                          </div>
                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Are your products safe to use?
                              </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                  Yes, our products are developed with carefully selected ingredients and follow quality standards to ensure safety and reliability.

                                </div>
                            </div>
                          </div>
                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What kind of products do you offer?

                              </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    We offer nutraceutical supplements and personal care products aimed at supporting overall health, energy, and lifestyle needs.

                                </div>
                            </div>
                          </div>
                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Are your products suitable for everyone?

                              </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Our products are generally designed for adults. However, individuals with medical conditions, pregnant or nursing women should consult a healthcare professional before use.

                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </section>
@endsection