# Rashtrotthana Yoga Website
## Deployment and Infrastructure

**Document:** `deployment.md`  
**Project:** Rashtrotthana Yoga Website  
**Version:** 1.0  
**Status:** Development Specification  
**Platform:** WordPress  
**Recommended Hosting:** Ubuntu VPS  
**Web Server:** Nginx  
**Database:** MySQL/MariaDB compatible with WordPress  

---

# 1. Purpose

This document defines the deployment architecture, environment configuration, server setup, release process and operational requirements for the Rashtrotthana Yoga WordPress website.

The objective is to provide a repeatable and secure deployment process that can be maintained by Rashtrotthana's IT team.

---

# 2. Deployment Objectives

The deployment architecture should provide:

- Reliable hosting
- HTTPS
- Secure WordPress installation
- Database security
- Backup capability
- Environment separation
- Repeatable deployments
- Secure secret management
- Monitoring
- Disaster recovery
- Easy maintenance
- Documentation for the IT team

---

# 3. Target Architecture

```text
                         INTERNET
                            |
                            v
                         DNS
                            |
                            v
                         HTTPS
                            |
                            v
                         NGINX
                            |
                            v
                       WORDPRESS
                            |
              +-------------+-------------+
              |                           |
              v                           v
          PHP Runtime                 WordPress
              |                           |
              +-------------+-------------+
                            |
                            v
                     MySQL / MariaDB
                            |
                            v
                         Backups
```

---

# 4. Hosting

The proposed production environment is an Ubuntu VPS.

The server may be hosted with an infrastructure provider selected by Rashtrotthana.

The final provider is outside this document unless separately specified.

---

# 5. Server Ownership

Production infrastructure should preferably be owned and administered by Rashtrotthana.

The development team may receive temporary access for deployment/support.

---

# 6. Recommended Server Components

The production server should provide:

```text
Ubuntu Linux
Nginx
PHP
PHP-FPM
MySQL or MariaDB
WordPress
SSL/TLS
Cron
Backup System
```

Additional services may be introduced if required.

---

# 7. Operating System

Use a currently supported Ubuntu LTS release.

The exact version should be selected based on:

- WordPress compatibility
- PHP compatibility
- Provider support
- Security support lifecycle

---

# 8. Server Resources

Minimum server resources should be selected according to expected traffic.

As an initial planning baseline:

```text
CPU:
2 vCPU or more

RAM:
4 GB or more

Storage:
40 GB or more SSD

Network:
Production-grade internet connectivity
```

These are planning values, not fixed production requirements.

Capacity should be reviewed after traffic measurements are available.

---

# 9. DNS

The production domain must point to the server.

Conceptually:

```text
Domain
   |
   v
DNS
   |
   v
Server IP
   |
   v
Nginx
```

Required records depend on the final domain configuration.

---

# 10. DNS Records

Typical configuration:

```text
A
www
@
```

IPv6 may use:

```text
AAAA
```

if supported by the hosting environment.

---

# 11. WWW Redirect

The website should define one canonical hostname.

For example:

```text
www.example.com
```

or:

```text
example.com
```

The non-canonical version should redirect to the canonical version.

---

# 12. HTTPS

Production must use HTTPS.

Recommended flow:

```text
http://example.com
        |
        v
301 Redirect
        |
        v
https://example.com
```

---

# 13. SSL Certificate

A valid SSL/TLS certificate must be installed.

A certificate authority such as Let's Encrypt may be used if appropriate.

Certificate renewal should be automated.

---

# 14. Nginx

Nginx acts as the public web server.

Responsibilities:

- Accept HTTP/HTTPS traffic
- TLS termination
- Serve static files
- Pass PHP requests to PHP-FPM
- Apply request restrictions
- Redirect HTTP to HTTPS

---

# 15. PHP

WordPress requires PHP.

The production PHP version must be compatible with:

- WordPress
- Theme
- Plugins
- Custom code

Use a currently supported PHP version.

---

# 16. PHP-FPM

Nginx should communicate with PHP through PHP-FPM.

Conceptually:

