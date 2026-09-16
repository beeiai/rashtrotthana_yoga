# Rashtrotthana Yoga Website

## System Architecture

**Document:** `architecture.md`
**Project:** Rashtrotthana Yoga Website
**Platform:** WordPress
**Version:** 1.0
**Status:** Development Architecture
**Primary CMS:** WordPress
**Database:** MySQL / MariaDB

---

# 1. Purpose

This document defines the technical architecture of the Rashtrotthana Yoga website.

The website will be developed as a WordPress-based web application using:

* WordPress as the core CMS and application platform
* A custom WordPress theme for the public-facing website
* Custom WordPress plugins for project-specific business functionality
* MySQL/MariaDB for persistent data storage
* Google Maps Platform for center location functionality
* WATI API for WhatsApp automation
* A multilingual WordPress solution for English and Kannada
* WordPress roles and capabilities for authentication and authorization

The architecture is designed to provide a maintainable, scalable and secure platform that can be operated by the Rashtrotthana IT team after handover.

The current implementation does not include the AI Knowledge Assistant. The AI assistant is currently on hold and may be integrated later as an independent service.

---

# 2. Architectural Principles

The following principles govern the implementation.

## 2.1 WordPress First

WordPress is the core application platform.

The project will not use a separate Next.js frontend or FastAPI backend for the current website implementation.

WordPress will provide:

* Content management
* User management
* Authentication
* Authorization
* Page management
* Custom Post Types
* Media management
* Application configuration
* Administrative interfaces
* Server-side rendering
* Database access

---

## 2.2 Separation of Presentation and Business Logic

The custom theme will primarily contain presentation-related functionality.

Custom plugins will contain business functionality.

The following separation must be maintained:

```text
Custom Theme
    |
    +-- Layout
    +-- Templates
    +-- Components
    +-- CSS
    +-- JavaScript
    +-- Frontend presentation
    |
    v
Custom Plugins
    |
    +-- Content structures
    +-- Registration
    +-- WATI
    +-- Integrations
    +-- Business rules
    +-- Administration
    |
    v
WordPress Database
```

Business-critical functionality should not be placed directly inside the theme's `functions.php` file.

---

# 3. High-Level Architecture

```text
                         VISITORS
                            |
                 Desktop / Mobile / Tablet
                            |
                          HTTPS
                            |
                            v
                 +-----------------------+
                 |   Web Server / Nginx  |
                 |   or Apache           |
                 |   SSL / Routing       |
                 +-----------+-----------+
                             |
                             v
                 +-----------------------+
                 |       WORDPRESS       |
                 |                       |
                 |  Custom Theme         |
                 |  WordPress CMS        |
                 |  Custom Plugins       |
                 +-----------+-----------+
                             |
             +---------------+----------------+
             |               |                |
             v               v                v
       MySQL/MariaDB   Google Maps API      WATI API
             |
             v
       Website Content
       Registrations
       Configuration
       User Data
```

---

# 4. Runtime Architecture

A typical public website request follows this process:

```text
Visitor
   |
   v
Browser
   |
   | HTTPS
   v
Web Server
   |
   v
WordPress
   |
   +-- Load WordPress
   |
   +-- Load Active Plugins
   |
   +-- Load Theme
   |
   +-- Determine Requested Route
   |
   +-- Query Required Content
   |
   +-- Execute Business Logic
   |
   +-- Render Template
   |
   v
HTML Response
   |
   v
Browser
```

For example, when a visitor opens an Activity page:

```text
Visitor
   |
   v
/activities/yoga-for-beginners/
   |
   v
WordPress Router
   |
   v
Activity Custom Post Type
   |
   v
Activity Data
   |
   +-- Title
   +-- Description
   +-- Image
   +-- Center
   +-- Registration
   |
   v
single-activity.php
   |
   v
Rendered HTML
   |
   v
Visitor
```

---

# 5. WordPress Application Layers

The application consists of the following logical layers.

