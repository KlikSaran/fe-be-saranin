@props(['teams'])
<section id="team" class="team section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Tim</h2>
      <p>tim kami</p>
    </div>

    <div class="container">
        <div class="row gy-5">
            @forelse ($teams as $team)
              <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                  <div class="pic">
                    <img src="{{ asset('storage/' . $team->image) }}" height="200px" class="d-block mb-2">
                  </div>
                  <div class="member-info">
                      <h4>{{ $team->name }}</h4>
                      <span>{{ $team->position }}</span>
                      {{-- <div class="social">
                        <a href="{{ $team->twitter }}"><i class="bi bi-twitter-x"></i></a>
                        <a href="{{ $team->facebook }}"><i class="bi bi-facebook"></i></a>
                        <a href="{{ $team->instagram }}"><i class="bi bi-instagram"></i></a>
                        <a href="{{ $team->linkedin }}"><i class="bi bi-linkedin"></i></a>
                      </div> --}}
                  </div>
                </div>
              </div>
            @empty
              <p>Our teams not available</p>
            @endforelse
        </div>
    </div>
</section>
