# Admission Bank

A comprehensive web application for exploring university admissions in Bangladesh, featuring detailed statistics, analytics, and university information management.

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

## Project Structure

```
admission-bank/
├── api/                # API endpoints and backend logic
│   ├── upload.php     # File upload handling
│   └── universities/  # University data endpoints
├── assets/            # Static assets
│   └── logo.png       # Site logo and favicon
├── css/               # Stylesheets
│   ├── style.css      # Main styles
│   ├── media.css      # Responsive styles
│   └── statistics.css # Statistics page styles
├── data/              # Data files
│   ├── public_universities.json
│   ├── private_universities.json
│   └── statistics.json
├── js/                # JavaScript files
│   ├── script.js      # Main scripts
│   └── statistics.js  # Statistics page scripts
└── index.html         # Main entry point
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
- `GET /api/universities` - Get all universities
- `GET /api/universities/public` - Get public universities
- `GET /api/universities/private` - Get private universities
- `GET /api/universities/search?q={query}` - Search universities
- `GET /api/universities/{id}` - Get university by ID
- `POST /api/universities` - Add new university
- `PUT /api/universities/{id}` - Update university
- `DELETE /api/universities/{id}` - Delete university

### Statistics
- `GET /api/statistics/admission-rates` - Get admission rate trends
- `GET /api/statistics/seat-distribution` - Get program-wise seat distribution
- `GET /api/statistics/cutoff-marks` - Get cutoff marks data
- `GET /api/statistics/test-stats` - Get admission test statistics

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
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser
- Node.js and npm (for frontend development)

### Running Locally
1. Start your local server (e.g., XAMPP, WAMP)
2. Navigate to `http://localhost/admission-bank`
3. For development, enable error reporting in PHP

### Code Style
- Follow PSR-12 for PHP code
- Use ESLint for JavaScript
- Follow BEM methodology for CSS

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
