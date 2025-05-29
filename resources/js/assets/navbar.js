// public/js/navbar.js

document.addEventListener("DOMContentLoaded", () => {
    const kategoriBtn = document.getElementById("navbarKategoriBtn");
    const kategoriDropdown = document.getElementById("navbarKategoriDropdown");
    const inputSearch = document.getElementById("navbarInputSearch");
    const btnSearch = document.getElementById("navbarBtnSearch");
    const profileBtn = document.getElementById("navbarProfileBtn"); // For potential JS-driven profile dropdown
    const profileDropdown = document.getElementById("navbarProfileDropdown"); // For potential JS-driven profile dropdown

    // --- Category Dropdown Toggle ---
    if (kategoriBtn && kategoriDropdown) {
        kategoriBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent click from bubbling up to document
            kategoriDropdown.classList.toggle("show");
            kategoriBtn.classList.toggle("active");
            // Accessibility
            const isExpanded = kategoriBtn.classList.contains("active");
            kategoriBtn.setAttribute("aria-expanded", isExpanded.toString());
            kategoriDropdown.setAttribute(
                "aria-hidden",
                (!isExpanded).toString()
            );
        });

        // Close dropdown when clicking outside of it
        document.addEventListener("click", (e) => {
            if (
                kategoriDropdown.classList.contains("show") &&
                !kategoriDropdown.contains(e.target) &&
                !kategoriBtn.contains(e.target)
            ) {
                kategoriDropdown.classList.remove("show");
                kategoriBtn.classList.remove("active");
                kategoriBtn.setAttribute("aria-expanded", "false");
                kategoriDropdown.setAttribute("aria-hidden", "true");
            }
        });

        // Close dropdown with Escape key
        document.addEventListener("keydown", (e) => {
            if (
                e.key === "Escape" &&
                kategoriDropdown.classList.contains("show")
            ) {
                kategoriDropdown.classList.remove("show");
                kategoriBtn.classList.remove("active");
                kategoriBtn.setAttribute("aria-expanded", "false");
                kategoriDropdown.setAttribute("aria-hidden", "true");
                kategoriBtn.focus(); // Return focus to the button
            }
        });
    }

    // --- Category Selection ---
    // This assumes you want to dispatch an event. If navigation is direct, this might not be needed.
    const kategoriCards = document.querySelectorAll(
        ".navbar-component-wrapper .kategori-card"
    );
    kategoriCards.forEach((card) => {
        card.addEventListener("click", (e) => {
            // If the link itself handles navigation, preventDefault might not be needed
            // e.preventDefault();
            const categoryName = e.currentTarget.dataset.category;
            console.log("Category selected:", categoryName); // For debugging

            // Dispatch a custom event if other parts of your application need to react
            document.dispatchEvent(
                new CustomEvent("navbar:category-selected", {
                    detail: { category: categoryName },
                    bubbles: true, // Allow event to bubble up
                })
            );
            // Example: alert(`Kategori dipilih: ${categoryName}`);
            // Close dropdown after selection
            if (kategoriDropdown && kategoriBtn) {
                kategoriDropdown.classList.remove("show");
                kategoriBtn.classList.remove("active");
                kategoriBtn.setAttribute("aria-expanded", "false");
                kategoriDropdown.setAttribute("aria-hidden", "true");
            }
        });
    });

    // --- Search Functionality ---
    const handleSearch = () => {
        if (inputSearch && inputSearch.value.trim() !== "") {
            const query = inputSearch.value.trim();
            console.log("Search query:", query); // For debugging

            // Dispatch a custom event
            document.dispatchEvent(
                new CustomEvent("navbar:search", {
                    detail: { query: query },
                    bubbles: true,
                })
            );
            // Example: alert(`Mencari: ${query}`);
            // Example: window.location.href = `/search?q=${encodeURIComponent(query)}`;
            // inputSearch.value = ""; // Clear input after search if needed
        }
    };

    if (btnSearch) {
        btnSearch.addEventListener("click", handleSearch);
    }
    if (inputSearch) {
        inputSearch.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault(); // Prevent form submission if it's in a form
                handleSearch();
            }
        });
    }

    // --- Profile Dropdown (JS-driven alternative/enhancement to CSS :hover) ---
    // The current Blade example uses CSS :hover for the profile dropdown.
    // If you need more control (e.g., click to open/close, better accessibility):
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isExpanded = profileDropdown.classList.toggle("show");
            profileBtn.setAttribute("aria-expanded", isExpanded.toString());
        });

        // Close profile dropdown when clicking outside
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

        // Close profile dropdown with Escape key
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

    // --- Demo Event Listeners (can be in your main app.js or specific page JS) ---
    document.addEventListener("navbar:category-selected", (e) => {
        console.log("Global: Category selected:", e.detail.category);
        // alert(`Global: Kategori dipilih: ${e.detail.category}`);
        // Example: redirect or fetch products for this category
        // window.location.href = `/category/${e.detail.category}`;
    });

    document.addEventListener("navbar:search", (e) => {
        console.log("Global: Search query:", e.detail.query);
    });
});
