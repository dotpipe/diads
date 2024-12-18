let groceryList = [];

function addItem() {
    const itemName = document.getElementById('itemName').value;
    const quantity = document.getElementById('quantity').value;
    groceryList.push({ name: itemName, quantity: parseInt(quantity) });
    updateList();
    document.getElementById('itemName').value = '';
    document.getElementById('quantity').value = '';
}

function updateList() {
    const listElement = document.getElementById('groceryList');
    listElement.innerHTML = '';
    groceryList.forEach((item, index) => {
        listElement.innerHTML += `<li>${item.name} (x${item.quantity}) <button onclick="removeItem(${index})">Remove</button></li>`;
    });
}

function removeItem(index) {
    groceryList.splice(index, 1);
    updateList();
}

async function fulfillList() {
    const response = await fetch('/api/v1/lists/fulfill', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ items: groceryList }),
    });
    const data = await response.json();
    displayResults(data.data);
}

function displayResults(results) {
    const resultsElement = document.getElementById('results');
    resultsElement.innerHTML = '';
    
    const stores = {};
    
    for (const [itemName, storeList] of Object.entries(results)) {
        storeList.forEach(store => {
            if (!stores[store.store_id]) {
                stores[store.store_id] = { name: store.store_name, total: 0, items: [] };
            }
            stores[store.store_id].total += store.price * groceryList.find(item => item.name === itemName).quantity;
            stores[store.store_id].items.push(`${itemName} (x${groceryList.find(item => item.name === itemName).quantity})`);
        });
    }
    
    for (const [storeId, storeData] of Object.entries(stores)) {
        resultsElement.innerHTML += `
            <div class="store-result">
                <h3>${storeData.name}</h3>
                <p>Total: $${storeData.total.toFixed(2)}</p>
                <p>Items: ${storeData.items.join(', ')}</p>
                <button onclick="selectStore(${storeId})">Select Store</button>
            </div>
        `;
    }
}

async function selectStore(storeId) {
    const response = await fetch('/api/v1/stores/select', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ store_id: storeId }),
    });
    const data = await response.json();
    if (data.status === 'success') {
        alert('Store selected successfully!');
    } else {
        alert('Error selecting store. Please try again later.');
    }
}
