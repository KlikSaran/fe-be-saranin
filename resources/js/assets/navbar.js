document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector(".navbar-component-wrapper");
    const kategoriBtn = document.getElementById("navbarKategoriBtn");
    const kategoriDropdown = document.getElementById("navbarKategoriDropdown");
    const inputSearch = document.getElementById("navbarInputSearch");
    const btnSearch = document.getElementById("navbarBtnSearch");
    const profileBtn = document.getElementById("navbarProfileBtn");
    const profileDropdown = document.getElementById("navbarProfileDropdown");

    if (kategoriBtn && kategoriDropdown) {
        let isInside = false;

        const showDropdown = () => {
            kategoriDropdown.classList.add("show");
            kategoriBtn.classList.add("active");
            kategoriBtn.setAttribute("aria-expanded", "true");
            kategoriDropdown.setAttribute("aria-hidden", "false");
        };

        const hideDropdown = () => {
            kategoriDropdown.classList.remove("show");
            kategoriBtn.classList.remove("active");
            kategoriBtn.setAttribute("aria-expanded", "false");
            kategoriDropdown.setAttribute("aria-hidden", "true");
        };

        navbar.addEventListener("mouseenter", () => {
            isInside = false;
        });

        kategoriBtn.addEventListener("mouseenter", () => {
            isInside = true;
            showDropdown();
        });
        kategoriDropdown.addEventListener("mouseenter", () => {
            isInside = true;
            showDropdown();
        });

        kategoriBtn.addEventListener("mouseleave", () => {
            isInside = false;
            setTimeout(() => {
                if (!isInside) hideDropdown();
            }, 100);
        });

        kategoriDropdown.addEventListener("mouseleave", () => {
            isInside = false;
            setTimeout(() => {
                if (!isInside) hideDropdown();
            }, 100);
        });
    }

    const kategoriCards = document.querySelectorAll(
        ".navbar-component-wrapper .kategori-card"
    );
    kategoriCards.forEach((card) => {
        card.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();

            const categoryName = e.currentTarget.dataset.category;

            kategoriCards.forEach((c) => c.classList.remove("selected"));

            e.currentTarget.classList.add("selected");

            console.log("Category selected:", categoryName);

            document.dispatchEvent(
                new CustomEvent("navbar:category-selected", {
                    detail: { category: categoryName },
                    bubbles: true,
                })
            );
        });
    });

    // --- Search Functionality ---
    const handleSearch = () => {
        if (inputSearch && inputSearch.value.trim() !== "") {
            const query = inputSearch.value.trim();
            console.log("Search query:", query);

            document.dispatchEvent(
                new CustomEvent("navbar:search", {
                    detail: { query: query },
                    bubbles: true,
                })
            );
        }
    };

    if (btnSearch) {
        btnSearch.addEventListener("click", handleSearch);
    }
    if (inputSearch) {
        inputSearch.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                handleSearch();
            }
        });
    }

    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isExpanded = profileDropdown.classList.toggle("show");
            profileBtn.setAttribute("aria-expanded", isExpanded.toString());
        });

        document.addEventListener("click", (e) => {
            if (
                profileDropdown.classList.contains("show") &&
                !profileDropdown.contains(e.target) &&
                !profileBtn.contains(e.target)
            ) {
                profileDropdown.classList.remove("show");
                profileBtn.setAttribute("aria-expanded", "false");
            }
        });

        document.addEventListener("keydown", (e) => {
            if (
                e.key === "Escape" &&
                profileDropdown.classList.contains("show")
            ) {
                profileDropdown.classList.remove("show");
                profileBtn.setAttribute("aria-expanded", "false");
                profileBtn.focus();
            }
        });
    }

    document.addEventListener("navbar:category-selected", (e) => {
        console.log("Global: Category selected:", e.detail.category);
    });

    document.addEventListener("navbar:search", (e) => {
        console.log("Global: Search query:", e.detail.query);
    });
});
