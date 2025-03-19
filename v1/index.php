<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <script src="dotpipe.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #f0f0f0;
            padding: 10px;
        }
        #canvas {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        #search-bar {
            display: flex;
            align-items: center;
        }
        #search-input {
            flex-grow: 1;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div id="search-bar">
            <input type="text" id="search-input" placeholder="Search items...">
            <button onclick="searchItems()">🔍</button>
        </div>
    </header>

    <div id="canvas"></div>

    <footer>
        <nav>
            <button onclick="showInventoryMapping()">Inventory Mapping</button>
            <button onclick="showItemList()">Item List</button>
            <button onclick="showOrders()">Orders</button>
            <button onclick="showSettings()">Settings</button>
        </nav>
    </footer>

    <script>
        let socket;
        let apiKey = localStorage.getItem('apiKey') || '';

        function initWebSocket() {
            socket = new WebSocket('ws://localhost:8080');
            socket.onopen = () => console.log('WebSocket connected');
            socket.onmessage = handleMessage;
            socket.onclose = () => setTimeout(initWebSocket, 5000);
        }

        function pingServer() {
            if (socket.readyState === WebSocket.OPEN) {
                socket.send(JSON.stringify({type: 'ping'}));
            }
        }

        function handleMessage(event) {
            const message = JSON.parse(event.data);
            switch (message.type) {
                case 'ping':
                    socket.send(JSON.stringify({type: 'pong'}));
                    break;
                case 'pong':
                    console.log('Received pong from server');
                    break;
                case 'update':
                    updateItemList(message.data);
                    break;
                case 'order':
                    handleNewOrder(message.data);
                    break;
                case 'chat':
                    displayChatMessage(message.data);
                    break;
                default:
                    console.log('Received unknown message type:', message.type);
            }
        }

        function searchItems() {
            const query = document.getElementById('search-input').value;
            fetch(`/v1/api/search.php?q=${query}&apiKey=${apiKey}`)
                .then(response => response.json())
                .then(data => displaySearchResults(data));
        }

        function displaySearchResults(results) {
            const canvas = document.getElementById('canvas');
            canvas.innerHTML = '<h2>Search Results</h2>';
            results.forEach(item => {
                canvas.innerHTML += `
                    <div>
                        <h3>${item.name}</h3>
                        <p>Price: $${item.price}</p>
                        <p>Store: ${item.store}</p>
                        <button onclick="addToList(${item.id})">Add to List</button>
                    </div>
                `;
            });
        }

        function showInventoryMapping() {
            const canvas = document.getElementById('canvas');
            canvas.innerHTML = '<h2>Inventory Mapping</h2>';
            // Load inventory mapping interface
        }

        function showItemList() {
            fetch(`/v1/api/item_list.php?apiKey=${apiKey}`)
                .then(response => response.json())
                .then(data => displayItemList(data));
        }

        function displayItemList(items) {
            const canvas = document.getElementById('canvas');
            canvas.innerHTML = '<h2>Item List</h2>';
            items.forEach(item => {
                canvas.innerHTML += `
                    <div>
                        <h3>${item.name}</h3>
                        <p>Price: $${item.price}</p>
                        <p>Store: ${item.store}</p>
                        <button onclick="removeFromList(${item.id})">Remove</button>
                    </div>
                `;
            });
            canvas.innerHTML += '<button onclick="checkoutList()">Checkout</button>';
        }

        function checkoutList() {
            if (confirm('Did you get what you need?')) {
                fetch(`/v1/api/checkout.php?apiKey=${apiKey}`, {method: 'POST'})
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('List removed and store debited.');
                            showItemList();
                        }
                    });
            }
        }

        function showOrders() {
            fetch(`/v1/api/orders.php?apiKey=${apiKey}`)
                .then(response => response.json())
                .then(data => displayOrders(data));
        }

        function displayOrders(orders) {
            const canvas = document.getElementById('canvas');
            canvas.innerHTML = '<h2>Orders</h2>';
            orders.forEach(order => {
                canvas.innerHTML += `
                    <div>
                        <h3>Order #${order.id}</h3>
                        <p>Status: ${order.status}</p>
                        <p>Total: $${order.total}</p>
                    </div>
                `;
            });
        }

        function showSettings() {
            const canvas = document.getElementById('canvas');
            canvas.innerHTML = `
                <h2>Settings</h2>
                <label for="api-key">API Key:</label>
                <input type="text" id="api-key" value="${apiKey}">
                <button onclick="saveApiKey()">Save</button>
            `;
        }

        function saveApiKey() {
            apiKey = document.getElementById('api-key').value;
            localStorage.setItem('apiKey', apiKey);
            alert('API Key saved');
        }

        initWebSocket();
        setInterval(pingServer, 30000);
    </script>
</body>
</html>
