# Inventory Management System

A web-based inventory management system with real-time updates, secure chat, and multi-store support.

## Features

### 1. Core Functionality
- Real-time inventory tracking and management
- Multi-store support and selection
- Shopping list management
- Order processing and tracking
- Search functionality for inventory items
- Secure WebSocket communication

### 2. Security Features
- API key authentication system
- Encrypted chat communication (AES-CBC)
- Client-side RSA encryption support
- Secure message handling

### 3. User Interface
- Responsive web interface (`v1/index.php`)
- Dynamic search bar
- Navigation system with four main sections:
  - Inventory Mapping
  - Item List
  - Orders
  - Settings

### 4. Technical Components

#### Frontend
- Real-time WebSocket client (`websocket.js`)
- Item list management (`item_list.js`)
- Grocery list handling (`grocery_list.js`)
- Encryption utilities (`encryption.js`, `chat_encryption.js`)

#### Backend
- PHP-based API endpoints
- Chat system with XML storage (`createchat.php`)
- Message encryption and storage (`save_chat.php`)
- Configuration management (`config.php`)

## System Requirements
- Web server with PHP support
- MySQL/MariaDB database
- WebSocket server (running on localhost:8080)
- Modern web browser with JavaScript enabled

## Security Notes
- Implements client-side encryption for sensitive data
- Uses API key-based authentication
- Secure WebSocket communication
- Encrypted chat messages

## Database
The system requires database setup (schemas available in `token_schema.sql` and `user_files_schema.sql`)

## Configuration
Basic configuration can be set in `config.php`:
- Customer ID
- First Name
- Timezone
- ZIP Codes

## API Endpoints
- `/v1/api/search.php`: Item search functionality
- `/v1/api/orders.php`: Order management
- `/v1/api/list.php`: Shopping list management
- `/v1/api/save_chat.php`: Chat message storage
- `/v1/api/aggregated_inventory.php`: Inventory data

## Note
Some components appear to be in development or require additional implementation:
- Store selection system
- Settings management
- File upload functionality
- Complete order processing system

For more detailed implementation information, please consult the individual component documentation or contact the development team.