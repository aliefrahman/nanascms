# Nanas CMS

NanasCMS is a lightweight, self-hosted Content Management System built with modern PHP and a sleek, dark-themed design powered by Tailwind CSS.

## Features

- **Modern Dashboard**: A fully responsive admin interface with a dark, premium aesthetic.
- **Menu Management**: Intuitive interface to manage navigation menus for the frontend.
- **Social Media Integration**: Easy management of social media links with icons.
- **Contact Form**: Built-in contact form with database persistence.
- **SEO Tools**: Advanced SEO settings including meta tags, robots.txt, and sitemap.xml generation.
- **User Roles**: Role-based access control (Admin and Editor).
- **Theme Management**: Dynamic theme switching to maintain brand consistency.
- **Maintenance Mode**: Simple toggle to enable maintenance mode on the frontend.
- **Responsive Design**: Built with Tailwind CSS for a seamless experience across all devices.
- **File Management**: Dedicated section for managing file uploads and assets.
- **Customization**: Global company profile settings for easy branding.

## Setup

### Prerequisites

- PHP 8.2 or higher
- MySQL or MariaDB database

### Installation

1.  **Clone the repository:**

    ```bash
    git clone <repository-url>
    cd nanascms
    ```

2.  **Install Dependencies:**
    Ensure you have NPM installed. Run:

    ```bash
    npm install
    ```

3.  **Configure the Database:**
    - Copy the `.env.example` file to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Edit `.env` and set your database credentials:
      ```ini
      DB_HOST=localhost
      DB_DATABASE=nanascms
      DB_USERNAME=root
      DB_PASSWORD=your_password
      ```

4.  **Run Migrations & Seeders:**
    Run the following command to create the necessary tables and seed default data:

    ```bash
    php init.php
    ```

    This will:
    - Initialize the database.
    - Seed default admin user (`admin@admin.com` / `password`).
    - Create initial menu items and settings.

5.  **Access the Admin Panel:**
    - Navigate to `http://localhost/nanascms/public/admin` in your browser.
    - Log in with the credentials created in the previous step.

## Usage

### Adding Content

1.  Go to the **Dashboard**.
2.  Use the sidebar to navigate to **Menu Management**, **Social Media**, **SEO Settings**, **File Management**, **Theme Settings**, or **Company Profile**.
3.  Add or edit your content as needed.
4.  Changes will be reflected immediately on the frontend.

### Maintenance Mode

1.  Go to **Theme Settings**.
2.  Toggle the **Maintenance Mode** switch to enable or disable it.

## License

[MIT License](LICENSE)