```text
Browser
   |
   v
Nginx
   |
   v
PHP-FPM
   |
   v
WordPress
```

---

# 17. Database

WordPress requires MySQL or MariaDB.

Recommended architecture:

```text
WordPress
    |
    v
MySQL / MariaDB
```

The database should run on the same private server or an appropriately secured database service.

---

# 18. Database Security

The database should not be directly accessible from the public internet.

Only the application server should access it where possible.

---

# 19. Database Credentials

The production database should use a dedicated WordPress database user.

Do not use the database root account for WordPress.

---

# 20. WordPress Installation

WordPress should be installed using the official WordPress distribution and verified packages.

The final installation path may be:

```text
/var/www/rashtrotthana/
```

The exact path may vary by server configuration.

---

# 21. File Ownership

Web files should have appropriate ownership and permissions.

Avoid making the entire WordPress directory writable by every system user.

---

# 22. File Permissions

Permissions should follow the principle of least privilege.

Avoid:

```text
777
```

permissions.

The exact ownership model depends on Nginx/PHP-FPM configuration.

---

# 23. WordPress Configuration

The `wp-config.php` file must contain production configuration.

Sensitive values include:

```text
DB_NAME
DB_USER
DB_PASSWORD
DB_HOST
AUTH_KEY
SECURE_AUTH_KEY
LOGGED_IN_KEY
NONCE_KEY
```

Secrets must not be committed to Git.

---

# 24. Environment Configuration

Where practical, sensitive configuration should be supplied through server environment variables or protected configuration.

Separate:

```text
LOCAL
STAGING
PRODUCTION
```

---

# 25. Production Debugging

Production should not display technical errors to visitors.

Recommended:

```text
WP_DEBUG = false
```

unless temporarily enabled under controlled circumstances.

---

# 26. Development Environment

Developers should use a local WordPress environment.

Possible tools include:

```text
Docker
Local WordPress
XAMPP
MAMP
```

The final team choice is implementation-specific.

---

# 27. Staging Environment

A staging environment should be used for production-like testing.

Recommended:

```text
Development
      |
      v
Staging
      |
      v
Production
```

---

# 28. Staging Purpose

Staging should be used to test:

- Theme changes
- Plugin updates
- Custom plugin changes
- Database migrations
- Multilingual content
- Registration
- WATI
- Google Maps
- AI integration
- Performance
- Security

---

# 29. Staging Credentials

Staging must not accidentally use production credentials.

Use separate credentials wherever possible.

---

# 30. Staging Indexing

The staging website should not appear in search engines.

Possible methods:

```text
noindex
+
robots restrictions
+
authentication
```

Authentication is preferred where sensitive content is present.

---

# 31. Git Repository

The codebase should be managed through Git.

Recommended structure:

```text
repository
 |
 +-- wp-content/
 |    |
 |    +-- themes/
 |    +-- plugins/
 |
 +-- docs/
 |
 +-- deployment/
 |
 +-- .gitignore
```

---

# 32. What Goes Into Git

Commit:

- Custom theme
- Custom plugins
- Configuration templates
- Documentation
- Build scripts
- Deployment scripts
- Composer/package definitions where applicable

Do not commit:

- Production secrets
- Database dumps containing participant data
- Uploaded media unless intentionally versioned
- `.env` secrets
- Temporary files

---

# 33. Branching

A simple development strategy may use:

```text
main
 |
 +-- development
 |
 +-- feature/*
```

The exact Git workflow should be agreed by the development team.

---

# 34. Pull Requests

Code changes should preferably be reviewed before merging.

Review:

- Functionality
- Security
- WordPress standards
- Performance
- Accessibility
- Compatibility

---

# 35. Deployment Pipeline

Recommended:

```text
Developer
    |
    v
Git Commit
    |
    v
Pull Request
    |
    v
Review
    |
    v
Staging
    |
    v
Testing
    |
    v
Production
```

---

# 36. Manual Deployment

For a small team, an initial manual deployment may be acceptable.

Example:

```text
Git
 |
 v
Pull Latest Code
 |
 v
Backup
 |
 v
Deploy
 |
 v
Test
```

