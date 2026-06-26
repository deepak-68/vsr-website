  <!--==============================
    About Area
    ============================== -->
  <section class="about-layout3 space">
      <div class="container">
          <div class="row justify-content-center align-items-center">
              <div class="col-lg-9">
                  <div class="title-area mb-60 text-center wow fadeInUp wow-animated" data-wow-delay="0.3s">
                      <div class="title-img">
                          <img src="assets/img/icon/title-logo.png" alt="title logo">
                      </div>
                      <span class="sec-subtitle">
                          {{ $about['sub_title'] ?? 'About Us' }}
                      </span>
                      <h2 class="sec-title">
                          {{ $about['main_title'] ?? 'About Us' }}

                      </h2>
                  </div>
              </div>
          </div>
          <div class="row gy-5 gx-5">
              <div class="col-lg-6">
                  <div class="about-content">
                      <p class="about-text" align="justify">
                          {{ $about['description_1'] ?? '' }}
                      </p>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="about-img">
                      <a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="play-btn popup-video">
                          <i class="fas fa-play"></i>
                      </a>
                      <img src="{{ $about['image'] ?? 'assets/img/about/about-bg-2-1.jpg' }}" alt="about img"
                          class="img1">
                      <div class="img-content">
                          <h2 class="img-title h4"> {{ $about['feature_1_title'] ?? '' }}</h2>
                          <a href="{{ route('about-us') }}" class="vs-btn">Certify Products</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="shape-mockup moving z-index-n1 d-none d-xxl-block" style="right: 9%; bottom: 22%;"><img
              src="assets/img/shep/about-shep-1.png" alt="shapes"></div>
  </section>
