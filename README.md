# MasjidTech - Mosque Event & Announcement System

## Group Information

**Group Name**: WebApp  
**Section**: 1  
**Course Code**: BIIT 2305 (Web Application Development)  
**Lecturer**: Dr. Nor Azura Binti Kamarulzaman  

**Group Members** :
- NURUL IZZAH BINTI ZUBLI - 2414054
- AIRIEL HAZIQ BIN ABDUL KARIM - 2416055
- MUHAMAD FAUZI BIN ABDUL RAHIM - 2412657
- ABDUL DZAAHIR BIN IDZWAN - 2410443
- MUHAMMAD FITRI BIN RAZMAN - 2414149
- NURUL ATIKA BINTI RAMLI - 2410746

## Project Overview

### Introduction
MasjidTech is a dynamic web application built to bridge the communication gaps existing between mosque administrations and local congregation communities. By consolidating religious scheduling, official mosque updates, and community workflows into an integrated digital hub using the Laravel framework, the platform updates traditional physical noticeboards, posters, and scattered notifications. This unified, Shariah-compliant digital management environment provides administrative transparency, real-time access, and optimized engagement paradigms for everyday community members.

## Project Objectives

- Primary Goal: Centralize religious tracking, operational messaging pipelines, and local community registrations into one digital platform.
- Technical Goal: Implement a high-performance web architecture leveraging Laravel's Model-View-Controller (MVC) components for robust data lifecycle segregation.
- User Experience Goal: Deploy an accessible, intuitive layout using a Mobile-First engineering methodology to guarantee readability across all user hardware devices.
- Operational Efficiency Goal: Minimize manual recording errors and administrative constraints via automated scheduling and secure CRUD backends.

## Target Users

- Congregation Members: Local kariah residents looking to access real-time prayer calendars, announcements, and simple event registration workflows.
- Mosque Administrators: Committee managers responsible for publishing announcements, processing event listings, and tracking group sign-ups.

## Features and Functionalities

**Congregation Member Features**
- User Authentication & Profiles: Secure, role-segregated login and registration processes to access protected features.
- Interactive Live Dashboard: A real-time hub tracking daily localized prayer timetables along with an automated, dynamic countdown clock for upcoming obligatory prayers.
- Shariah Broadcaster Feed: Access to an integrated chronological timeline for administrative updates, religious rules, and financial transparency statements.
- Event Discovery Directory: A categorized calendar block detailing specific upcoming religious classes, community service projects, and developmental seminars.
- Lightweight Seat Reservation: Instant, modal-driven registration tracking that enables logged-in members to claim remaining spots for mosque programs.
- Digital Donations Tracking: Integration tracing personal contribution history, payment configurations, and donation status metrics.

**Admin Features**
- Core Node Administrative Control Center: A restricted dashboard overview presenting operational key performance indicators (KPIs), membership charts, and transaction metrics.
- Event Lifecycle CRUD Operations: Complete administrative backend tools enabling operators to Create, Read, Update, and Delete mosque events.
- Administrative Dispatches Hub: Dynamic validation interfaces allowing admins to write content, upload reference images, and publish real-time notices directly to the public feed.
- Media Upload Manager: A secure asset tracking directory created to store project assets, event posters, documents, and reference PDFs safely.

## Technical Implementation

**Technology Stack**
- Backend Framework: Laravel (MVC Architecture)
- Frontend Engine: Laravel Blade Templates enhanced with custom structural styles
- Iconography: FontAwesome Icon Library Sets
- Database Engine: MySQL 8.x
- Development Environment: XAMPP

**Database Design**

### Database Schema Overview
The database schema uses highly normalized relational tables optimized to maintain structural data integrity and eliminate metadata redundancies:

