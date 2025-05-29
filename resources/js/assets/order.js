document.addEventListener("DOMContentLoaded", () => {
    const ordersContainer = document.getElementById("orders-container");
    const statusButtons = document.querySelectorAll(".status-btn");

    let orders = [];
    try {
        orders = JSON.parse(ordersContainer.dataset.orders);
    } catch (e) {
        console.error("Gagal memuat data pesanan", e);
    }

    function renderOrders(status = "all") {
        ordersContainer.innerHTML = "";

        const filtered =
            status === "all"
                ? orders
                : orders.filter((order) => order.status === status);

        if (filtered.length === 0) {
            ordersContainer.innerHTML =
                '<div class="no-orders">Tidak ada pesanan dengan status ini</div>';
            return;
        }

        filtered.forEach((order) => {
            const products = order.detail_transaction;

            const totalPrice = products.reduce(
                (sum, dt) => sum + dt.product.price * dt.quantity,
                0
            );
            const totalItems = products.reduce(
                (sum, dt) => sum + dt.quantity,
                0
            );

            const orderDiv = document.createElement("div");
            orderDiv.className = "order-card";

            const statusMap = {
                waiting: "Menunggu Konfirmasi",
                processing: "Diproses",
                shipping: "Dikirim",
                success: "Berhasil",
                failed: "Tidak Berhasil",
            };

            const statusText = statusMap[order.status] ?? "Unknown";
            const statusClass = order.status;

            orderDiv.innerHTML = `
                <div class="order-header">
                    <div class="order-date">${formatDate(
                        order.created_at
                    )}</div>
                    <div class="status-label ${statusClass}">${statusText}</div>
                </div>
                ${products
                    .map(
                        (dt) => `
                    <div class="order-content">
                        <img src="/storage/${dt.product.image}" alt="${
                            dt.product.name
                        }" class="product-image">
                        <div class="product-info">
                            <div class="product-name">${dt.product.name}</div>
                            <div class="product-price">Rp${dt.product.price.toLocaleString(
                                "id-ID"
                            )}</div>
                            <div class="quantity-info">Jumlah: ${
                                dt.quantity
                            }</div>
                        </div>
                    </div>
                `
                    )
                    .join("")}
                <div class="order-total">
                    Total: Rp${totalPrice.toLocaleString(
                        "id-ID"
                    )} (${totalItems} barang)
                </div>
            `;

            ordersContainer.appendChild(orderDiv);
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString("id-ID", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    }

    statusButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            statusButtons.forEach((b) => b.classList.remove("active"));
            this.classList.add("active");
            renderOrders(this.dataset.status);
        });
    });

    renderOrders();
});