```text
+------------------------------------------------+
|                Presentation Layer              |
|              Custom WordPress Theme            |
+------------------------------------------------+
|                 Content Layer                  |
|      Pages / CPTs / Taxonomies / Media         |
+------------------------------------------------+
|                Business Layer                  |
|             Custom WordPress Plugins           |
+------------------------------------------------+
|                 Integration Layer              |
|        Google Maps / WATI / Email / APIs       |
+------------------------------------------------+
|                   Data Layer                   |
|                MySQL / MariaDB                 |
+------------------------------------------------+
```

---

# 6. Presentation Layer

The presentation layer will be implemented using a custom WordPress theme.

Technology:

* PHP
* HTML5
* CSS3
* JavaScript
* WordPress template APIs
* WordPress theme APIs
* Responsive design techniques

The theme will provide:

* Header
* Footer
* Navigation
* Homepage
* About pages
* Activity templates
* Center templates
* Event templates
* Resource templates
* Gallery components
* Contact page
* Search page
* Error pages
* Responsive layouts

---

# 7. Custom Theme

The custom theme will be named:

```text
rashtrotthana-yoga
```

Recommended structure:

```text
rashtrotthana-yoga/
|
├── style.css
├── functions.php
├── theme.json
├── index.php
├── front-page.php
├── page.php
├── single.php
├── archive.php
├── search.php
├── 404.php
|
├── single-activity.php
├── archive-activity.php
|
├── single-center.php
├── archive-center.php
|
├── single-event.php
├── archive-event.php
|
├── single-resource.php
├── archive-resource.php
|
├── header.php
├── footer.php
|
├── template-parts/
│   ├── header/
│   ├── footer/
│   ├── hero/
│   ├── activities/
│   ├── centers/
│   ├── events/
│   ├── resources/
│   ├── gallery/
│   └── forms/
|
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── fonts/
|
└── inc/
    ├── setup.php
    ├── enqueue.php
    ├── menus.php
    ├── helpers.php
    └── template-functions.php
```

---

# 8. Plugin Architecture

Project-specific functionality will be implemented as independent plugins.

The recommended plugin structure is:

```text
wp-content/plugins/

├── rashtrotthana-core/
│
├── rashtrotthana-registration/
│
└── rashtrotthana-wati/
```

Additional plugins may be introduced only when there is a clear requirement.

---

# 9. Rashtrotthana Core Plugin

The Core plugin will contain the structured content model and general project functionality.

Responsibilities include:

* Activities
* Centers
* Events
* Resources
* Gallery functionality
* Testimonials
* FAQs
* Banners
* Custom taxonomies
* Website settings
* Custom administration functionality
* Shared helper functions

Example structure:

```text
rashtrotthana-core/
|
├── rashtrotthana-core.php
|
├── includes/
│   ├── post-types/
│   │   ├── activities.php
│   │   ├── centers.php
│   │   ├── events.php
│   │   ├── resources.php
│   │   ├── testimonials.php
│   │   └── faqs.php
│   │
│   ├── taxonomies/
│   │   ├── activity-category.php
│   │   ├── resource-category.php
│   │   └── gallery-category.php
│   │
│   ├── meta/
│   ├── admin/
│   ├── settings/
│   ├── permissions/
│   └── helpers/
│
└── assets/
```

---

# 10. Registration Plugin

Registration will be implemented as a dedicated custom plugin.

Responsibilities:

* Registration forms
* Dynamic form fields
* Form validation
* Registration submission
* Capacity management
* Registration status
* Registration administration
* Search and filtering
* CSV export
* Email notifications
* Activity/event relationships
* Registration security

Structure:

```text
rashtrotthana-registration/
|
├── rashtrotthana-registration.php
|
├── includes/
│   ├── database/
│   ├── forms/
│   ├── fields/
│   ├── validation/
│   ├── submissions/
│   ├── admin/
│   ├── export/
│   ├── notifications/
│   └── security/
|
└── assets/
    ├── css/
    └── js/
```

---

# 11. WATI Plugin

WATI integration will be isolated into a dedicated plugin.

Responsibilities:

* WATI API configuration
* Secure API communication
* WhatsApp template management
* Registration confirmation messages
* Event reminders
* Activity notifications
* Administrative notifications
* Webhook processing
* Delivery status handling where supported

Structure:

