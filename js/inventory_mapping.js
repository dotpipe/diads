// File: v1/js/inventory_mapping.js

const requiredFields = ['Price', 'Brand', 'Item', 'Quantity'];

function createInventoryMappingInterface() {
    const canvas = document.getElementById('canvas');
    canvas.innerHTML = `
        <div id="inventory-mapping-container">
            <h2>Inventory Data Mapping</h2>
            <div id="required-fields"></div>
            <div id="custom-fields"></div>
            <button onclick="saveInventoryMapping()">Save Mapping</button>
        </div>
    `;
    loadExistingMapping();
}

function loadExistingMapping() {
    fetch('/api/get_inventory_mapping.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ token: AuthManager.getToken() })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            populateRequiredFields(data.mapping);
            populateCustomFields(data.mapping);
        } else {
            initializeDefaultMapping();
        }
    });
}

function populateRequiredFields(mapping) {
    const container = document.getElementById('required-fields');
    container.innerHTML = '<h3>Required Fields</h3>';
    requiredFields.forEach(field => {
        container.innerHTML += `
            <div class="mapping-row">
                <label>${field}:</label>
                <input type="text" id="${field.toLowerCase()}-mapping" value="${mapping[field] || ''}" placeholder="Your field name">
            </div>
        `;
    });
}

function populateCustomFields(mapping) {
    const container = document.getElementById('custom-fields');
    container.innerHTML = '<h3>Custom Fields</h3>';
    for (const [key, value] of Object.entries(mapping)) {
        if (!requiredFields.includes(key)) {
            container.innerHTML += createCustomFieldRow(key, value);
        }
    }
    container.innerHTML += `<button onclick="addCustomField()">Add Custom Field</button>`;
}

function createCustomFieldRow(key = '', value = '') {
    return `
        <div class="custom-field-row">
            <input type="text" class="custom-key" value="${key}" placeholder="Custom field name">
            <input type="text" class="custom-value" value="${value}" placeholder="Your field name">
            <button onclick="removeCustomField(this)">Remove</button>
        </div>
    `;
}

function addCustomField() {
    const container = document.getElementById('custom-fields');
    const newRow = document.createElement('div');
    newRow.innerHTML = createCustomFieldRow();
    container.insertBefore(newRow, container.lastElementChild);
}

function removeCustomField(button) {
    button.parentElement.remove();
}

function saveInventoryMapping() {
    const mapping = {};
    requiredFields.forEach(field => {
        mapping[field] = document.getElementById(`${field.toLowerCase()}-mapping`).value;
    });
    
    document.querySelectorAll('.custom-field-row').forEach(row => {
        const key = row.querySelector('.custom-key').value;
        const value = row.querySelector('.custom-value').value;
        if (key && value) {
            mapping[key] = value;
        }
    });

    fetch('/api/save_inventory_mapping.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            token: AuthManager.getToken(),
            mapping: mapping
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Inventory mapping saved successfully');
        } else {
            alert('Failed to save inventory mapping');
        }
    });
}

function initializeDefaultMapping() {
    const defaultMapping = {
        Price: 'price',
        Brand: 'brand',
        Item: 'item_name',
        Quantity: 'quantity'
    };
    populateRequiredFields(defaultMapping);
    populateCustomFields({});
}

// Call this function to initialize the inventory mapping interface
createInventoryMappingInterface();
