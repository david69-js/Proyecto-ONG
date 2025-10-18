# User Management Module

This document describes the comprehensive user management module implemented for the ONG (Non-Governmental Organization) management system.

## Overview

The user module has been completely redesigned and implemented in English with a robust role-based permission system. It follows Laravel best practices and includes proper migration naming conventions.

## Database Structure

### Migrations (in execution order)

1. **00__parent_user** - Main users table with core user information
2. **11__user_profiles** - Extended user profile information
3. **12__user_roles** - Role management system
4. **13__user_permissions** - Permission system with role and user assignments

### Tables

- `users` - Core user information
- `user_profiles` - Extended profile data
- `roles` - Available roles in the system
- `user_roles` - Many-to-many relationship between users and roles
- `permissions` - Available permissions
- `role_permissions` - Many-to-many relationship between roles and permissions
- `user_permissions` - Direct user permission assignments

## Models

### User Model (`app/Models/User.php`)
- Comprehensive user model with relationships
- Role and permission management methods
- Scopes for filtering (active, verified)
- Full name accessor

### UserProfile Model (`app/Models/UserProfile.php`)
- Extended user information
- Age calculation
- Full address formatting

### Role Model (`app/Models/Role.php`)
- Role management with permissions
- Scopes for active roles and ordering

### Permission Model (`app/Models/Permission.php`)
- Permission management
- Module-based organization
- Scopes for filtering and ordering

## Controllers

### UserController (`app/Http/Controllers/UserController.php`)
- Complete CRUD operations
- Search and filtering functionality
- Role and permission management
- User status management
- Comprehensive validation

## Routes

All routes follow RESTful conventions with English naming:

```php
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    Route::get('/{user}/permissions', [UserController::class, 'permissions'])->name('permissions');
    Route::put('/{user}/permissions', [UserController::class, 'updatePermissions'])->name('update-permissions');
});
```

## Views

### User Management Views
- `users/index.blade.php` - User listing with search and filters
- `users/create.blade.php` - User creation form
- `users/edit.blade.php` - User editing form
- `users/show.blade.php` - User details view
- `users/permissions.blade.php` - Permission management

### Layout
- `layouts/app.blade.php` - Main application layout with navigation

## Features

### User Management
- Create, read, update, delete users
- Search by name or email
- Filter by role and status
- User activation/deactivation
- Comprehensive user profiles

### Role System
- Predefined roles: Super Admin, Admin, Coordinator, Volunteer
- Role-based permissions
- Easy role assignment and management

### Permission System
- Module-based permission organization
- Direct user permission assignments
- Role-based permission inheritance
- Granular permission control

### User Profiles
- Extended user information
- Emergency contact details
- Address management
- Bio and personal information

## Default Roles and Permissions

### Roles
1. **Super Administrator** - Full system access
2. **Administrator** - Most administrative functions
3. **Coordinator** - Volunteer and activity management
4. **Volunteer** - Basic participation access

### Permission Modules
- **Users** - User management permissions
- **Roles** - Role management permissions
- **Activities** - Activity/project management
- **Reports** - Report viewing and exporting

## Usage

### Running Migrations
```bash
# Using Docker
docker-compose exec app php artisan migrate

# Or run the seeder to populate roles and permissions
docker-compose exec app php artisan db:seed
```

### Accessing the User Module
- Navigate to `/users` to view the user management interface
- Use the navigation menu to access different sections
- Default admin user: admin@ong.com (password from factory)

## Security Features

- Password hashing
- CSRF protection
- Input validation
- Role-based access control
- Permission-based feature access
- Prevention of deleting last super admin

## Future Enhancements

- User avatar upload
- Email verification system
- Password reset functionality
- User activity logging
- Advanced search and filtering
- Bulk user operations
- User import/export

## Notes

- All text and variables are in English
- Migration files follow the naming convention: `00__parent_user`, `11__child_table`
- The system is designed to be extensible and maintainable
- Follows Laravel best practices and conventions
