<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diads - Orders</title>
    <link rel="stylesheet" href="css/orders_styles.css">
</head>
<body>
    <div class="container">
        <div class="orders-header">
            <h1>My Orders</h1>
            <div class="orders-tabs">
                <div class="order-tab active" onclick="switchTab('all')">All Orders</div>
                <div class="order-tab" onclick="switchTab('active')">Active</div>
                <div class="order-tab" onclick="switchTab('completed')">Completed</div>
            </div>
        </div>
        <div id="orders-content"></div>
    </div>

    <script src="js/orders.js"></script>
</body>
</html>
