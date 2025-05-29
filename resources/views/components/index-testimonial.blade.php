@props(['testimonies'])

<section id="testimonials" class="testimonials section dark-background">
    <img src="{{ asset('img/testimonials-bg.jpg') }}" class="testimonials-bg" alt="">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper init-swiper">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": "auto",
            "pagination": {
              "el": ".swiper-pagination",
              "type": "bullets",
              "clickable": true
            }
          }
        </script>
        <div class="swiper-wrapper">
          @forelse ($testimonies as $testimony)
            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{ asset('storage/' . $testimony->image) }}" class="testimonial-img" alt="{{ $testimony->name }}">
                <h3>{{ $testimony->name }}</h3>
                {{-- <h4>{{ $testimony->position }}</h4>
                <div class="stars">
                  @for ($i = 0; $i < $testimony->rating; $i++)
                    <i class="bi bi-star-fill"></i>
                  @endfor
                </div> --}}
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>{{ $testimony->comment }}</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div>
          @empty
            <p>Testimonials not available</p>
          @endforelse
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
</section>
