@props(['articles'])
<!-- Articles Section -->
<section id="articles" class="articles section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Artikel</h2>
      <p>baca artikel<br></p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
            @forelse ($articles as $article)
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="articles-item">
                        <div class="img">
                            <img src="{{ asset('storage/' . $article->image) }}" style="height: 300px; width: 100%;" class="img-fluid">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-activity"></i>
                            </div>
                            <a href="#articles" class="stretched-link">
                                <h3>{{ $article->title }}</h3>
                            </a>
                            <p>{{ $article->description }}</p>
                        </div>
                    </div>
                </div><!-- End Service Item -->
            @empty
                <div class="col-12">
                    <p>Articles not available</p>
                </div>
            @endforelse
        </div>
    </div>
</section><!-- /Articles Section -->



