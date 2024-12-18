async function loadStoreAvailability() {
    const response = await fetch('/api/v1/ordering/store-availability');
    const data = await response.json();

    const storeListElement = document.getElementById('store-list');
    storeListElement.innerHTML = data.data.map(store => ).join('');
}

async function viewInventory(storeId) {
    const response = await fetch(`/api/v1/ordering/store-inventory/${storeId}`);
    const data = await response.json();

    const storeItemElement = document.querySelector(`.store-item[data-id="${storeId}"]`);
    const inventoryHtml = data.data.map(item => ).join('');

    storeItemElement.innerHTML += `<div class="inventory">${inventoryHtml}</div>`;
}

loadStoreAvailability();
