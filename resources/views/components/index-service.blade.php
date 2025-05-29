@props(['services'])
<!-- Services 2 Section -->
<section id="services-2" class="services-2 section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Layanan</h2>
      <p>layanan kami</p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">
        @forelse ($services as $service)
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item d-flex position-relative h-100">
            <i class="bi bi-briefcase icon flex-shrink-0"></i>
            <div>
              <h4 class="title"><a href="#" class="stretched-link">{{ $service->name }}</a></h4>
              <p class="description">{{ $service->description }}
              </p>
            </div>
          </div>
        </div><!-- End Service Item -->
        @empty
          <p>Service is not available</p>
        @endforelse
      </div>

    </div>

  </section><!-- /Services 2 Section -->