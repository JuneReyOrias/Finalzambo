🌾 Zambo AgriMap
Zambo AgriMap is a web-based agricultural and geo-mapping system designed to support the rice farming sector in Zamboanga City. The system leverages Geographic Information System (GIS) technology to centralize, manage, and visualize critical agricultural data — enabling stakeholders to make informed decisions, monitor productivity, and implement strategic measures for sustainability and growth.

📌 Purpose
The primary goal of Zambo AgriMap is to provide a digital platform that empowers local government units, agricultural officers, and farmers with real-time data insights. By integrating geospatial mapping and agriculture data management, the system enhances planning, resource allocation, and support services aimed at improving rice farming productivity across the city.

🎯 Specific Objectives
GIS-Based Mapping
Utilize GIS technology to create a comprehensive agricultural map of Zamboanga City. This map offers a detailed view of the agricultural landscape and highlights areas with potential for new agricultural development.

Data Collection & Analysis
Gather and analyze key data factors that influence agricultural productivity, such as rice field locations, environmental conditions, and the socio-economic status of farmers in the city.

Interactive Web Platform
Develop a user-friendly web platform that enables users to:

Manage rice field data, including GPS-based locations

Maintain farmer profiles and production records

Track crop yields and generate reports

Use an interactive map to view and plot agricultural fields
The platform is built to be functional, usable, and reliable, and will be evaluated based on these criteria.


Laravel Installation using XAMPP (Localhost) + Deployment to Hostinger
🔧 Local Installation (XAMPP)
Step 1: Install Requirements
Download and install XAMPP

Download and install Composer

Step 2: Create a Laravel Project
Open your terminal or command prompt.

Run the following command:

composer create-project laravel/laravel your-project-name
Step 3: Move Project to XAMPP Directory
Move the entire project folder to:


C:\xampp\htdocs\
Step 4: Configure Virtual Host (Optional but Recommended)
Open: C:\xampp\apache\conf\extra\httpd-vhosts.conf

Add:

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/your-project-name/public"
    ServerName your-project.local
    <Directory "C:/xampp/htdocs/your-project-name">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
Then edit your hosts file (located at C:\Windows\System32\drivers\etc\hosts) and add:


127.0.0.1 your-project.local
Step 5: Start XAMPP Services
Open XAMPP Control Panel.

Start Apache and MySQL.

Step 6: Set Up Database
Open http://localhost/phpmyadmin

Create a new database (e.g., laravel_db)

In your Laravel project’s .env file, update:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=
Step 7: Run Migrations
Open terminal in your project directory and run:


php artisan migrate
🌐 Deploying to Hostinger
Step 8: Upload Project
Compress your Laravel project (except vendor and node_modules) and upload it to the public_html directory via Hostinger File Manager or FTP.

Step 9: Move Public Folder Contents
Move all files from the public folder to the root of public_html.

Step 10: Update index.php Paths
In public_html/index.php, change:

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
to:

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
Step 11: Configure .env for Production
Update your .env file with Hostinger database credentials.

Step 12: Install Dependencies (Hostinger)
Use Hostinger’s Terminal/SSH to run:


composer install
php artisan migrate
php artisan key:generate

📘 Useful Links
Laravel Migrations Guide
Hostinger Laravel Hosting Tutorial
