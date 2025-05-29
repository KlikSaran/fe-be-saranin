@props(['searchServices' => [], 'searchQuery' => []])
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <h2>Search Results for "{{ $searchQuery }}"</h2>

    @if($searchServices->count() > 0)
        @foreach($searchServices as $service)
            <div class="portfolio-info mb-3" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('service.show', $service->id) }}" class="strecthed-link">
                    <h5>{{ $service->name }}</h5>
                    <p class="card-text text-black">{{ $service->title }}</p>
                </a>
            </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $searchServices->appends(['query' => $searchQuery])->links() }}
        </div>
    @else
        <div class="alert alert-info">
            No services found matching your search criteria.
        </div>
    @endif
</div>