<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diads - Secure Inbox</title>
    <link rel="stylesheet" href="css/inbox_styles.css">
    <style>
        body {
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fefefe;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .inbox-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .inbox-tabs {
            display: flex;
            background: rgba(255,255,255,0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        .inbox-tab {
            padding: 10px 20px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .inbox-tab.active {
            background: rgba(255,255,255,0.2);
        }
        .inbox-item {
            background: rgba(255,255,255,0.1);
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            position: relative;
            transition: all 0.3s;
        }
        .inbox-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .encrypted-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
        }
        .read-status {
            margin-top: 10px;
        }
        .read-status button {
            background: none;
            border: 1px solid #fefefe;
            color: #fefefe;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .read-status button:hover {
            background: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="inbox-header">
            <h1>Secure Inbox</h1>
            <div class="inbox-tabs">
                <div class="inbox-tab active" onclick="switchTab('messages')">Messages</div>
                <div class="inbox-tab" onclick="switchTab('mail')">Mail</div>
            </div>
        </div>
        <div id="inbox-content"></div>
    </div>

    <script src="js/encryption.js"></script>
    <script>
        async function loadInboxContent(type = 'messages') {
            const response = await fetch(`api/get_${type}.php`);
            const messages = await response.json();

            const contentDiv = document.getElementById('inbox-content');
            contentDiv.innerHTML = messages.map(msg => `
                <div class="inbox-item">
                    <span class="encrypted-icon">🔒</span>
                    <h3>${msg.subject}</h3>
                    <p>${msg.content}</p>
                    <div class="read-status">
                        <button onclick="toggleReadStatus(this)">Mark as Read</button>
                    </div>
                </div>
            `).join('');
        }

        function toggleReadStatus(button) {
            if (button.textContent === "Mark as Read") {
                button.textContent = "Mark as Unread";
                button.parentElement.parentElement.style.opacity = "0.6";
            } else {
                button.textContent = "Mark as Read";
                button.parentElement.parentElement.style.opacity = "1";
            }
        }

        function switchTab(type) {
            document.querySelectorAll('.inbox-tab').forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            loadInboxContent(type);
        }

        loadInboxContent();
    </script>
</body>
</html>
