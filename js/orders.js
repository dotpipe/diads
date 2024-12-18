async function loadOrdersContent(type = 'all') {
    const response = await fetch(`api/get_orders.php?type=${type}`);
    const orders = await response.json();

    const contentDiv = document.getElementById('orders-content');
    contentDiv.innerHTML = orders.map(order => `
        <div class="order-item">
            <h3>Order #${order.id}</h3>
            <p>Status: ${order.status}</p>
            <p>Total: $${order.total}</p>
            <button onclick="viewOrderDetails(${order.id})">View Details</button>
        </div>
    `).join('');
}

function switchTab(type) {
    document.querySelectorAll('.order-tab').forEach(tab => tab.classList.remove('active'));
    event.target.classList.add('active');
    loadOrdersContent(type);
}

function viewOrderDetails(orderId) {
    // Implement order details view logic here
    console.log(`Viewing details for order ${orderId}`);
}

// Load initial content
loadOrdersContent();
