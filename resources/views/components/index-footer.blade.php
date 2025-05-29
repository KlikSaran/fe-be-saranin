<div class="container footer-top">
    <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
            <a href="/" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="{{ asset('img/craetive-logo.png') }}" alt="creative logo">
            </a>
            @forelse ($contacts as $contact)
                <div class="footer-contact pt-3">
                    <p>{{ $contact->location }}</p>
                    <p>{{ $contact->address }}</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>{{ $contact->contact }}</span></p>
                    <p><strong>Email:</strong> <span>{{ $contact->email }}</span></p>
                </div>
            @empty
                <p>Contact not Available Now.</p>
            @endforelse
            <div class="social-links d-flex mt-4">
                <a href="https://x.com/wecreativemedia"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.facebook.com/wecreativemedia"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/creativemedia_id/"><i class="bi bi-instagram"></i></a>
                <a href="https://www.tiktok.com/@creativemedia.id"><i class="bi bi-tiktok"></i></a>
                <a href="https://www.youtube.com/wecreativemedia?reload=9"><i class="bi bi-youtube"></i></a>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
            <h4>Menu</h4>
            <ul>
                <li><i class="bi bi-chevron-right"></i> <a href="/">Beranda</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('study.index') }}">Bidang Studi</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('service.index') }}">Layanan Jasa</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('student_work.index') }}">Karya Siswa</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('testimony.index') }}">Testimoni</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('article.index') }}">Artikel</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('contact.index') }}">Hubungi Kami</a></li>
            </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
            <h4>Bidang Studi</h4>
            <ul>
                @forelse($studies as $study)
                    <li><i class="bi bi-chevron-right"></i>
                        <a href="{{ route('study.show', $study->id) }}">{{ $study->name }}</a>
                    </li>
                @empty
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Bidang Studi not Available Now.</a></li>
                @endforelse
            </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
            <h4>Layanan Jasa</h4>
            <ul>
                @forelse($services as $service)
                <li><i class="bi bi-chevron-right"></i>
                    <a href="{{ route('service.show', $service->id) }}">{{ $service->name }}</a>
                </li>
                @empty
                <li><i class="bi bi-chevron-right"></i> <a href="#">Layanan Jasa not Available Now.</a></li>
                @endforelse
            </ul>
        </div>
        
    </div>
</div>

<div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Dewi</strong> <span>All Rights Reserved</span></p>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a
            href=“https://themewagon.com>ThemeWagon
    </div>
</div>