# TODO: Add Image to Blog, Admin Resources, and Announcements

## 1. Add Image to Blogs
- [x] Create migration to add 'image' column to blogs table
- [x] Update Blog model to include 'image' in fillable

## 2. Modify Resources for Admin Creation
- [x] Create migration to add 'admin_id' to resources table and make 'teacher_id' nullable
- [x] Update Resource model to include 'admin_id' in fillable, add relation to User, make teacher_id nullable

## 3. Create Announcements Feature
- [x] Create migration for announcements table (id, title, body, date, user_id, timestamps)
- [x] Create Announcement model with fillable ['title', 'body', 'date', 'user_id'], casts for date, relation to User

## 4. Update AdminController
- [x] Add createResource method for admins
- [x] Add getResources method (public access)
- [x] Add createAnnouncement method
- [x] Add getAnnouncements method (public access)
- [x] Add updateAnnouncement method
- [x] Add deleteAnnouncement method

## 5. Update Routes
- [x] Add admin routes for resources (create, update, delete)
- [x] Add public routes for resources (get)
- [x] Add admin routes for announcements (create, update, delete)
- [x] Add public routes for announcements (get)

## 6. Run Migrations
- [x] Execute php artisan migrate

## 7. Test Endpoints
- [x] Test blog creation with image
- [x] Test admin resource creation
- [x] Test public resource access
- [x] Test announcement creation and public access
