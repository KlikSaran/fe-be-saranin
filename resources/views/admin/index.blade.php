<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Dashboard | Mantis Bootstrap 5 Admin Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets_admin/img/favicon.svg') }}" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/admin.css')

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <x-admin-sidebar></x-admin-sidebar>
    <x-admin-header></x-admin-header>

    <!-- [ Main Content ] start -->
    @yield('content')

    <x-admin-footer></x-admin-footer>

    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets_admin/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/pages/dashboard-default.js') }}"></script>
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('assets_admin/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets_admin/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets_admin/js/plugins/feather.min.js') }}"></script>





    <script>layout_change('light');</script>




    <script>change_box_container('false');</script>



    <script>layout_rtl_change('false');</script>


    <script>preset_change("preset-1");</script>


    <script>font_change("Public-Sans");</script>


    {{--
    <script src="{{ asset('/js/plugins/clipboard.min.js') }}"></script>
    <script>
        window.addEventListener('load', (event) => {
            var i_copy = new ClipboardJS('.color-block');
            i_copy.on('success', function (e) {
                var targetElement = e.trigger;
                let icon_badge = document.createElement('span');
                icon_badge.setAttribute('class', 'ic-badge badge bg-success float-end');
                icon_badge.innerHTML = 'copied';
                targetElement.append(icon_badge);
                setTimeout(function () {
                    targetElement.children[0].remove();
                }, 3000);
            });

            i_copy.on('error', function (e) {
                var targetElement = e.trigger;
                let icon_badge = document.createElement('span');
                icon_badge.setAttribute('class', 'ic-badge badge bg-danger float-end');
                icon_badge.innerHTML = 'Error';
                targetElement.append(icon_badge);
                setTimeout(function () {
                    targetElement.children[0].remove();
                }, 3000);
            });
        });
    </script> --}}

    {{--
    <script>
        @if (session('studySuccessAlert'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('studySuccessAlert') }}",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 3000
            });
        @endif
    </script> --}}

    {{--
    <script>
        // Edit button click event
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let studyId = this.getAttribute("data-id");
                    let name = this.getAttribute("data-name");
                    let title = this.getAttribute("data-title");
                    let content = this.getAttribute("data-content");
                    let image = this.getAttribute("data-image");

                    document.getElementById("edit-modal-id").value = studyId;
                    document.getElementById("name").value = name;
                    document.getElementById("title").value = title;

                    $('#summernote').summernote('code', content);

                    if (image) {
                        document.getElementById("preview-image").src = "/storage/" + image;
                    }

                    document.getElementById("editForm").setAttribute("action", "/admin/create/study_admin/" + studyId);

                    let editModal = new bootstrap.Modal(document.getElementById("editModal"));
                    editModal.show();
                });
            });
        });


        // Dynamic preview image
        document.getElementById("image").addEventListener("change", function (event) {
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("preview-image").src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Confirmation delete message
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll("#delete-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let studyId = this.getAttribute("data-id");
                    let form = this.closest("form");

                    Swal.fire({
                        title: "Apakah kamu yakin?",
                        text: "Bidang Studi ini akan dihapus secara permanen!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        let searchTimeout;
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');

        function handleSearchInput() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                if (searchInput.value === '') {
                    searchForm.submit();
                }
            }, 500);
        }

    </script> --}}

</body>
<!-- [Body] end -->

</html>