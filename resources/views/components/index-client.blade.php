@props(['clients'])
<section id="clients" class="clients section light-background">
  <div class="container" data-aos="fade-up">
    <div class="scroller-wrapper">
      <div class="d-flex gy-4 scroller">
        @forelse ($clients as $client)
          <a href="{{ $client->url }}">
            <img src="{{ asset('storage/' . $client->image) }}" width="150px" class="d-block mb-2">
          </a>
        @empty
          <p>Clients not available.</p>
        @endforelse
      </div>
    </div>
  </div>
</section>