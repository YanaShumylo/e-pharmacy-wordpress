# E-Pharmacy WordPress

Custom online pharmacy website built with WordPress.

The project was developed using Gutenberg blocks, GeneratePress Child Theme, WooCommerce and custom WordPress functionality.

---

## Project Overview

E-Pharmacy is a responsive pharmacy website that includes:

- medicine catalog;
- pharmacy store information;
- WooCommerce integration;
- custom content management;
- product filtering;
- user authentication forms;
- SEO and performance optimization.

---

## Technologies

### CMS

- WordPress

### Theme

- GeneratePress
- GeneratePress Child Theme

### Editor & Blocks

- Gutenberg
- GenerateBlocks

### E-commerce

- WooCommerce

### Custom Development

- PHP
- WordPress Hooks
- Custom Post Types
- Advanced Custom Fields PRO

### Plugins

- Custom Post Type UI
- Filter Everything — WordPress & WooCommerce Filters
- Rank Math SEO
- LiteSpeed Cache
- ShortPixel Image Optimizer
- Block Visibility

---

## Theme

Custom child theme:


wp-content/themes/generatepress-child


Theme structure:


generatepress-child
│
├── assets
│ ├── css
│ ├── js
│ └── images
│
├── inc
│ ├── header.php
│ ├── medicine.php
│ ├── medicine-stores.php
│ ├── register-form.php
│ ├── login-form.php
│ └── reviews-slider.php
│
├── template-parts
│
├── functions.php
└── style.css


---

## Features

Implemented:

- custom header;
- responsive navigation;
- medicine catalog;
- pharmacy stores section;
- custom fields integration;
- custom post types;
- WooCommerce functionality;
- custom registration and login forms;
- reviews slider;
- responsive layouts.

---

## Performance Optimization

Implemented:

- LiteSpeed Cache configuration;
- image optimization;
- WebP images;
- CSS and JavaScript optimization;
- Core Web Vitals analysis;
- Lighthouse performance testing.

---

## SEO

Implemented:

- Rank Math SEO configuration;
- meta titles and descriptions;
- XML sitemap;
- canonical URLs;
- image alt attributes;
- structured content.

---

## Installation

### Local setup

1. Install WordPress locally using LocalWP.

2. Install required plugins:


docs/plugins.md


3. Import database:


database/README.md


4. Copy theme:


wp-content/themes/generatepress-child


5. Activate GeneratePress Child Theme.

6. Configure WooCommerce settings.

7. Update site URL after database import.

---

## Database

Database backup is stored separately because it contains private WordPress data.

Restore instructions:


database/README.md


---

## Development Environment

Local environment:


LocalWP


Version control:


Git + GitHub


---

## License

This project is created for portfolio purposes.