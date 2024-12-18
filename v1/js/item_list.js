function loadAggregatedInventory() {
    fetch('/api/aggregated_inventory.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                displayItemList(data.data);
            }
        })
        .catch(error => console.error('Error:', error));
}

function displayItemList(items) {
    const container = document.getElementById('item-list-container');
    let html = '<ul class="item-list">';
    items.forEach(item => {
        html += `
            <li>
                <span class="item-name">${item.item_name}</span>
                <span class="item-price">$${item.price}</span>
                <span class="item-quantity">Qty: ${item.quantity}</span>
                <span class="item-store">${item.store_name}</span>
            </li>
        `;
    });
    html += '</ul>';
    container.innerHTML = html;
}

document.addEventListener('DOMContentLoaded', loadAggregatedInventory);