```text
rashtrotthana-wati/
|
├── rashtrotthana-wati.php
|
├── includes/
│   ├── api/
│   ├── templates/
│   ├── notifications/
│   ├── webhooks/
│   ├── admin/
│   └── security/
|
└── assets/
```

WATI credentials must never be exposed to frontend JavaScript.

---

# 12. Content Architecture

The main content entities are:

```text
Pages
Activities
Centers
Events
Resources
Gallery
Testimonials
FAQs
Banners
Menus
Site Settings
```

WordPress Pages will be used for general static/organizational content.

Custom Post Types will be used for structured repeatable entities.

---

# 13. Custom Post Types

The primary Custom Post Types are:

```text
activity
center
event
resource
testimonial
faq
```

Each Custom Post Type receives its own:

* Admin interface
* URL structure
* Template
* Metadata
* Taxonomies where required
* Search/filtering behavior
* Permissions where necessary

---

# 14. Activity Architecture

```text
Activity
   |
   +-- Basic Information
   |
   +-- Description
   |
   +-- Category
   |
   +-- Center
   |
   +-- Images
   |
   +-- Registration
   |
   +-- Status
```

An Activity may optionally be associated with a Registration Form.

```text
Activity
   |
   +---- Registration Form
                 |
                 +---- Fields
                 |
                 +---- Registrations
```

---

# 15. Center Architecture

```text
Center
   |
   +-- Name
   +-- Address
   +-- Contact
   +-- Operating Information
   +-- Latitude
   +-- Longitude
   +-- Images
   +-- Activities
```

The latitude and longitude values will be used by the Google Maps integration.

---

# 16. Event Architecture

```text
Event
   |
   +-- Title
   +-- Description
   +-- Start Date
   +-- Start Time
   +-- End Date
   +-- End Time
   +-- Venue
   +-- Center
   +-- Image
   +-- Registration
   +-- Capacity
```

Events will be automatically categorized as upcoming or past based on their configured dates.

---

# 17. Resource Architecture

Resources may include:

* PDF documents
* Videos
* Documents
* Educational materials
* Downloadable files

Each Resource will contain:

```text
Resource
   |
   +-- Title
   +-- Description
   +-- Category
   +-- Language
   +-- Media/File
   +-- Publication Information
   +-- Visibility
```

---

# 18. Gallery Architecture

WordPress Media Library will be used as the underlying media storage system.

Custom gallery functionality will provide:

```text
Gallery Category
      |
      +-- Images
      |
      +-- Optional Event Relationship
```

Images should use WordPress responsive image sizes.

Large original images should not be unnecessarily served to visitors.

---

# 19. Database Architecture

The primary database is:

```text
MySQL / MariaDB
```

WordPress core tables will be used for standard WordPress functionality.

Custom registration tables will be created for registration-specific data.

Conceptually:

```text
WordPress Tables
      |
      +-- Users
      +-- Posts
      +-- Post Metadata
      +-- Terms
      +-- Options
      +-- Media
      |
      v
Custom Registration Tables
      |
      +-- Forms
      +-- Fields
      +-- Registrations
      +-- Answers
```

---

# 20. Authentication

WordPress's native authentication system will be used.

Authentication includes:

* Username/password
* WordPress sessions
* Password hashing
* Login/logout
* Password reset
* User accounts

No custom authentication system is required for the current implementation.

---

# 21. Authorization

Authorization will use WordPress:

* Roles
* Capabilities
* Permission checks

Recommended roles:

```text
Administrator
Content Manager
Registration Manager
```

The exact capabilities will be finalized during implementation.

Example:

```text
Administrator
    |
    +-- All website functionality

Content Manager
    |
    +-- Pages
    +-- Activities
    +-- Centers
    +-- Events
    +-- Resources
    +-- Gallery

Registration Manager
    |
    +-- View Registrations
    +-- Filter Registrations
    +-- Export Registrations
```

Protected actions must be checked server-side.

---

# 22. External Integrations

The current system includes two major external integrations.

```text
                     WordPress
                    /         \
                   /           \
                  v             v
           Google Maps        WATI
               API             API
```

---

# 23. Google Maps Integration

Google Maps will be used for Center locations.

Flow:

