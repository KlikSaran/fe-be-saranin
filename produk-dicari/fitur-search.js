class SearchProducts extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this.products = this.getDummyProducts();
    this.filters = {
      category: 'barang fashion',
      price: {
        min: 0,
        max: 100000
      },
      location: '',
      rating: 0
    };
    this.render();
  }

  getDummyProducts() {
    return [
      {
        id: 1,
        name: "The north coat",
        originalPrice: 360,
        discountedPrice: 260,
        rating: 4.5,
        reviewCount: 65,
        category: "barang fashion"
      },
      {
        id: 2,
        name: "Gucci duffle bag",
        originalPrice: 160,
        discountedPrice: 96,
        rating: 4.5,
        reviewCount: 65,
        category: "barang fashion"
      },
      {
        id: 3,
        name: "Small BookSelf",
        price: 360,
        rating: 4.5,
        reviewCount: 65,
        category: "furniture"
      },
      {
        id: 4,
        name: "RGB liquid cooler",
        originalPrice: 170,
        discountedPrice: 160,
        rating: 4,
        reviewCount: 32,
        category: "komputer"
      },
      {
        id: 5,
        name: "The north coat premium",
        originalPrice: 400,
        discountedPrice: 300,
        rating: 4.8,
        reviewCount: 120,
        category: "barang fashion"
      }
    ];
  }

  connectedCallback() {
    document.addEventListener('category-selected', (e) => {
      this.filters.category = e.detail.category.toLowerCase();
      this.filterProducts();
    });

    document.addEventListener('search', (e) => {
      this.searchQuery = e.detail.query.toLowerCase();
      this.filterProducts();
    });
  }

  filterProducts() {
    let filtered = [...this.products];
    
    if (this.searchQuery) {
      filtered = filtered.filter(p => 
        p.name.toLowerCase().includes(this.searchQuery)
      );
    }
    
    if (this.filters.category) {
      filtered = filtered.filter(p => 
        p.category.toLowerCase().includes(this.filters.category.toLowerCase())
      );
    }
    
    if (this.filters.price) {
      filtered = filtered.filter(p => {
        const price = p.discountedPrice || p.price;
        return price >= this.filters.price.min && price <= this.filters.price.max;
      });
    }
    
    this.products = filtered;
    this.renderProducts();
  }

  render() {
    const style = document.createElement('style');
    style.textContent = `
      :host {
        display: block;
        --primary-color: #FFA500;
        --secondary-color: #FFF3E0;
        --text-color: #333;
        --light-gray: #f5f5f5;
        --border-color: #ddd;
      }
      
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
      }
      
      .search-container {
        display: flex;
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
        gap: 20px;
      }
      
      .filters {
        width: 250px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 20px;
        height: fit-content;
      }
      
      .filter-section {
        margin-bottom: 20px;
      }
      
      .filter-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-color);
      }
      
      .filter-option {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
      }
      
      .filter-option input {
        margin-right: 8px;
      }
      
      .price-inputs {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
      }
      
      .price-inputs input {
        width: 100%;
        padding: 8px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
      }
      
      .products-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
      }
      
      .product-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.3s;
      }
      
      .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      
      .product-image {
        height: 200px;
        background-color: var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
      }
      
      .product-info {
        padding: 15px;
      }
      
      .product-name {
        font-weight: 500;
        margin-bottom: 10px;
        color: var(--text-color);
      }
      
      .product-prices {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
      }
      
      .current-price {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 18px;
      }
      
      .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
      }
      
      .product-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--primary-color);
        font-size: 14px;
      }
      
      .search-header {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
      }
      
      .search-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 5px;
      }
      
      .search-subtitle {
        color: #666;
        font-size: 14px;
      }
      
      .flag-filter {
        background: var(--primary-color);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        display: inline-block;
        margin-top: 10px;
      }
      
      @media (max-width: 768px) {
        .search-container {
          flex-direction: column;
        }
        
        .filters {
          width: 100%;
        }
      }
    `;

    this.shadowRoot.appendChild(style);

    const template = document.createElement('template');
    template.innerHTML = `
      <div class="search-header">
        <h1 class="search-title">INDOAPRIL</h1>
        <p class="search-subtitle">KATEGORI: ${this.filters.category}</p>
        <span class="flag-filter">Flag Filter</span>
      </div>
      
      <div class="search-container">
        <div class="filters">
          <div class="filter-section">
            <h3 class="filter-title">Harga</h3>
            <div class="price-inputs">
              <input type="number" id="minPrice" placeholder="Rp 100.000" value="100000">
              <input type="number" id="maxPrice" placeholder="Rp Maksimum">
            </div>
          </div>
          
          <div class="filter-section">
            <h3 class="filter-title">Lokasi</h3>
            <div class="filter-option">
              <input type="radio" id="loc1" name="location" checked>
              <label for="loc1">Hidup Prabowo</label>
            </div>
            <div class="filter-option">
              <input type="radio" id="loc2" name="location">
              <label for="loc2">Hidup Jokowi</label>
            </div>
          </div>
        </div>
        
        <div class="products-grid" id="productsGrid">
          <!-- Products will be rendered here -->
        </div>
      </div>
    `;

    this.shadowRoot.appendChild(template.content.cloneNode(true));
    this.renderProducts();
    this.initEventListeners();
  }

  renderProducts() {
    const productsGrid = this.shadowRoot.getElementById('productsGrid');
    productsGrid.innerHTML = '';
    
    this.products.forEach(product => {
      const productCard = document.createElement('div');
      productCard.className = 'product-card';
      
      const ratingStars = '★'.repeat(Math.floor(product.rating)) + '☆'.repeat(5 - Math.floor(product.rating));
      
      productCard.innerHTML = `
        <div class="product-image">${product.name}</div>
        <div class="product-info">
          <h3 class="product-name">${product.name}</h3>
          <div class="product-prices">
            ${product.discountedPrice ? `
              <span class="current-price">$${product.discountedPrice}</span>
              <span class="original-price">$${product.originalPrice}</span>
            ` : `
              <span class="current-price">$${product.price}</span>
            `}
          </div>
          <div class="product-rating">
            ${ratingStars} (${product.reviewCount || 0})
          </div>
        </div>
      `;
      
      productsGrid.appendChild(productCard);
    });
  }

  initEventListeners() {
    const minPrice = this.shadowRoot.getElementById('minPrice');
    const maxPrice = this.shadowRoot.getElementById('maxPrice');
    
    [minPrice, maxPrice].forEach(input => {
      input.addEventListener('change', () => {
        this.filters.price = {
          min: parseInt(minPrice.value) || 0,
          max: parseInt(maxPrice.value) || Infinity
        };
        this.filterProducts();
      });
    });
    
    this.shadowRoot.querySelectorAll('input[name="location"]').forEach(radio => {
      radio.addEventListener('change', (e) => {
        this.filters.location = e.target.nextElementSibling.textContent;
        this.filterProducts();
      });
    });
  }
}

customElements.define('search-products', SearchProducts);