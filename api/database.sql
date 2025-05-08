CREATE DATABASE IF NOT EXISTS admission_bank;
USE admission_bank;

CREATE TABLE IF NOT EXISTS universities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type ENUM('Public', 'Private', 'National') NOT NULL,
    website VARCHAR(255),
    established_year INT,
    location VARCHAR(255),
    description TEXT,
    admission_requirements TEXT,
    application_deadline DATE,
    tuition_fee DECIMAL(10,2),
    contact_info TEXT,
    programs_offered TEXT,
    campus_facilities TEXT,
    ranking INT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS application_timeline (
    id INT PRIMARY KEY AUTO_INCREMENT,
    university_id INT NOT NULL,
    event_title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_description TEXT,
    event_type ENUM('Application', 'Document', 'Test', 'Interview', 'Result', 'Other') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data for 3 prominent Bangladeshi universities
INSERT INTO universities (name, type, website, established_year, location, description, admission_requirements, application_deadline, tuition_fee, contact_info, programs_offered, campus_facilities, ranking, image_url) VALUES
(
    'University of Dhaka',
    'Public',
    'https://www.du.ac.bd',
    1921,
    'Ramna, Dhaka-1000',
    'The oldest and most prestigious public university in Bangladesh, known for its academic excellence and rich history. The university has produced many notable alumni who have made significant contributions to the nation.',
    'HSC/A-Level with minimum GPA 3.5, Strong academic background, Admission test required for most departments',
    '2024-07-15',
    5000.00,
    'Phone: +880-2-9661900\nEmail: info@du.ac.bd\nAddress: Registrar\'s Office, University of Dhaka, Dhaka-1000',
    'Arts, Science, Business Studies, Engineering, Law, Medicine, Social Sciences, Fine Arts',
    'Central Library, TSC, Gymnasium, Sports Complex, Medical Center, Auditorium, Research Centers',
    1,
    'https://upload.wikimedia.org/wikipedia/en/thumb/c/cb/Dhaka_University_logo.svg/1200px-Dhaka_University_logo.svg.png'
),
(
    'North South University',
    'Private',
    'https://www.northsouth.edu',
    1992,
    'Bashundhara, Dhaka-1229',
    'One of the leading private universities in Bangladesh, known for its modern curriculum, international collaborations, and strong emphasis on research and innovation.',
    'HSC/A-Level with minimum GPA 3.0, English proficiency required, Department-specific admission tests',
    '2024-06-30',
    150000.00,
    'Phone: +880-2-55668200\nEmail: info@northsouth.edu\nAddress: Bashundhara, Dhaka-1229, Bangladesh',
    'Business Administration, Computer Science, Engineering, Architecture, Pharmacy, Economics, English',
    'Modern Library, Computer Labs, Research Centers, Sports Complex, Cafeteria, Auditorium',
    2,
    'https://seeklogo.com/images/N/north-south-university-logo-0CA3A4611D-seeklogo.com.png'
),
(
    'Bangladesh University of Engineering & Technology',
    'National',
    'https://www.buet.ac.bd',
    1962,
    'Palashi, Dhaka-1000',
    'The premier engineering university of Bangladesh, known for its rigorous academic standards and excellent research facilities. Produces top-quality engineers who contribute significantly to the nation\'s development.',
    'HSC with minimum GPA 5.0 in Science, Strong mathematics and physics background, Highly competitive admission test',
    '2024-05-15',
    8000.00,
    'Phone: +880-2-9665650\nEmail: registrar@buet.ac.bd\nAddress: Palashi, Dhaka-1000, Bangladesh',
    'Civil Engineering, Mechanical Engineering, Electrical Engineering, Computer Science, Architecture, Chemical Engineering',
    'Central Library, Research Laboratories, Computer Center, Sports Complex, Medical Center, Auditorium',
    3,
    'https://upload.wikimedia.org/wikipedia/en/thumb/d/da/BUET_LOGO.svg/1200px-BUET_LOGO.svg.png'
);

-- Add sample timeline data for University of Dhaka
INSERT INTO application_timeline (university_id, event_title, event_date, event_description, event_type) VALUES
(1, 'Application Form Available', '2024-05-01', 'Online application forms will be available on the university website', 'Application'),
(1, 'Application Deadline', '2024-07-15', 'Last date to submit completed application forms', 'Application'),
(1, 'Document Submission', '2024-07-20', 'Submit all required documents to the admission office', 'Document'),
(1, 'Admission Test', '2024-08-01', 'Written admission test for all applicants', 'Test'),
(1, 'Interview', '2024-08-15', 'Interview for shortlisted candidates', 'Interview'),
(1, 'Result Publication', '2024-08-30', 'Final admission results will be published', 'Result');

-- Add sample timeline data for North South University
INSERT INTO application_timeline (university_id, event_title, event_date, event_description, event_type) VALUES
(2, 'Application Form Available', '2024-04-01', 'Online application forms will be available on the university website', 'Application'),
(2, 'Application Deadline', '2024-06-30', 'Last date to submit completed application forms', 'Application'),
(2, 'Document Submission', '2024-07-05', 'Submit all required documents to the admission office', 'Document'),
(2, 'Admission Test', '2024-07-15', 'Written admission test for all applicants', 'Test'),
(2, 'Interview', '2024-07-25', 'Interview for shortlisted candidates', 'Interview'),
(2, 'Result Publication', '2024-08-05', 'Final admission results will be published', 'Result');

-- Insert new universities
INSERT INTO universities
(name, type, website, established_year, location, description, admission_requirements, application_deadline, tuition_fee, contact_info, programs_offered, campus_facilities, ranking, image_url)
VALUES
('University of Rajshahi', 'Public', 'https://www.ru.ac.bd', 1953, 'Rajshahi', 'A major public university in the north-west of Bangladesh, known for its beautiful campus and academic excellence.', 'HSC/A-Level with minimum GPA 3.5, Admission test required', '2024-07-20', 4500.00, 'Phone: +880-721-750244\nEmail: registrar@ru.ac.bd\nAddress: Rajshahi-6205, Bangladesh', 'Arts, Science, Business Studies, Engineering, Law, Social Sciences', 'Central Library, Medical Center, Sports Complex, Auditorium, Research Centers', 4, 'https://upload.wikimedia.org/wikipedia/en/6/6d/Rajshahi_University_logo.png'),

('Bangladesh Agricultural University', 'Public', 'https://www.bau.edu.bd', 1961, 'Mymensingh', 'The leading institution for agricultural studies and research in Bangladesh.', 'HSC/A-Level with Biology, Minimum GPA 3.5, Admission test required', '2024-07-25', 4000.00, 'Phone: +880-91-67401\nEmail: registrar@bau.edu.bd\nAddress: Mymensingh-2202, Bangladesh', 'Agriculture, Veterinary Science, Fisheries, Agricultural Engineering', 'Library, Research Farms, Medical Center, Sports Facilities', 5, 'https://upload.wikimedia.org/wikipedia/en/2/2e/Bangladesh_Agricultural_University_logo.png'),

('University of Chittagong', 'Public', 'https://www.cu.ac.bd', 1966, 'Chittagong', 'A large public university with a scenic campus, offering a wide range of disciplines.', 'HSC/A-Level with minimum GPA 3.5, Admission test required', '2024-07-22', 4200.00, 'Phone: +880-31-726311\nEmail: registrar@cu.ac.bd\nAddress: Chittagong-4331, Bangladesh', 'Arts, Science, Business Studies, Law, Social Sciences', 'Library, Shuttle Train, Medical Center, Sports Complex', 6, 'https://upload.wikimedia.org/wikipedia/en/7/7e/University_of_Chittagong_logo.png'),

('Jahangirnagar University', 'Public', 'https://www.juniv.edu', 1970, 'Savar, Dhaka', 'A fully residential public university, famous for its natural beauty and vibrant student life.', 'HSC/A-Level with minimum GPA 3.5, Admission test required', '2024-07-18', 4300.00, 'Phone: +880-2-7791045\nEmail: registrar@juniv.edu\nAddress: Savar, Dhaka-1342, Bangladesh', 'Arts, Science, Business Studies, Engineering, Law, Social Sciences', 'Residential Halls, Central Library, Medical Center, Sports Complex', 7, 'https://upload.wikimedia.org/wikipedia/en/2/2e/Jahangirnagar_University_logo.png'),

('Islamic University, Bangladesh', 'Public', 'https://www.iu.ac.bd', 1980, 'Kushtia', 'A public university offering a blend of Islamic and modern education.', 'HSC/A-Level with minimum GPA 3.0, Admission test required', '2024-07-28', 3500.00, 'Phone: +880-71-74904\nEmail: registrar@iu.ac.bd\nAddress: Kushtia-7003, Bangladesh', 'Arts, Science, Business Studies, Law, Theology', 'Library, Mosque, Medical Center, Sports Facilities', 8, 'https://upload.wikimedia.org/wikipedia/en/7/7d/Islamic_University_Bangladesh_logo.png'),

('Shahjalal University of Science & Technology', 'Public', 'https://www.sust.edu', 1986, 'Sylhet', 'A leading science and technology university in Bangladesh, known for its research and innovation.', 'HSC/A-Level with Science, Minimum GPA 3.5, Admission test required', '2024-07-30', 5000.00, 'Phone: +880-821-713491\nEmail: registrar@sust.edu\nAddress: Sylhet-3114, Bangladesh', 'Science, Engineering, Social Sciences, Business Studies', 'Library, Research Labs, Medical Center, Sports Complex', 9, 'https://upload.wikimedia.org/wikipedia/en/2/2e/Shahjalal_University_of_Science_and_Technology_logo.png'),

('Khulna University', 'Public', 'https://www.ku.ac.bd', 1991, 'Khulna', 'A multidisciplinary public university in the south-west of Bangladesh.', 'HSC/A-Level with minimum GPA 3.5, Admission test required', '2024-07-27', 3800.00, 'Phone: +880-41-731244\nEmail: registrar@ku.ac.bd\nAddress: Khulna-9208, Bangladesh', 'Science, Engineering, Arts, Business Studies, Social Sciences', 'Library, Medical Center, Sports Complex, Research Centers', 10, 'https://upload.wikimedia.org/wikipedia/en/7/7e/Khulna_University_logo.png'),

('National University', 'Public', 'https://www.nu.edu.bd', 1992, 'Gazipur', 'The largest public university in Bangladesh, affiliating numerous colleges across the country.', 'HSC/A-Level, Minimum GPA 2.5, Admission test required', '2024-08-01', 2000.00, 'Phone: +880-2-9291018\nEmail: info@nu.edu.bd\nAddress: Gazipur-1704, Bangladesh', 'Arts, Science, Business Studies, Law, Social Sciences', 'Library, Medical Center, Sports Facilities', 11, 'https://upload.wikimedia.org/wikipedia/en/7/7e/National_University_Bangladesh_logo.png'),

('Bangladesh Open University', 'Public', 'https://www.bou.ac.bd', 1992, 'Gazipur', 'The only public university for distance learning in Bangladesh.', 'HSC/A-Level, Minimum GPA 2.5, Open admission', '2024-08-10', 1500.00, 'Phone: +880-2-9291101\nEmail: info@bou.edu.bd\nAddress: Board Bazar, Gazipur-1705, Bangladesh', 'Arts, Science, Business Studies, Law, Social Sciences, Education', 'Library, Study Centers, Online Resources', 12, 'https://upload.wikimedia.org/wikipedia/en/7/7e/Bangladesh_Open_University_logo.png'),

('Bangabandhu Sheikh Mujib Medical University', 'Public', 'https://www.bsmmu.ac.bd', 1998, 'Dhaka', 'The premier postgraduate medical institution in Bangladesh.', 'MBBS, Internship, Admission test required', '2024-08-15', 6000.00, 'Phone: +880-2-55165088\nEmail: info@bsmmu.edu.bd\nAddress: Shahbag, Dhaka-1000, Bangladesh', 'Medical Sciences, Postgraduate Medicine, Surgery, Dentistry', 'Hospital, Library, Research Labs, Medical Center', 13, 'https://upload.wikimedia.org/wikipedia/en/7/7e/Bangabandhu_Sheikh_Mujib_Medical_University_logo.png');

-- Add sample timeline data for University of Rajshahi (ID 7)
INSERT INTO application_timeline (university_id, event_title, event_date, event_description, event_type) VALUES
(7, 'Admission Notice Publication', '2025-01-26', 'Official admission notice for the 2024-2025 academic year is published.', 'Announcement'),
(7, 'Primary Application Begins', '2025-01-27', 'Online primary application submission starts.', 'Application'),
(7, 'Primary Application Ends', '2025-02-05', 'Deadline for submitting the primary application.', 'Application'),
(7, 'Eligible Candidates List Publication', '2025-02-10', 'List of candidates eligible for final application will be published.', 'Result'),
(7, 'Final Application Phase 1', '2025-02-11', 'First phase of final application submission.', 'Application'),
(7, 'Final Application Phase 1 Ends', '2025-02-15', 'Deadline for the first phase of final application.', 'Application'),
(7, 'Final Application Phase 2', '2025-02-18', 'Second phase of final application submission.', 'Application'),
(7, 'Final Application Phase 2 Ends', '2025-02-20', 'Deadline for the second phase of final application.', 'Application'),
(7, 'Final Application Phase 3', '2025-02-23', 'Third phase of final application submission.', 'Application'),
(7, 'Final Application Phase 3 Ends', '2025-02-24', 'Deadline for the third phase of final application.', 'Application'),
(7, 'Admit Card Download Begins', '2025-03-04', 'Admit cards for the admission tests can be downloaded.', 'Admit Card'),
(7, 'Admit Card Download Ends', '2025-03-07', 'Last date to download admit cards.', 'Admit Card'),
(7, 'B Unit Admission Test', '2025-04-12', 'Admission test for B Unit.', 'Test'),
(7, 'A Unit Admission Test', '2025-04-19', 'Admission test for A Unit.', 'Test'),
(7, 'C Unit Admission Test', '2025-04-26', 'Admission test for C Unit.', 'Test'),
(7, 'B Unit Result Publication', '2025-04-17', 'Admission test results for B Unit will be published.', 'Result'),
(7, 'A Unit Result Publication', '2025-04-25', 'Admission test results for A Unit will be published.', 'Result'),
(7, 'C Unit Result Publication', '2025-05-03', 'Admission test results for C Unit will be published.', 'Result');