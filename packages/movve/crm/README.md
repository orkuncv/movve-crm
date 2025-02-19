# Movve CRM Package

This package provides CRM functionality for Movve applications.

## Installation

You can install the package via composer:

```bash
composer require movve/crm
```

The package will automatically register its service provider.

## Features

- Contact management with CRUD operations
- Soft delete support for archiving contacts
- Search functionality
- Pagination support
- Input validation
- API endpoints for all operations

## API Documentation

### List Contacts
```http
GET /api/crm/contacts
```

Query Parameters:
- `page` (integer, optional): Page number for pagination
- `per_page` (integer, optional): Number of items per page (default: 15)
- `search` (string, optional): Search term to filter contacts

Response:
```json
{
    "data": [
        {
            "id": 1,
            "first_name": "John",
            "last_name": "Doe",
            "email": "john@example.com",
            "phone_number": "1234567890",
            "date_of_birth": "1990-01-01",
            "created_at": "2024-02-19T12:00:00.000000Z",
            "updated_at": "2024-02-19T12:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 1,
        "per_page": 15
    }
}
```

### Create Contact
```http
POST /api/crm/contacts
```

Request Body:
```json
{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@example.com",
    "phone_number": "1234567890",    // optional
    "date_of_birth": "1990-01-01"    // optional
}
```

### Show Contact
```http
GET /api/crm/contacts/{id}
```

### Update Contact
```http
PUT /api/crm/contacts/{id}
```

Request Body:
```json
{
    "first_name": "John",    // optional
    "last_name": "Doe",      // optional
    "email": "john@example.com",  // optional
    "phone_number": "1234567890",    // optional
    "date_of_birth": "1990-01-01"    // optional
}
```

### Delete Contact
```http
DELETE /api/crm/contacts/{id}
```

### Restore Contact
```http
POST /api/crm/contacts/{id}/restore
```

## API Permissions

The CRM package uses a strict permission system. To access any CRM functionality, tokens must have the following permissions:

### Base Permission
- `crm:access` - Required for any CRM functionality

### Specific Permissions
- `crm:read` - View contacts list and details
- `crm:create` - Create new contacts
- `crm:update` - Update existing contacts
- `crm:delete` - Delete contacts
- `crm:restore` - Restore deleted contacts

### Creating a Token with Full CRM Access

Using Jetstream's UI:
1. Go to User Settings → API Tokens
2. Create a new token with all CRM permissions:
   - crm:access
   - crm:read
   - crm:create
   - crm:update
   - crm:delete
   - crm:restore

Using PHP:
```php
$user = User::find(1);
$token = $user->createToken('crm-full-access', [
    'crm:access',
    'crm:read',
    'crm:create',
    'crm:update',
    'crm:delete',
    'crm:restore'
])->plainTextToken;
```

### Creating a Read-Only Token

```php
$token = $user->createToken('crm-readonly', [
    'crm:access',
    'crm:read'
])->plainTextToken;
```

### Permission Requirements per Endpoint

| Endpoint | Method | Required Permissions |
|----------|---------|---------------------|
| `/api/crm/contacts` | GET | crm:access, crm:read |
| `/api/crm/contacts` | POST | crm:access, crm:create |
| `/api/crm/contacts/{id}` | GET | crm:access, crm:read |
| `/api/crm/contacts/{id}` | PUT | crm:access, crm:update |
| `/api/crm/contacts/{id}` | DELETE | crm:access, crm:delete |
| `/api/crm/contacts/{id}/restore` | POST | crm:access, crm:restore |

### Security Notes

1. All CRM endpoints require authentication via Laravel Sanctum
2. The base `crm:access` permission is required for all endpoints
3. Each action requires its specific permission
4. Tokens without the required permissions will receive a 403 error
5. Invalid or expired tokens will receive a 401 error

## API Authentication

This package uses Laravel Sanctum for API authentication. To use the API, you'll need to:

1. Generate an API token for your user:
```php
// In Laravel Tinker or your application code:
$user = User::find(1); // Replace with your user
$token = $user->createToken('api-token')->plainTextToken;
```

2. Use the token in your API requests by adding the following header:
```
Authorization: Bearer YOUR_API_TOKEN
```

3. In Postman:
   - Click on the "Movve CRM" collection
   - Go to the "Authorization" tab
   - Select "Bearer Token" as Type
   - Paste your token in the "Token" field
   - All requests in the collection will now include the token

4. Example using curl:
```bash
curl -X GET http://localhost:8000/api/crm/contacts \
    -H "Authorization: Bearer YOUR_API_TOKEN" \
    -H "Accept: application/json"
```

### Creating Tokens in Jetstream

1. Log in to your application
2. Go to User Settings → API Tokens
3. Click "Create New Token"
4. Give your token a name and select the required permissions
5. Copy the generated token and use it in your API requests

### Token Permissions

You can restrict token abilities by adding permissions when creating the token:

```php
$token = $user->createToken('api-token', ['contacts:read', 'contacts:write'])->plainTextToken;
```

Available permissions:
- `contacts:read` - View contacts
- `contacts:write` - Create, update, and delete contacts

## Adding CRM Token Manager to Profile Page

To add the CRM API token manager to your Jetstream profile page:

1. Open your profile page template (usually `resources/views/profile/show.blade.php`)

2. Add the CRM token manager section:
```blade
<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <!-- Existing profile sections -->
            @endif

            <!-- Add this section -->
            @include('crm::profile.crm-api-tokens')

            <!-- Other existing sections -->
        </div>
    </div>
</x-app-layout>
```

The CRM token manager will now appear in the user's profile page with the following features:

1. Create new API tokens with specific CRM permissions
2. View existing tokens and their permissions
3. Delete tokens that are no longer needed
4. Automatic inclusion of the required `crm:access` permission
5. Clear permission descriptions and grouping

## Testing

Run the tests with:

```bash
vendor/bin/phpunit packages/movve/crm
```

## Testing with Postman

1. Start your Laravel development server:
```bash
php artisan serve
```

2. Import the Postman collection:
   - Open Postman
   - Click "Import" button
   - Select the file: `packages/movve/crm/docs/Movve_CRM.postman_collection.json`
   - The collection "Movve CRM" will be imported with all endpoints

3. The collection includes:
   - List Contacts (GET)
   - Create Contact (POST)
   - Show Contact (GET)
   - Update Contact (PUT)
   - Delete Contact (DELETE)
   - Restore Contact (POST)

4. The base URL is set to `http://localhost:8000` by default. If your Laravel development server runs on a different port, you can:
   - Click on the collection name "Movve CRM"
   - Go to the "Variables" tab
   - Update the "base_url" value

5. Example usage:
   - To create a contact: Use the "Create Contact" request and modify the JSON body as needed
   - To search contacts: Use the "List Contacts" request and add your search term to the "search" query parameter
   - To update a contact: Use the "Update Contact" request, update the ID in the URL, and modify the JSON body

## License

Proprietary. All rights reserved.