Automation can be introduced later.

---

# 37. Automated Deployment

A CI/CD pipeline may eventually perform:

```text
Test
 |
 v
Build
 |
 v
Deploy Staging
 |
 v
Approval
 |
 v
Deploy Production
```

The exact CI/CD platform is not mandated.

---

# 38. Pre-Deployment Backup

Before production deployment:

```text
Database Backup
+
Files Backup
```

must be available.

---

# 39. Database Backup

A production database backup should be taken before:

- WordPress core updates
- Major plugin updates
- Database migrations
- Custom plugin releases
- Major content migrations

---

# 40. Files Backup

The backup should include required WordPress files and uploaded media.

At minimum:

```text
wp-content/uploads
Custom Theme
Custom Plugins
Configuration
```

---

# 41. Backup Frequency

Recommended starting point:

```text
Database:
Daily

Files:
Daily or based on change frequency
```

The final retention schedule must be defined with Rashtrotthana IT.

---

# 42. Backup Retention

A possible policy:

```text
Daily:
7 days

Weekly:
4 weeks

Monthly:
3-12 months
```

The exact retention period must be approved.

---

# 43. Offsite Backups

At least one backup copy should preferably be stored separately from the production server.

Conceptually:

```text
Production
    |
    v
Backup
    |
    v
Offsite Storage
```

---

# 44. Restore Testing

Backups should periodically be restored in a test environment.

Verify:

- WordPress loads
- Database works
- Media loads
- Custom plugins work
- Registrations are present
- Multilingual relationships remain intact

---

# 45. Maintenance Mode

For certain deployments, maintenance mode may be used.

Avoid long periods of maintenance mode.

---

# 46. Zero/Low Downtime

Where practical:

```text
Backup
 |
 v
Deploy
 |
 v
Cache Clear
 |
 v
Health Check
```

The site should return to normal operation quickly.

---

# 47. WordPress Updates

WordPress core should be kept updated.

Before major updates:

```text
Backup
 |
 v
Staging
 |
 v
Test
 |
 v
Production
```

---

# 48. Plugin Updates

Plugins should be updated regularly.

Do not install unnecessary plugins.

---

# 49. Theme Updates

The custom theme should be version controlled and deployed through the project repository.

---

# 50. Database Migrations

If custom plugin/database schema changes are required:

```text
Migration
 |
 v
Backup
 |
 v
Apply Migration
 |
 v
Verify
```

Migrations must be tested on staging first.

---

# 51. Registration Data Migration

Registration data is sensitive.

Database migrations must preserve:

- Registration IDs
- Participant information
- Activity relationships
- Status
- Timestamps
- Language

---

# 52. Multilingual Migration

Migrations must preserve:

- Translation relationships
- Language metadata
- Language-specific URLs
- Menus
- SEO metadata

---

# 53. Media Migration

Media migration must preserve:

```text
Uploads
Attachment Records
URLs
Metadata
```

---

# 54. Cache

Production may use caching at multiple levels:

```text
Browser
   |
   v
CDN / Nginx Cache
   |
   v
WordPress Cache
   |
   v
Database
```

Caching must not serve stale registration or administrative data incorrectly.

---

# 55. Registration Cache Rules

Registration APIs and admin pages should not be cached as public pages.

---

# 56. Cache Invalidation

When important content changes:

```text
Admin Updates Content
       |
       v
Save
       |
       v
Invalidate Relevant Cache
       |
       v
Public Website
```

---

# 57. Search Cache

Search results may be cached where appropriate.

The cache must respect:

- Language
- Query
- Published status

---

# 58. Cron

WordPress scheduled tasks may be required for:

- Event reminders
- Notifications
- Cleanup
- Scheduled publishing

The server may use a real cron job to trigger WordPress cron reliably.

---

# 59. Scheduled Tasks

Potential tasks:

```text
Event Reminder
Notification Retry
Temporary Data Cleanup
Cache Maintenance
```

---

# 60. WATI Deployment

WATI configuration requires:

```text
WATI API URL
WATI API Credentials
Template Mapping
```

