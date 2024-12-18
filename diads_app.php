<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diads App - Inbox</title>
    <style>
        body {
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fefefe;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        #mobile-view, #desktop-view {
            display: none;
        }
        @media (max-width: 767px) {
            #mobile-view { display: block; }
        }
        @media (min-width: 768px) {
            #desktop-view { display: block; }
        }
        .inbox-item {
            background: rgba(255,255,255,0.1);
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
        }
        .back-button {
            cursor: pointer;
            padding: 10px;
            background: rgba(255,255,255,0.2);
            display: inline-block;
            border-radius: 5px;
        }
        footer {
            background: rgba(0,0,0,0.5);
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        footer a {
            color: #fefefe;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Diads Inbox</h1>
        
        <div id="mobile-view">
            <div id="mobile-content"></div>
        </div>
        
        <div id="desktop-view">
            <div class="back-button" onclick="goBack()">&#8592; Back</div>
            <div id="main-content"></div>
        </div>
    </div>

    <footer id="inbox-footer">
        <a href="#" onclick="loadInboxContent('messages')">Messages</a>
        <a href="#" onclick="loadInboxContent('mail')">Mail</a>
        <a href="#" onclick="loadInboxContent('invoices')">Invoices</a>
    </footer>

    <script>
        function loadInboxContent(type) {
            const isMobile = window.innerWidth < 768;
            const contentDiv = isMobile ? document.getElementById('mobile-content') : document.getElementById('main-content');
            
            // Simulated content loading - replace with actual AJAX calls to your backend
            let content = '';
            switch(type) {
                case 'messages':
                    content = '<div class="inbox-item">New message from Store A</div><div class="inbox-item">Chat with Customer B</div>';
                    break;
                case 'mail':
                    content = '<div class="inbox-item">Newsletter: Summer Deals</div><div class="inbox-item">Account Update</div>';
                    break;
                case 'invoices':
                    content = '<div class="inbox-item">Invoice #1234 - Store C</div><div class="inbox-item">Receipt - Order #5678</div>';
                    break;
            }
            contentDiv.innerHTML = content;
        }

        function goBack() {
            // Implement your back navigation logic here
            console.log("Going back...");
        }

        // Initial load
        loadInboxContent('messages');
    </script>
</body>
</html>
