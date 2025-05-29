class NavbarComponent extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: "open" });
        this.categories = this.getDummyCategories();
        this.render();
    }

    getDummyCategories() {
        return [
            {
                name: "Komputer & Aksesoris",
                icon: "https://cdn-icons-png.flaticon.com/512/2203/2203270.png",
                subcategories: ["Laptop", "PC Desktop", "Keyboard", "Mouse"],
            },
            {
                name: "Elektronik",
                icon: "https://cdn-icons-png.flaticon.com/512/3659/3659898.png",
                subcategories: ["Smartphone", "TV", "Kamera", "Audio"],
            },
            {
                name: "Fashion",
                icon: "https://cdn-icons-png.flaticon.com/512/2785/2785813.png",
                subcategories: ["Pria", "Wanita", "Anak", "Aksesoris"],
            },
            {
                name: "Kesehatan",
                icon: "https://cdn-icons-png.flaticon.com/512/2964/2964517.png",
                subcategories: [
                    "Obat",
                    "Vitamin",
                    "Alat Kesehatan",
                    "Perawatan",
                ],
            },
            {
                name: "Olahraga",
                icon: "https://cdn-icons-png.flaticon.com/512/2936/2936886.png",
                subcategories: ["Fitness", "Sepeda", "Lari", "Bola"],
            },
            {
                name: "Makanan",
                icon: "https://cdn-icons-png.flaticon.com/512/3075/3075977.png",
                subcategories: ["Snack", "Minuman", "Bahan Masak", "Instan"],
            },
        ];
    }

    render() {
        const faLink = document.createElement("link");
        faLink.rel = "stylesheet";
        faLink.href =
            "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css";
        this.shadowRoot.appendChild(faLink);

        const style = document.createElement("style");
        style.textContent = `
                    :host {
                        display: block;
                        --primary-color: #3734A9;
                        --hover-bg: #FFF3E0;
                    }
                    
                    * {
                        box-sizing: border-box;
                        margin: 0;
                        padding: 0;
                        font-family: 'Poppins', sans-serif;
                    }
                    
                    nav {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 15px 5%;
                        background-color: white;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                        position: relative;
                    }
                    
                    nav h2 {
                        color: #333;
                        font-weight: 700;
                        font-size: 20px;
                    }
                    
                    .kategori-btn {
                        background-color: transparent;
                        border: 2px solid var(--primary-color);
                        border-radius: 20px;
                        font-weight: 500;
                        cursor: pointer;
                        padding: 8px 16px;
                        transition: all 0.3s;
                        color: #555;
                        font-size: 14px;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    }
                    
                    .kategori-btn:hover {
                        background: var(--hover-bg);
                    }
                    
                    .kategori-btn.active {
                        background: var(--primary-color);
                        color: white;
                        font-weight: 600;
                    }
                    
                    .kategori-dropdown {
                        position: absolute;
                        top: 100%;
                        left: 5%;
                        width: 90%;
                        background-color: white;
                        border-radius: 10px;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                        padding: 20px;
                        display: none;
                        z-index: 100;
                    }
                    
                    .kategori-dropdown.show {
                        display: block;
                    }
                    
                    .kategori-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                        gap: 15px;
                    }
                    
                    .kategori-card {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        padding: 15px;
                        border-radius: 8px;
                        transition: all 0.3s;
                        cursor: pointer;
                        text-decoration: none;
                        color: #333;
                        border: 1px solid #eee;
                    }
                    
                    .kategori-card:hover {
                        background-color: #f5f5f5;
                        transform: translateY(-3px);
                        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                    }
                    
                    .kategori-card img {
                        width: 50px;
                        height: 50px;
                        object-fit: contain;
                        margin-bottom: 10px;
                    }
                    
                    .kategori-card span {
                        font-size: 14px;
                        text-align: center;
                        font-weight: 500;
                    }
                    
                    .container-search {
                        display: flex;
                        align-items: center;
                        width: 40%;
                    }
                    
                    #input-search {
                        width: 100%;
                        padding: 10px 15px;
                        border: 1px solid #ddd;
                        border-radius: 20px 0 0 20px;
                        outline: none;
                        font-size: 14px;
                    }
                    
                    #btn-search {
                        background-color: #f0f0f0;
                        border: 1px solid #ddd;
                        border-left: none;
                        border-radius: 0 20px 20px 0;
                        padding: 10px 15px;
                        cursor: pointer;
                        transition: all 0.3s;
                        color: #555;
                    }
                    
                    #btn-search:hover {
                        background-color: #e0e0e0;
                    }
                    
                    .nav-icons {
                        display: flex;
                        align-items: center;
                        gap: 25px;
                    }
                    
                    .nav-icon {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        text-decoration: none;
                        color: #555;
                        font-size: 12px;
                        transition: all 0.3s;
                        font-weight: 500;
                    }
                    
                    .nav-icon i {
                        font-size: 18px;
                        margin-bottom: 5px;
                    }
                    
                    .nav-icon:hover {
                        color: var(--primary-color);
                    }
                    
                    .profile-container {
                        position: relative;
                    }
                    
                    .profile-dropdown {
                        position: absolute;
                        top: 100%;
                        right: 0;
                        background-color: white;
                        border-radius: 10px;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                        padding: 10px 0;
                        width: 180px;
                        display: none;
                        z-index: 100;
                    }
                    
                    .profile-container:hover .profile-dropdown {
                        display: block;
                    }
                    
                    .profile-dropdown a {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 10px 20px;
                        text-decoration: none;
                        color: #555;
                        transition: all 0.3s;
                        font-size: 14px;
                    }
                    
                    .profile-dropdown a:hover {
                        background-color: #f5f5f5;
                        color: var(--primary-color);
                    }
                    
                    .divider {
                        height: 1px;
                        background-color: #eee;
                        margin: 5px 0;
                    }
                    
                    @media (max-width: 768px) {
                        .container-search {
                            display: none;
                        }
                        
                        .nav-icons {
                            gap: 15px;
                        }
                    }
                `;

        this.shadowRoot.appendChild(style);

        const template = document.createElement("template");
        template.innerHTML = `
                    <nav>
                        <a href="/">Saranin.Id</a>
                        
                        <button class="kategori-btn" id="kategoriBtn">
                            <i class="fas fa-bars"></i> Kategori
                        </button>
                        
                        <div class="kategori-dropdown" id="kategoriDropdown">
                            <div class="kategori-grid">
                                ${this.categories
                                    .map(
                                        (category) => `
                                    <a href="#" class="kategori-card" data-category="${category.name}">
                                        <img src="${category.icon}" alt="${category.name}">
                                        <span>${category.name}</span>
                                    </a>
                                `
                                    )
                                    .join("")}
                            </div>
                        </div>
                        
                        <div class="container-search">
                            <input type="text" id="input-search" placeholder="Cari produk...">
                            <button id="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                        
                        <div class="nav-icons">
                            <a href="/transactions" class="nav-icon" id="transaksiBtn">
                                <i class="fas fa-file-invoice"></i>
                                <span>Transaksi</span>
                            </a>
                            
                            <a href="/baskets" class="nav-icon" id="keranjangBtn">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Keranjang</span>
                            </a>
                            
                            <div class="profile-container">
                                <div class="nav-icon" id="profileBtn">
                                    <i class="fas fa-user-circle"></i>
                                    <span>Profile</span>
                                </div>
                                
                                <div class="profile-dropdown">
                                    <a href="/dashboards" id="dashboardBtn"><i class="fas fa-home"></i> Dashboard</a>
                                    <div class="divider"></div>
                                    <a href="/profiles" id="settingsBtn"><i class="fas fa-user-cog"></i> Setting Profile</a>
                                    <div class="divider"></div>
                                    <a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                `;

        this.shadowRoot.appendChild(template.content.cloneNode(true));
        this.initEventListeners();
    }

    initEventListeners() {
        // Category dropdown toggle
        const kategoriBtn = this.shadowRoot.getElementById("kategoriBtn");
        const kategoriDropdown =
            this.shadowRoot.getElementById("kategoriDropdown");

        kategoriBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            kategoriDropdown.classList.toggle("show");
            kategoriBtn.classList.toggle("active");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", () => {
            kategoriDropdown.classList.remove("show");
            kategoriBtn.classList.remove("active");
        });

        // Category selection
        this.shadowRoot.querySelectorAll(".kategori-card").forEach((card) => {
            card.addEventListener("click", (e) => {
                e.preventDefault();
                const categoryName = e.currentTarget.dataset.category;
                this.dispatchEvent(
                    new CustomEvent("category-selected", {
                        detail: { category: categoryName },
                        bubbles: true,
                        composed: true,
                    })
                );
            });
        });

        // Search functionality
        const btnSearch = this.shadowRoot.getElementById("btn-search");
        const inputSearch = this.shadowRoot.getElementById("input-search");

        const handleSearch = () => {
            if (inputSearch.value.trim() !== "") {
                this.dispatchEvent(
                    new CustomEvent("search", {
                        detail: { query: inputSearch.value },
                        bubbles: true,
                        composed: true,
                    })
                );
                inputSearch.value = "";
            }
        };

        btnSearch.addEventListener("click", handleSearch);
        inputSearch.addEventListener("keypress", (e) => {
            if (e.key === "Enter") handleSearch();
        });

        // Navigation buttons
        // ["transaksiBtn", "keranjangBtn", "settingsBtn", "logoutBtn"].forEach(
        //     (id) => {
        //         const btn = this.shadowRoot.getElementById(id);
        //         if (btn) {
        //             btn.addEventListener("click", (e) => {
        //                 e.preventDefault();
        //                 this.dispatchEvent(
        //                     new CustomEvent("nav-click", {
        //                         detail: { action: id.replace("Btn", "") },
        //                         bubbles: true,
        //                         composed: true,
        //                     })
        //                 );
        //             });
        //         }
        //     }
        // );
    }
}

customElements.define("navbar-component", NavbarComponent);

// Demo usage
document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector("navbar-component");

    navbar.addEventListener("category-selected", (e) => {
        console.log("Category selected:", e.detail.category);
        alert(`Kategori dipilih: ${e.detail.category}`);
    });

    navbar.addEventListener("search", (e) => {
        console.log("Search query:", e.detail.query);
        alert(`Mencari: ${e.detail.query}`);
    });

    navbar.addEventListener("nav-click", (e) => {
        console.log("Navigation action:", e.detail.action);
        alert(`Aksi: ${e.detail.action}`);
    });
});