Production credentials must be configured securely.

---

# 61. Google Maps Deployment

Google Maps configuration requires:

```text
Google Maps API Key
Required API Enablement
Application Restrictions
API Restrictions
```

Production configuration must be tested after deployment.

---

# 62. AI Deployment

If the AI Knowledge Assistant is deployed separately:

```text
WordPress
    |
    | HTTPS
    v
AI Application
    |
    v
OpenAI / Gemini
```

The AI provider key must remain server-side.

---

# 63. WATI Failure

A WATI failure should not make the website unavailable.

Notifications may be queued/retried depending on the implementation.

---

# 64. External API Failure

If an external service fails:

```text
External Service
       |
       v
Failure
       |
       v
Graceful Error
       |
       v
Website Continues
```

---

# 65. Health Checks

The deployment should include basic health checks.

Check:

```text
Homepage
About
Activities
Centers
Events
Gallery
Resources
Contact
Search
Registration
Admin Login
```

---

# 66. API Health

Where custom APIs exist:

```text
GET /wp-json/
```

and relevant public endpoints should be tested.

Administrative APIs should be tested using authenticated requests.

---

# 67. Database Health

Monitor:

- Database availability
- Disk usage
- Query performance
- Connection errors

---

# 68. Server Monitoring

Monitor:

- CPU
- RAM
- Disk
- Network
- PHP-FPM
- Nginx
- Database
- SSL certificate
- Error logs

---

# 69. Disk Monitoring

Disk usage should be monitored.

Particularly:

```text
Uploads
Backups
Logs
Database
```

A full disk can make the website fail.

---

# 70. Log Rotation

Server/application logs should be rotated.

Do not allow logs to consume all available disk space.

---

# 71. Security Updates

Ubuntu security updates should be applied regularly.

Critical security updates should be prioritized.

---

# 72. Firewall

The production server firewall should expose only required services.

Typical:

```text
HTTP 80
HTTPS 443
SSH restricted
```

Database ports should remain private.

---

# 73. SSH Access

SSH access should be limited to authorized administrators.

Prefer SSH keys over passwords.

---

# 74. Root Access

Routine application administration should not use root unnecessarily.

Use a dedicated administrative account with `sudo` where appropriate.

---

# 75. Deployment Rollback

Every production deployment should have a rollback strategy.

Conceptually:

```text
Production
    |
    v
Deployment
    |
    v
Problem
    |
    v
Rollback
    |
    v
Previous Stable Version
```

---

# 76. Rollback Options

Depending on the change:

- Restore previous code
- Restore database backup
- Revert Git commit
- Restore media
- Revert configuration

Database rollbacks require particular care when migrations are involved.

---

# 77. Failed Deployment

If deployment health checks fail:

```text
Deployment Failed
      |
      v
Stop Further Changes
      |
      v
Investigate
      |
      v
Rollback if Required
      |
      v
Verify
```

---

# 78. Production Change Management

Major changes should be documented.

Example:

```text
Date
Change
Reason
Person
Version
Result
Rollback
```

---

# 79. Versioning

Custom theme/plugin releases should have versions.

Example:

```text
1.0.0
1.1.0
1.1.1
```

---

# 80. Release Notes

Each significant release should document:

- Changes
- Bug fixes
- Security fixes
- Database migrations
- Configuration changes
- Required manual actions

---

# 81. Deployment Checklist

Before deployment:

```text
[ ] Code reviewed
[ ] Tests passed
[ ] Staging tested
[ ] Backup verified
[ ] Database backup created
[ ] Files backup created
[ ] Secrets configured
[ ] Environment checked
[ ] DNS verified
[ ] SSL verified
[ ] Maintenance plan ready
[ ] Rollback plan ready
```

---

# 82. Post-Deployment Checklist

After deployment:

```text
[ ] Homepage works
[ ] Navigation works
[ ] English works
[ ] Kannada works
[ ] Activities work
[ ] Centers work
[ ] Google Maps works
[ ] Events work
[ ] Gallery works
[ ] Resources work
[ ] Search works
[ ] Registration works
[ ] Email works
[ ] WATI works
[ ] Admin works
[ ] Media works
[ ] SSL works
[ ] No critical errors
```