- users: Holds profile details, encryption keys, and system roles separating general congregation members from administrators.
- events: Houses program tracking records such as locations, dates, descriptions, maximum participant constraints, and poster links.
- event_registrations: Resolves the many-to-many relationship mapping users onto specific events, recording transaction dates and confirmation flags.
- announcements: Logs system bulletins, written body segments, metadata references, and parent administrator tracking IDs.
- donations: Logs structural transactional records tracking amounts, payment types, execution dates, and success metrics.
- media_uploads: Central asset logging index referencing file structures, formats, upload parameters, and relevant structural event attachments.
- prayer_times: A structural directory holding accurate daily operational schedules for the five core obligations.

### Entity Relationship Diagram (ERD)
https://docs.google.com/document/d/1Q7cDGSZvzuLxEoxZFei0PflQVc-RS1E-MRNyEiPzsIg/edit?usp=sharing

Key Relationships:
- Admin to Content Execution (One-to-Many): One administrator profile can manage, author, and deploy multiple announcements and event records.
- User to Event Registration (Many-to-Many): Handled via the `event_registrations` table; one individual can register for multiple events, and each event targets many participants.
- User to Contribution Engine (One-to-Many): A specific congregation member can execute multiple unique donation instances over time.

**Laravel Components Implementation**

- Routes (`routes/web.php`)

php
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Member Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Protected Routes
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
});

- Controllers

*Main Controllers Implemented are below :*

1. HomeController: Manages the landing page and public prayer time data.
2. EventController: Handles CRUD operations and utilizes strict pessimistic locking (lockForUpdate()) within database transactions to prevent over-registration race conditions.
3. AnnouncementController: Manages the creation and display of mosque bulletins.
4. DonationController: Validates and securely processes incoming community contributions following strict MVC principles.
5. ProfileController: Handles user account updates and security.
6. DashboardController & MemberDashboardController: Aggregates dynamic KPIs for respective user roles.

- Models and Relationships

// User Model
class User extends Authenticatable {
    public function registrations() {
        return $this->hasMany(EventRegistration::class);
    }
}

// Event Model  
class Event extends Model {
    public function registrations() {
        return $this->hasMany(EventRegistration::class);
    }
}