```text
Admin
   |
   v
Create/Edit Center
   |
   +-- Address
   +-- Latitude
   +-- Longitude
   |
   v
Save Center
   |
   v
Public Center Page
   |
   v
Google Maps
   |
   v
Map Marker
```

The Google Maps account and billing should remain under Rashtrotthana's ownership.

API keys must be restricted appropriately.

---

# 24. WATI Integration

WATI will provide WhatsApp communication.

Flow:

```text
Visitor
   |
   v
Registration
   |
   v
WordPress
   |
   v
WATI API
   |
   v
WhatsApp
```

Possible messages include:

* Registration confirmation
* Event reminder
* Activity notification
* Administrative notification

Exact message/template capabilities depend on the WATI account and approved WhatsApp templates.

---

# 25. Multilingual Architecture

The website will support:

```text
English
Kannada
```

A WordPress multilingual solution such as WPML or another approved equivalent will be used.

Translation coverage should include:

* Pages
* Activities
* Centers
* Events
* Resources
* Navigation
* Forms
* Form labels
* Relevant system messages

The language selector will allow visitors to switch between supported languages.

---

# 26. Search Architecture

Search will operate over approved public content.

Potential searchable content:

```text
Pages
Activities
Centers
Events
Resources
```

Search results should provide:

* Content title
* Content type
* Short description
* Relevant link
* Featured image where appropriate

Private registration information must never appear in public search.

---

# 27. Registration Data Flow

```text
Visitor
   |
   v
Activity/Event
   |
   v
Registration Form
   |
   v
Browser Validation
   |
   v
Server Validation
   |
   v
Permission / Business Rules
   |
   v
Database
   |
   +----------+
   |          |
   v          v
Email       WATI
```

Registration information must only be accessible to authorized administrative users.

---

# 28. Security Architecture

Security controls include:

* HTTPS
* WordPress authentication
* WordPress authorization
* Nonces
* Capability checks
* Server-side validation
* Sanitization
* Output escaping
* Safe database queries
* Secure file handling
* Protected API credentials
* Restricted administrative access

The system must not trust browser-side validation alone.

All important validation must also happen server-side.

---

# 29. API Architecture

WordPress can communicate with external services through server-side HTTP requests.

Example:

```text
WordPress Plugin
      |
      | HTTPS
      v
External API
      |
      v
Response
      |
      v
WordPress
```

External credentials must be stored securely.

They must not be hardcoded into frontend JavaScript.

---

# 30. Caching and Performance

The implementation should support:

* WordPress page caching
* Browser caching
* Optimized images
* Responsive image sizes
* Lazy loading
* Minified assets where appropriate
* Efficient database queries
* Reduced unnecessary plugin execution

Caching must not cause stale registration availability or other critical transactional data.

---

# 31. Media Architecture

All uploaded media should be managed through the WordPress Media Library unless a specific custom storage requirement is approved.

Media includes:

* Images
* PDFs
* Documents
* Other approved files

The system should define:

* Maximum upload size
* Allowed file types
* Image optimization rules
* Public/private resource rules

---

# 32. Development Environment

Each developer should maintain an independent local WordPress installation.

Recommended:

```text
Developer 1
    |
    v
Local WordPress

Developer 2
    |
    v
Local WordPress

Developer 3
    |
    v
Local WordPress
```

All source code is synchronized through Git.

Developers should not work directly against the production database.

---

# 33. Git Architecture

The repository should contain:

```text
/docs
/themes
/plugins
```

Recommended branches:

```text
main
develop

feature/frontend-theme
feature/core-content
feature/registration
feature/wati
feature/google-maps
feature/multilingual
```

Feature branches should be merged through Pull Requests.

---

# 34. Team Development

The three-person team can work in parallel.

Recommended division:

### Developer 1

Frontend:

```text
Custom Theme
Templates
Responsive UI
JavaScript
CSS
Accessibility
```

### Developer 2

WordPress Core:

```text
CPTs
Taxonomies
Admin
Settings
Roles
Content architecture
```

### Developer 3

Business Features:

```text
Registration
Database
CSV export
WATI
Email
Google Maps
```

Shared architecture and interfaces must be agreed before implementation.

---

# 35. Environment Structure

Three environments are recommended:

