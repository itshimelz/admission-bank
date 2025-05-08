# Admission Bank

A web application to explore university admissions in Bangladesh.

## Features
- Browse public and private universities
- Filter by type and search by name or website
- Scrollable ticker showcasing upcoming admissions
- Detailed university info pages
- Sticky category banner and back-to-top button
- RESTful API endpoints for university data
- Responsive design for all devices
- Real-time search and filtering

## API Endpoints

### Universities
- `GET /api/universities` - Get all universities
- `GET /api/universities/public` - Get public universities
- `GET /api/universities/private` - Get private universities
- `GET /api/universities/search?q={query}` - Search universities
- `GET /api/universities/{id}` - Get university by ID

## Installation

1. Clone the repo:
   ```bash
   git clone https://github.com/itshimelz/admission-bank.git
   cd admission-bank
   ```
2. Open `index.html` in your browser.

## Usage

- Use the dropdown to filter universities by category
- Type in the search bar to search
- Scroll through the ticker and click a university to view details
- Access API endpoints for programmatic access to university data

## Development

Edit HTML, CSS, and JS under the project folder. Run a local server if needed.

### Project Structure
```
admission-bank/
├── api/            # API endpoints
├── css/           # Stylesheets
├── js/            # JavaScript files
├── data/          # JSON data files
└── index.html     # Main entry point
```

## License
MIT