---

# 83. Production Smoke Test

A short smoke test should be performed after every significant release.

Recommended:

```text
Homepage
Activity
Center
Event
Registration
Search
Admin
```

---

# 84. Performance Testing

Before launch, test:

- Page load
- Mobile performance
- Image loading
- Database queries
- Registration submission
- Search
- Map loading

---

# 85. Load Testing

Load testing should be considered if expected traffic is significant.

Test at least:

- Homepage traffic
- Activity traffic
- Registration spikes
- Search
- API requests

---

# 86. Disaster Recovery

A disaster recovery plan should define:

- Backup location
- Recovery procedure
- Server rebuild procedure
- DNS procedure
- Credential recovery
- Restore testing
- Responsible personnel

---

# 87. Recovery Procedure

Conceptually:

```text
Server Failure
      |
      v
Provision New Server
      |
      v
Install Runtime
      |
      v
Deploy WordPress
      |
      v
Restore Database
      |
      v
Restore Media
      |
      v
Configure DNS/SSL
      |
      v
Test
      |
      v
Production
```

---

# 88. Recovery Time Objective

The project should define an acceptable maximum recovery time.

Example:

```text
RTO:
To be finalized by Rashtrotthana IT
```

---

# 89. Recovery Point Objective

The project should define acceptable data loss.

Example:

```text
RPO:
To be finalized by Rashtrotthana IT
```

---

# 90. Ownership

Rashtrotthana IT should own:

- Production server
- Domain
- DNS
- SSL account where applicable
- WordPress production installation
- Database
- Backups
- WATI account
- Google Cloud/Maps account
- AI provider account

---

# 91. Developer Access

Development access should be:

- Authorized
- Time-limited where appropriate
- Revocable
- Auditable

---

# 92. Handover

Deployment handover should include:

- Server requirements
- Installation guide
- DNS configuration
- SSL configuration
- WordPress configuration
- Database configuration
- Backup procedure
- Restore procedure
- Deployment procedure
- Rollback procedure
- Environment variables
- Integration configuration
- Troubleshooting guide

---

# 93. Documentation Location

All deployment documentation should be stored in:

```text
/docs
```

Recommended:

```text
architecture.md
database.md
content-model.md
api.md
registration.md
wati.md
google-maps.md
multilingual.md
security.md
deployment.md
coding-standards.md
```

---

# 94. Final Deployment Architecture

```text
                         INTERNET
                            |
                            v
                           DNS
                            |
                            v
                      HTTPS / TLS
                            |
                            v
                          NGINX
                            |
                            v
                       WORDPRESS
                            |
             +--------------+--------------+
             |              |              |
             v              v              v
          PHP-FPM        Plugins         Theme
             |              |              |
             +--------------+--------------+
                            |
                            v
                       MySQL/MariaDB
                            |
                            v
                         Backups
                            |
                  +---------+---------+
                  |                   |
                  v                   v
              Offsite              Restore
              Storage              Testing
```

---

# 95. Development Rules

1. Production must run on a supported Ubuntu LTS environment.
2. Use a supported PHP version.
3. Use Nginx and PHP-FPM appropriately.
4. Use MySQL/MariaDB for WordPress.
5. Use HTTPS in production.
6. Protect the database from public access.
7. Use separate development, staging and production environments where practical.
8. Never commit production secrets.
9. Back up before major changes.
10. Maintain offsite backups.
11. Test restores periodically.
12. Use Git for custom code.
13. Test changes on staging before production.
14. Maintain a rollback procedure.
15. Monitor server health.
16. Monitor disk usage.
17. Apply security updates.
18. Restrict SSH access.
19. Use least-privilege server access.
20. Configure scheduled tasks reliably.
21. Verify external integrations after deployment.
22. Perform production smoke tests.
23. Document significant changes.
24. Maintain deployment and recovery documentation.
25. Ensure Rashtrotthana receives complete deployment knowledge transfer.