```text
LOCAL
   |
   v
STAGING
   |
   v
PRODUCTION
```

## Local

Used by developers.

## Staging

Used for:

* Integration testing
* Client/IT testing
* Content testing
* Acceptance testing

## Production

Used by visitors.

No experimental development should occur directly on production.

---

# 36. Deployment Flow

```text
Developer
   |
   v
Feature Branch
   |
   v
Pull Request
   |
   v
Code Review
   |
   v
Develop
   |
   v
Testing
   |
   v
Staging
   |
   v
Rashtrotthana IT Testing
   |
   v
Production
```

---

# 37. Backup Strategy

Production should have backups for:

```text
WordPress Database
Uploaded Media
Theme
Plugins
Configuration
```

Backups should be tested periodically.

A backup is only useful if restoration has been verified.

---

# 38. Logging

Important application events should be logged where appropriate.

Examples:

* WATI API failures
* Webhook failures
* Registration processing errors
* Authentication failures
* Administrative actions where required
* External API failures

Logs must not contain unnecessary sensitive participant information.

---

# 39. Error Handling

External integrations must fail gracefully.

For example:

```text
Registration
    |
    v
Database Save
    |
    +---- Success
    |       |
    |       v
    |    Confirmation
    |
    +---- WATI Failure
             |
             v
       Registration remains saved
             |
             v
       Error logged
```

A temporary WATI failure should not automatically destroy an otherwise successful registration.

---

# 40. Future AI Integration

The AI Knowledge Assistant is currently excluded from the implementation.

If activated in the future:

```text
                    WordPress
                        |
                       API
                        |
                        v
               AI Knowledge Service
                    /       \
                   v         v
                OpenAI     Gemini
```

The AI system should be implemented as a separate service rather than coupling the entire WordPress application to a specific AI provider.

The future service may retrieve approved Rashtrotthana content from WordPress through secure APIs.

---

# 41. Scalability

The architecture supports future additions including:

* Online payments
* Mobile application
* Volunteer management
* Learning platform
* Advanced analytics
* AI Knowledge Assistant
* Additional integrations

Future features should preferably be implemented as independent plugins or services where appropriate.

---

# 42. Handover Architecture

The final handover should include:

```text
WordPress Theme
Custom Plugins
Database Scripts
Configuration Documentation
Deployment Documentation
API Documentation
Administrator Guide
Maintenance Guide
Source Code
```

The Rashtrotthana IT team will own and maintain the hosting infrastructure and approved third-party services after handover unless a separate maintenance agreement is established.

---

# 43. Architecture Summary

The final architecture is:

```text
                    VISITORS
                        |
                      HTTPS
                        |
                        v
              Web Server / SSL
                        |
                        v
                   WORDPRESS
                        |
        +---------------+---------------+
        |               |               |
        v               v               v
    Custom Theme   Custom Plugins    WordPress CMS
        |               |               |
        |               +-------+-------+
        |                       |
        |                       v
        |                MySQL / MariaDB
        |
        +---------- Public Website
                        
                         |
             +-----------+-----------+
             |                       |
             v                       v
        Google Maps                 WATI
             API                     API
```

This architecture provides a single WordPress-based platform for content management, public website functionality, custom registration, administration and approved external integrations.

The architecture intentionally avoids unnecessary separation into multiple application frameworks while retaining clear separation between presentation, content, business logic, integrations and data.

---

# 44. Final Architectural Rules

The following rules should be treated as project standards:

1. WordPress is the primary application platform.
2. The custom theme is responsible primarily for presentation.
3. Business logic belongs in plugins.
4. Activities, Centers, Events and Resources must use structured content.
5. Registration data must use dedicated registration storage.
6. API credentials must remain server-side.
7. All protected operations require server-side authorization.
8. Browser validation must never replace server-side validation.
9. Production must never be used for experimental development.
10. All source code must be maintained in Git.
11. Feature development should use branches and Pull Requests.
12. Staging must be used before production deployment.
13. AI remains outside the current implementation until formally approved.
14. Third-party accounts such as WATI and Google Maps remain under Rashtrotthana ownership.
15. The architecture must remain maintainable by the Rashtrotthana IT team after handover.
