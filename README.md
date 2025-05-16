# Admission Bank

A comprehensive web application for exploring university admissions in Bangladesh, featuring detailed statistics, analytics, and university information management. Now with enhanced features including admin dashboard, timeline management, and improved data handling.

## Features

### Core Features
- Browse public and private universities
- Filter by type and search by name or website
- Scrollable ticker showcasing upcoming admissions
- Detailed university info pages
- Sticky category banner and back-to-top button
- RESTful API endpoints for university data
- Responsive design for all devices
- Real-time search and filtering
- Secure admin authentication system
- Timeline management for admission events
- News and updates section

### Statistics & Analytics
- Admission rate trends visualization
- Program-wise seat distribution charts
- Previous year cutoff marks analysis
- Admission test statistics
- Interactive charts and graphs
- Filterable data views

### University Management
- University information upload system
- Data validation and verification
- Image upload support
- Admin dashboard for content management
- Timeline event management
- News and announcements system
- Secure file handling
- Bulk university import functionality

## Project Structure

```
admission-bank/
├── api/                    # API endpoints and backend logic
│   ├── admin-login.php     # Admin authentication
│   ├── check-auth.php      # Session verification
│   ├── get-news.php        # News API endpoint
│   ├── helpers/            # Helper classes
│   │   └── Response.php    # Standardized API responses
│   ├── import_universities.php # Bulk import
│   ├── models/             # Data models
│   │   └── TimelineEvent.php
│   ├── sql/                # Database scripts
│   ├── timeline_events.php # Timeline management
│   └── university_upload.php # University data handling
├── css/                   # Stylesheets
│   ├── style.css          # Main styles
│   ├── news-updates.css   # News section styles
│   └── media.css          # Responsive styles
├── js/                    # JavaScript files
│   ├── script.js          # Main scripts
│   ├── university.js      # University page logic
│   ├── timeline.js        # Timeline display
│   ├── news-updates.js    # News section logic
│   └── timeline-management.js # Admin timeline controls
├── admin-login.html       # Admin login page
├── timeline-management.php # Timeline admin interface
└── index.php              # Main entry point
```

## Database Integration

### Database Structure
```sql
-- Universities Table
CREATE TABLE universities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type ENUM('public', 'private', 'national') NOT NULL,
    website VARCHAR(255),
    location VARCHAR(255),
    established_year INT,
    description TEXT,
    logo_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Programs Table
CREATE TABLE programs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    university_id INT,
    name VARCHAR(255) NOT NULL,
    duration INT,
    seats INT,
    requirements TEXT,
    FOREIGN KEY (university_id) REFERENCES universities(id)
);

-- Admission Statistics Table
CREATE TABLE admission_statistics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    university_id INT,
    program_id INT,
    year INT,
    applied INT,
    appeared INT,
    passed INT,
    selected INT,
    cutoff_marks DECIMAL(5,2),
    FOREIGN KEY (university_id) REFERENCES universities(id),
    FOREIGN KEY (program_id) REFERENCES programs(id)
);
```

## API Endpoints

### Universities
- `GET /api/read.php` - Get all universities
- `GET /api/read_one.php?name={university_name}` - Get university by name
- `POST /api/upload.php` - Upload university information and images
- `POST /api/university_upload.php` - Handle university data uploads
- `POST /api/import_universities.php` - Bulk import universities

### Authentication
- `POST /api/admin-login.php` - Admin login
- `GET /api/check-auth.php` - Verify admin session

### Timeline & News
- `GET /api/timeline_events.php` - Get all timeline events
- `POST /api/timeline_events.php` - Create/update timeline events
- `GET /api/get-news.php` - Get latest news and updates

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/itshimelz/admission-bank.git
   cd admission-bank
   ```

2. Set up the database:
   - Create a MySQL database
   - Import the database schema from `database/schema.sql`
   - Configure database connection in `api/config.php`

3. Configure the web server:
   - Point your web server to the project directory
   - Ensure PHP is installed and configured
   - Set up proper permissions for file uploads

4. Install dependencies:
   ```bash
   # If using npm
   npm install
   
   # If using composer
   composer install
   ```

5. Configure environment variables:
   - Copy `.env.example` to `.env`
   - Update database credentials and other settings

## Development

### Prerequisites
- PHP 8.0 or higher
- MySQL 5.7 or higher / MariaDB 10.3+
- Modern web browser (Chrome, Firefox, Edge, Safari)
- Node.js 16+ and npm 8+
- Composer 2.0+

### Running Locally
1. Start your local development server (XAMPP, WAMP, or `php -S`)
2. Navigate to `http://localhost/admission-bank`
3. Development settings:
   - Enable error reporting in PHP
   - Set `APP_ENV=development` in `.env`
   - Enable debug mode for detailed error messages

### Development Workflow
1. Create a feature branch: `git checkout -b feature/your-feature`
2. Make your changes
3. Run tests (if available)
4. Commit with descriptive messages
5. Push to your fork and create a pull request

### Code Style & Standards
- PHP: Follow PSR-12 and PSR-4 autoloading
- JavaScript: Use ES6+ syntax, ESLint with recommended rules
- CSS: BEM methodology with SCSS
- Database: Use migrations for schema changes
- Security: Always validate and sanitize user input
- Performance: Optimize database queries and use caching where appropriate

### Testing
- Write unit tests for new features
- Test across different browsers and devices
- Verify form validations and error handling
- Test with different user roles (admin/guest)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License
MIT License - See LICENSE file for details

## Support
For support, email support@admissionbank.com or create an issue in the repository.

## Acknowledgments
- Chart.js for data visualization
- Bootstrap for UI components
- All contributors and supporters