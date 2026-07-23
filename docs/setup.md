# Setup Guide

## Requirements

- PHP 8+
- MySQL
- WordPress
- LocalWP (recommended for development)

---

# Installation

## 1. Install WordPress

Create a new WordPress installation.

Recommended local environment:

LocalWP

---

## 2. Install Theme

Copy the child theme:


wp-content/themes/generatepress-child


Activate:

WordPress Admin → Appearance → Themes → GeneratePress Child

---

## 3. Install Plugins

Install all required plugins listed in:


docs/plugins.md


---

## 4. Database Import

Import the database backup:


database/e-pharmacy.sql


or use your local SQL backup.

Tools:

- phpMyAdmin
- Adminer
- LocalWP database manager

---

## 5. Configure WordPress

Update:

- Site URL
- Permalinks
- WooCommerce settings
- Menu locations
- Widgets / Blocks

---

## 6. Media Files

Copy uploaded media files:


wp-content/uploads


(if available)

---

## Development

Theme files:


wp-content/themes/generatepress-child


Main files:

- functions.php
- style.css
- inc/
- assets/