// Announcement Model
class Announcement extends Model {
    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

- Views and User Interface

*Blade Templates Structure:*

1. layouts/app.blade.php - Primary site layout
2. welcome.blade.php - Public mosque landing page and hero section
3. dashboard.blade.php - Secure member dashboard
4. events/index.blade.php - Event directory listing
5. admin/dashboard.blade.php - Administrator control center
6. admin/events/create.blade.php - Event creation interface


*Design Features:*

1. Responsive Design: Custom CSS for mobile and desktop compatibility.
2. Color Scheme: Professional Emerald Green and White theme.
3. Navigation: Role-based navigation bars for guests, members, and admins.
4. Interactive Elements: Real-time countdown clock and dynamic event cards.

## User Authentication System

### ** Authentication Features **
1. Registration System: Secure account creation with automated role assignment.
2. Login System: Secure authentication handled via Laravel Breeze components.
3. Password Protection: Industry-standard Bcrypt hashing for all user credentials.
4. Role-Based Access: Dedicated middleware to separate member and admin access levels.
5. Profile Management: Update user metadata and security settings.

### ** Security Measures **
1. CSRF protection enabled on all form submissions.
2. Middleware guards for protected administrative routes.
3. Input validation to prevent SQL injection and XSS attacks.
4. Secure session management via Laravel's native drivers.

## Installation and Setup Instructions

### Prerequisites :
- PHP >= 8.1
- Composer
- Node.js and NPM
- MySQL 8.0
- XAMPP/Laragon 

### Step-by-Step Installation :
1. Clone the Repository
git clone https://github.com/Fauzi4649/masjidtech.git
cd masjidtech

2. Install PHP Dependencies

composer install

3. Install Node Dependencies

npm install
npm run build

4. Environment Configuration

cp .env.example .env
php artisan key:generate

Then open .env and set your database credentials, for example:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=masjidtech
DB_USERNAME=root
DB_PASSWORD=

5. Create the Database (if using MySQL)

CREATE DATABASE masjidtech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

6. Run Migrations & Seeders

php artisan migrate --seed

7. Create Storage Link (for image uploads)

php artisan storage:link

8. Start the server

php artisan serve
Visit http://127.0.0.1:8000

9. Default Login Credentials
ROLE	EMAIL	               PASSWORD
Admin	admin@masjidtech.com   password  //ONLY ONE ADMIN AVAILABLE
Member	member@example.com	   password
You can also register new members from the homepage.

## Testing and Quality Assurance

### Functionality Testing
- Role-based login and registration system verification.
- Real-time prayer time display accuracy.
- Event creation and registration CRUD workflow.
- Capacity limit validation for seat reservations.
- Announcement publishing and image upload testing.
- Dashboard metric accuracy for administrators.
- Responsive UI testing on mobile and tablet views.


### Browser Compatibility
-  Google Chrome (Latest)
-  Mozilla Firefox (Latest)
-  Safari (Latest)
-  Microsoft Edge (Latest)

### Performance Testing
- Database query optimization for fast page loads.
- Efficient media handling for announcement images.
- Minimal CSS/JS asset footprints.

## Challenges Faced and Solutions

### Challenge 1: Real-time Countdown Synchronization
- Problem: Discrepancy between server-side prayer times and client-side countdown clocks.
- Solution: Synced JavaScript countdowns with server-provided UTC timestamps for accuracy.

### Challenge 2: Event Capacity Handling
- Problem: Potential for over-registration when multiple users click "Register" simultaneously.
- Solution: Implemented pessimistic database transaction locks (DB::transaction and lockForUpdate()) to verify real-time seat availability before finalizing records securely.

### Challenge 3: Secure Asset Management
- Problem: Handling public access to administrative file uploads (posters).
- Solution: Used Laravel's storage:link to securely map private assets to the public directory.

## Future Enhancements

### Phase 2 Features (Potential Improvements)
- WhatsApp Integration: Automated notifications for event registrations.
- Online Donation Gateway: Integration with Billplz or ToyyibPay for secure payments.
- GPS Location: Automated prayer time fetching based on user coordinates.
- Rating System: Member feedback on mosque programs and events.
- Mobile App: Dedicated iOS and Android versions for easier access.

### Scalability Considerations
- Implementation of caching for frequently accessed prayer data.
- API development for integration with mosque electronic display boards.

## Learning Outcomes

### Technical Skills Gained
- Laravel Framework: Mastery of MVC patterns and Eloquent relationships.
- Database Management: Designing normalized schemas for complex community data.
- UI/UX Design: Creating accessible interfaces for diverse age groups.
- Security Implementation: Applying middleware and role-based access controls.

### Soft Skills Developed
- Team Collaboration : Synchronizing development tasks among group members.
- Project Management : Planning development phases to meet academic deadlines.
- Problem Solving : Debugging complex logical errors in registration flows.


## Conclusion

MasjidTech successfully provides a comprehensive digital management system for mosques using the Laravel framework. The project demonstrates a strong proficiency in full-stack web development, including secure authentication, relational database design, and responsive user interface construction.

### Key Achievements
- Successfully implemented the full Laravel MVC architecture.
- Developed a functional role-based management system (Admin and Member).
- Created a real-time religious tracking dashboard.
- Applied industry-standard security practices for data protection.
- Delivered a user-friendly design tailored for community engagement.

### Project Impact
This project provides a scalable foundation for modernizing mosque operations and provides group members with real-world experience in building secure, data-driven web applications.

## References

1. Laravel Documentation. (2026). Laravel Documentation. Retrieved from https://laravel.com/docs
2. Bootstrap Documentation. (2026). Bootstrap Documentation. Retrieved from https://getbootstrap.com/docs
3. JAKIM. (2026). E-Solat API and Prayer Time Data.
4. MDN Web Docs. (2026). Web Development Resources.
4. Stack Overflow. (2026). Developer Q&A and Troubleshooting.

- Project Completion Date: 10/06/2026

- Course: BIIT 2305 Intelligent Systems