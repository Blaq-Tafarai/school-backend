# School Management System API

A comprehensive Laravel REST API for school management with role-based permissions.

## Features

- **Role-based Authentication**: Admin, Teacher, and Student roles with specific permissions
- **User Management**: CRUD operations for students and teachers
- **Classroom Management**: Assign students and teachers to classrooms
- **Academic Management**: Assignments, grades, attendance tracking
- **Content Management**: Events, blogs, gallery, resources
- **Communication**: Contact forms and admissions

## Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Seed the database: `php artisan db:seed`
7. Start the server: `php artisan serve`

## API Endpoints

### Authentication
- `POST /api/login` - Login
- `POST /api/logout` - Logout (authenticated)
- `GET /api/user` - Get current user (authenticated)

### Admin Endpoints (role: admin)
- `GET /api/admin/dashboard` - Admin dashboard
- `GET/POST/PUT/DELETE /api/admin/students` - Student management
- `GET/POST/PUT/DELETE /api/admin/teachers` - Teacher management
- `GET/POST/PUT/DELETE /api/admin/classrooms` - Classroom management
- `GET/POST/PUT/DELETE /api/admin/events` - Event management
- `GET/POST/PUT/DELETE /api/admin/blogs` - Blog management
- `GET/POST/PUT/DELETE /api/admin/gallery` - Gallery management
- `GET /api/admin/contacts` - View contacts
- `GET /api/admin/admissions` - View admissions

### Teacher Endpoints (role: teacher)
- `GET /api/teacher/dashboard` - Teacher dashboard
- `GET /api/teacher/students` - Students in assigned classroom
- `GET/POST/PUT/DELETE /api/teacher/assignments` - Assignment management
- `GET/POST/PUT/DELETE /api/teacher/grades` - Grade management
- `GET/POST /api/teacher/attendance` - Attendance management
- `GET/POST/PUT/DELETE /api/teacher/resources` - Resource management

### Student Endpoints (role: student)
- `GET /api/student/dashboard` - Student dashboard
- `GET /api/student/profile` - Student profile
- `GET /api/student/attendance` - View attendance
- `GET /api/student/grades` - View grades
- `GET /api/student/assignments` - View assignments
- `GET /api/student/resources` - View resources

### Public Endpoints
- `POST /api/contact` - Submit contact form
- `POST /api/admission` - Submit admission form
- `GET /api/events` - View events
- `GET /api/blogs` - View blogs
- `GET /api/gallery` - View gallery

## Default Admin Credentials

- **Username**: admin001
- **Password**: 1990-01-01 (DOB format)

## Database Schema

The system uses MySQL with the following main tables:
- users (with roles and permissions)
- classrooms
- students
- teachers
- assignments
- grades
- attendances
- resources
- events
- blogs
- galleries
- contacts
- admissions

## Authentication

Uses Laravel Sanctum for API authentication. Include the Bearer token in the Authorization header for protected routes.

## Permissions

- **Admin**: Full access to all resources
- **Teacher**: Access to classroom-specific students, assignments, grades, attendance, resources
- **Student**: Read-only access to personal data, grades, assignments, resources

## Testing

Run tests with: `php artisan test`

## License

This project is open-sourced software licensed under the MIT license.
