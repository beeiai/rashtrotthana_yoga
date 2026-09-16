# Rashtrotthana Yoga Website

## Database Architecture and Data Model

**Document:** `database.md`
**Project:** Rashtrotthana Yoga Website
**Version:** 1.0
**Status:** Development Architecture
**Database Engine:** MySQL / MariaDB
**Application Platform:** WordPress

---

# 1. Purpose

This document defines the database architecture and content data model for the Rashtrotthana Yoga WordPress website.

The database architecture is designed around WordPress's native database model while introducing dedicated custom tables where the project requires structured transactional data, particularly activity/event registrations.

The objective is to ensure:

* Structured content
* Maintainable relationships
* Efficient querying
* Secure participant data handling
* Flexible registration forms
* Multilingual compatibility
* Searchability
* Reporting and CSV export
* Future extensibility

---

# 2. Database Technology

The website will use:

```text
MySQL / MariaDB
```

WordPress will manage its standard database tables.

Project-specific functionality will use:

* WordPress database APIs
* WordPress Custom Post Types
* WordPress taxonomies
* WordPress post metadata
* WordPress options
* Dedicated custom tables for registration data

The implementation must not bypass WordPress database APIs unnecessarily.

---

# 3. Database Architecture

At a high level:

```text
                         WORDPRESS
                             |
             +---------------+---------------+
             |               |               |
             v               v               v
       WordPress Core   Content Model    Custom Tables
             |               |               |
             v               v               v
        Users / Posts    Activities       Registrations
        Options / Media  Centers           Forms
        Terms / Meta     Events            Fields
                        Resources          Answers
```

---

# 4. WordPress Native Data Model

The following entities will primarily use WordPress's native database structure:

```text
Pages
Activities
Centers
Events
Resources
Testimonials
FAQs
Gallery content
Media
Users
Menus
Taxonomies
Site settings
SEO metadata
```

Where possible, structured content should be represented using WordPress's native mechanisms rather than creating duplicate custom tables.

---

# 5. Custom Post Types

The primary Custom Post Types are:

| Entity      | Post Type     | Purpose                         |
| ----------- | ------------- | ------------------------------- |
| Activity    | `activity`    | Yoga activities and programs    |
| Center      | `center`      | Yoga center information         |
| Event       | `event`       | Events and workshops            |
| Resource    | `resource`    | Documents, videos and resources |
| Testimonial | `testimonial` | Visitor/member testimonials     |
| FAQ         | `faq`         | Frequently asked questions      |

---

# 6. Activities Data Model

Activities represent programs, classes or offerings provided by Rashtrotthana Yoga.

Example:

```text
Activity
------------------------------
ID
Title
Description
Featured Image
Category
Center
Duration
Frequency
Instructor
Registration
Status
```

The primary WordPress record will be stored through:

```text
wp_posts
```

Additional structured information will be stored through:

```text
wp_postmeta
```

Taxonomy relationships will be managed through WordPress taxonomy tables.

---

# 7. Activity Fields

Recommended fields:

| Field                | Type                          | Required | Description                     |
| -------------------- | ----------------------------- | -------: | ------------------------------- |
| Title                | WordPress title               |      Yes | Activity name                   |
| Description          | Content                       |      Yes | Full activity description       |
| Short Description    | Text/HTML                     |       No | Summary                         |
| Featured Image       | Media                         |       No | Primary image                   |
| Activity Category    | Taxonomy                      |       No | Activity classification         |
| Center               | Relationship                  |       No | Associated center               |
| Duration             | Text/Number                   |       No | Typical duration                |
| Frequency            | Text                          |       No | Frequency information           |
| Instructor           | Text                          |       No | Instructor information          |
| Registration Enabled | Boolean                       |      Yes | Whether registration is enabled |
| Registration Form    | Relationship                  |       No | Form associated with activity   |
| Featured             | Boolean                       |       No | Featured activity               |
| Status               | WordPress status/custom field |      Yes | Publishing state                |

---

# 8. Center Data Model

Centers represent physical Rashtrotthana Yoga locations.

A Center should contain structured information so it can be reused across the website.

Example:

```text
Center
------------------------------
ID
Name
Description
Address
City
State
Pincode
Phone
Email
Opening Hours
Latitude
Longitude
Image
```

The primary record will use:

```text
wp_posts
```

with additional metadata in:

```text
wp_postmeta
```

---

# 9. Center Fields

| Field          | Type               |     Required | Description          |
| -------------- | ------------------ | -----------: | -------------------- |
| Name           | Title              |          Yes | Center name          |
| Description    | Content            |           No | Center description   |
| Address        | Text/HTML          |          Yes | Physical address     |
| City           | Text               |          Yes | City                 |
| State          | Text               |           No | State                |
| Pincode        | Text               |           No | Postal code          |
| Phone          | Text               |           No | Contact number       |
| Email          | Email              |           No | Contact email        |
| Opening Hours  | Structured/Text    |           No | Operating hours      |
| Latitude       | Decimal            | Yes for maps | Geographic latitude  |
| Longitude      | Decimal            | Yes for maps | Geographic longitude |
| Featured Image | Media              |           No | Center image         |
| Gallery        | Media relationship |           No | Center images        |
| Status         | Publish status     |          Yes | Visibility           |

---

# 10. Center Relationships

A Center may have multiple Activities.

Conceptually:

```text
Center
   |
   +---- Activity
   |
   +---- Activity
   |
   +---- Activity
```

A Center may also have multiple Events.

```text
Center
   |
   +---- Event
   |
   +---- Event
```

The implementation should avoid duplicating center address information inside each Activity or Event.

Instead:

```text
Activity
   |
   +---- center_id / center relationship
             |
             v
          Center
```

---

# 11. Events Data Model

Events represent workshops, programs, camps, special activities or other scheduled events.

Example:

```text
Event
------------------------------
ID
Title
Description
Start Date
Start Time
End Date
End Time
Venue
Center
Image
Registration Form
Capacity
Registration Status
```

The event itself should remain separate from registrations.

---

# 12. Event Fields

| Field                | Type               | Required |
| -------------------- | ------------------ | -------: |
| Title                | Title              |      Yes |
| Description          | Content            |      Yes |
| Start Date           | Date               |      Yes |
| Start Time           | Time               |       No |
| End Date             | Date               |       No |
| End Time             | Time               |       No |
| Venue                | Text               |      Yes |
| Center               | Relationship       |       No |
| Featured Image       | Media              |       No |
| Gallery              | Media relationship |       No |
| Registration Enabled | Boolean            |      Yes |
| Registration Form    | Relationship       |       No |
| Maximum Participants | Integer            |       No |
| Registration Start   | DateTime           |       No |
| Registration End     | DateTime           |       No |
| Featured             | Boolean            |       No |
| Status               | Status             |      Yes |

---

# 13. Upcoming and Past Events

Events should not require separate database tables for upcoming and past events.

The application can determine status from event dates.

Conceptually:

```text
Current Date
     |
     v
Event Start Date
     |
     +---- Future ----> Upcoming
     |
     +---- Past ------> Past
```

This avoids duplicate event records.

---

# 14. Resources Data Model

Resources contain downloadable or viewable content.

Examples:

* PDFs
* Documents
* Videos
* Educational materials
* Guides

Resources will use a Custom Post Type.

Example:

```text
Resource
------------------------------
ID
Title
Description
Category
Language
Media
Visibility
Publication Date
```

---

# 15. Resource Fields

| Field             | Type              |
| ----------------- | ----------------- |
| Title             | Text              |
| Description       | Rich Text         |
| Resource Category | Taxonomy          |
| Language          | Taxonomy/metadata |
| Attached File     | Media             |
| External URL      | URL               |
| Resource Type     | Taxonomy          |
| Visibility        | Status            |
| Featured Image    | Media             |

---

# 16. Gallery Data Model

WordPress Media Library will provide the base storage mechanism.

Gallery organization can use:

```text
Gallery Category
        |
        +---- Image
        +---- Image
        +---- Image
```

Optional Event relationship:

```text
Event
   |
   +---- Gallery Images
```

Gallery images should reference existing WordPress media rather than duplicating files.

---

# 17. Testimonials

Testimonials will use a Custom Post Type.

Suggested fields:

```text
Name
Designation / Description
Testimonial Text
Photo
Rating
Featured
Status
```

Photo is optional.

---

# 18. FAQs

FAQs will use a Custom Post Type or equivalent structured WordPress content model.

Suggested fields:

```text
Question
Answer
Category
Display Order
Featured
Status
```

---

# 19. Banners

Banners may be represented using a dedicated Custom Post Type or structured options depending on implementation requirements.

Suggested fields:

```text
Title
Subtitle
Image
Mobile Image
CTA Text
CTA URL
Display Order
Start Date
End Date
Active
```

---

# 20. Taxonomies

Taxonomies will be used where content requires classification.

Possible taxonomies:

```text
Activity Categories
Resource Categories
Gallery Categories
FAQ Categories
Resource Types
Languages
```

Example:

```text
Activity
   |
   +---- Category: Beginner
   +---- Category: Meditation
   +---- Category: Advanced
```

---

# 21. WordPress Core Tables

The project will use standard WordPress tables.

Important tables include:

```text
wp_posts
wp_postmeta
wp_users
wp_usermeta
wp_terms
wp_termmeta
wp_term_taxonomy
wp_term_relationships
wp_options
wp_comments
wp_commentmeta
```

The exact table prefix may differ between installations.

The implementation must never assume that the prefix is always `wp_`.

---

# 22. `wp_posts`

This is the primary WordPress content table.

It will contain records for:

```text
Pages
Posts
Activities
Centers
Events
Resources
Testimonials
FAQs
Attachments
```

Custom Post Types are identified through the `post_type` field.

Examples:

```text
post_type = page
post_type = activity
post_type = center
post_type = event
post_type = resource
```

---

# 23. `wp_postmeta`

Structured metadata associated with WordPress content will be stored using WordPress post metadata where appropriate.

Examples:

```text
activity_duration
activity_frequency
activity_center
activity_registration_enabled

center_address
center_phone
center_email
center_latitude
center_longitude

event_start_date
event_start_time
event_end_date
event_end_time
event_capacity
```

The implementation should avoid storing large, frequently queried transactional datasets in post metadata.

---

# 24. `wp_users`

WordPress users will be used for:

* Administrators
* Content Managers
* Registration Managers

User authentication remains handled by WordPress.

---

# 25. User Roles

Recommended roles:

```text
Administrator
Content Manager
Registration Manager
```

Capabilities will determine access.

Example:

```text
Administrator
    |
    +-- Full access

Content Manager
    |
    +-- Manage content

Registration Manager
    |
    +-- Manage registrations
```

---

# 26. Registration Database

Registration information is different from ordinary website content.

Therefore, dedicated custom tables should be used.

Conceptually:

```text
Activity / Event
       |
       v
Registration Form
       |
       v
Form Fields
       |
       v
Registration
       |
       v
Registration Answers
```

---

# 27. Registration Tables

Recommended custom tables:

```text
wp_ry_forms
wp_ry_form_fields
wp_ry_registrations
wp_ry_registration_answers
```

The `ry` prefix represents Rashtrotthana Yoga.

The actual table names should use the site's dynamic WordPress database prefix.

---

# 28. Forms Table

Conceptual table:

```text
wp_ry_forms
```

Fields:

| Field       | Type     | Description        |
| ----------- | -------- | ------------------ |
| id          | BIGINT   | Primary key        |
| title       | VARCHAR  | Form name          |
| description | TEXT     | Form description   |
| status      | VARCHAR  | Active/inactive    |
| created_by  | BIGINT   | WordPress user ID  |
| created_at  | DATETIME | Creation timestamp |
| updated_at  | DATETIME | Last update        |

Primary key:

```text
id
```

Foreign key:

```text
created_by -> wp_users.ID
```

The implementation should use appropriate indexes.

---

# 29. Form Fields Table

Conceptual table:

```text
wp_ry_form_fields
```

Fields:

| Field      | Type          | Description                   |
| ---------- | ------------- | ----------------------------- |
| id         | BIGINT        | Primary key                   |
| form_id    | BIGINT        | Parent form                   |
| field_key  | VARCHAR       | Unique field identifier       |
| label      | VARCHAR       | Display label                 |
| field_type | VARCHAR       | Input type                    |
| options    | LONGTEXT/JSON | Options for select/radio/etc. |
| required   | TINYINT       | Required flag                 |
| sort_order | INT           | Display order                 |
| settings   | LONGTEXT/JSON | Additional configuration      |
| created_at | DATETIME      | Creation timestamp            |
| updated_at | DATETIME      | Last update                   |

Relationship:

```text
Form
 |
 +---- Field
 +---- Field
 +---- Field
```

---

# 30. Supported Form Field Types

The initial form system may support:

```text
text
textarea
email
phone
number
date
select
radio
checkbox
file
```

Additional field types can be introduced later.

---

# 31. Registrations Table

Conceptual table:

```text
wp_ry_registrations
```

Suggested fields:

| Field        | Type     | Description                          |
| ------------ | -------- | ------------------------------------ |
| id           | BIGINT   | Primary key                          |
| form_id      | BIGINT   | Registration form                    |
| activity_id  | BIGINT   | Related Activity                     |
| event_id     | BIGINT   | Related Event                        |
| name         | VARCHAR  | Participant name                     |
| email        | VARCHAR  | Participant email                    |
| phone        | VARCHAR  | Participant phone                    |
| status       | VARCHAR  | Registration status                  |
| submitted_at | DATETIME | Submission time                      |
| updated_at   | DATETIME | Last update                          |
| source       | VARCHAR  | Registration source                  |
| ip_hash      | VARCHAR  | Optional privacy-safe tracking value |

Activity relationship:

```text
activity_id -> WordPress Activity post ID
```

Event relationship:

```text
event_id -> WordPress Event post ID
```

At least one of Activity or Event should be associated when the registration is created, according to the applicable registration flow.

---

# 32. Registration Status

Recommended statuses:

```text
pending
confirmed
cancelled
waitlisted
rejected
```

The exact workflow can be finalized during implementation.

Status should not be stored as arbitrary user-entered text.

---

# 33. Registration Answers Table

Conceptual table:

```text
wp_ry_registration_answers
```

Suggested fields:

| Field           | Type     |
| --------------- | -------- |
| id              | BIGINT   |
| registration_id | BIGINT   |
| field_id        | BIGINT   |
| value           | LONGTEXT |
| created_at      | DATETIME |
| updated_at      | DATETIME |

Relationship:

```text
Registration
      |
      +---- Answer
      +---- Answer
      +---- Answer
```

This allows each registration to have a different set of custom answers.

---

# 34. Why Answers Are Separate

The system should not create a database column for every possible custom form field.

Avoid:

```text
registration
--------------------------------
name
email
phone
age
gender
city
emergency_contact
custom_field_1
custom_field_2
custom_field_3
...
```

Instead:

```text
Registration
      |
      +---- Field: Age
      |       Value: 28
      |
      +---- Field: Gender
      |       Value: Female
      |
      +---- Field: City
              Value: Bengaluru
```

This makes the form builder flexible.

---

# 35. Registration Relationships

The conceptual relationship is:

```text
Activity
   |
   +---- Registration Form
              |
              +---- Form Fields
              |
              +---- Registrations
                         |
                         +---- Answers
```

Events use the same structure:

```text
Event
   |
   +---- Registration Form
              |
              +---- Form Fields
              |
              +---- Registrations
```

---

# 36. One Person and Multiple Registrations

The system should allow a person to register for multiple Activities or Events.

Example:

```text
Participant
   |
   +---- Registration A
   |       |
   |       +---- Yoga Workshop
   |
   +---- Registration B
           |
           +---- Meditation Program
```

Registrations should remain independent records.

---

# 37. Capacity Management

Where an Activity/Event has a capacity:

```text
Maximum Capacity
        |
        v
Confirmed Registrations
        |
        v
Available Capacity
```

Conceptually:

```text
available =
maximum_capacity - confirmed_registrations
```

Capacity checks must happen server-side.

Two simultaneous submissions must not be allowed to bypass capacity controls.

---

# 38. Registration Indexes

The registration tables should include indexes for frequently queried fields.

Recommended indexes include:

```text
form_id
activity_id
event_id
status
submitted_at
email
phone
```

The final index strategy should be confirmed against actual query patterns.

---

# 39. Data Integrity

The system should maintain consistent relationships.

Examples:

```text
Registration
    |
    +-- Form must exist
```

```text
Registration
    |
    +-- Activity/Event must reference valid WordPress content
```

```text
Registration Answer
    |
    +-- Registration must exist
    +-- Field must exist
```

Where appropriate, the plugin should validate relationships before performing database writes.

---

# 40. Database Queries

All database operations must use WordPress's database abstraction APIs.

Use:

```php
$wpdb
```

rather than directly opening a separate database connection.

Queries must use prepared statements where user input is involved.

Conceptually:

```php
$wpdb->prepare(...)
```

must be used for parameterized queries.

---

# 41. Database Table Prefix

The implementation must never hardcode:

```text
wp_
```

as the database prefix.

Use:

```php
$wpdb->prefix
```

or the appropriate WordPress database APIs.

Example:

```text
$wpdb->prefix . 'ry_registrations'
```

This ensures compatibility with installations using a different database prefix.

---

# 42. Registration Table Creation

The Registration plugin will create its tables during plugin activation.

WordPress's database upgrade mechanisms should be used.

The implementation should support future schema upgrades.

Example conceptual versioning:

```text
DB Version 1
    |
    v
DB Version 2
    |
    v
DB Version 3
```

Schema changes should be migration-safe.

---

# 43. Deactivation and Uninstallation

Deactivating the Registration plugin should not automatically delete registration data.

Data deletion should only occur through an intentional uninstall process if approved.

The plugin must avoid accidental destruction of participant records.

---

# 44. Media Relationships

Media will generally use WordPress attachment records.

For example:

```text
Center
   |
   +---- Featured Image
   |
   +---- Gallery Media

Activity
   |
   +---- Featured Image
   |
   +---- Gallery Media

Event
   |
   +---- Featured Image
```

WordPress attachment IDs should be used rather than duplicating media metadata unnecessarily.

---

# 45. SEO Data

SEO information may be managed through the approved SEO solution.

Where custom SEO fields are required, they should be associated with the corresponding content entity.

Examples:

```text
SEO Title
Meta Description
Canonical URL
Social Image
```

SEO data should remain associated with the relevant page/activity/event/etc.

---

# 46. Website Settings

Global website configuration can use WordPress options.

Examples:

```text
Organization Name
Logo
Primary Email
Phone
Social Links
Default Language
Contact Information
Google Maps Configuration
```

Sensitive integration credentials should not be treated as ordinary public content.

---

# 47. WATI Configuration

WATI settings may include:

```text
API Base URL
API Token
Account Configuration
Template IDs
Webhook Configuration
```

Sensitive credentials must be stored securely.

They must never be exposed through public REST responses or frontend JavaScript.

---

# 48. Google Maps Configuration

The configuration may include:

```text
Google Maps API Key
Map ID
Default Latitude
Default Longitude
Zoom Level
```

The API key must be restricted according to Google Maps security recommendations.

---

# 49. Multilingual Data

Multilingual implementation will be handled through the selected WordPress multilingual solution.

Content requiring translation includes:

```text
Pages
Activities
Centers
Events
Resources
Menus
Forms
Form labels
System messages
```

The database model should remain compatible with the selected multilingual solution.

The exact translation table structure will depend on the final approved multilingual plugin.

---

# 50. Search Data

Searchable content should be derived from public WordPress content.

The system should not expose:

```text
Registration records
Participant information
Administrative information
API credentials
```

through public search.

---

# 51. Audit and Administrative Records

The project may require administrative activity logging.

Potential information:

```text
User
Action
Entity
Entity ID
Timestamp
IP information where appropriate
Result
```

If audit logging is implemented, the exact retention policy must be agreed with Rashtrotthana IT.

Sensitive data should not be copied unnecessarily into audit logs.

---

# 52. Suggested Audit Table

If required, a custom table may be introduced:

```text
wp_ry_audit_logs
```

Suggested fields:

```text
id
user_id
action
object_type
object_id
metadata
created_at
```

Example actions:

```text
activity_created
activity_updated
event_created
registration_viewed
registration_exported
wati_message_sent
```

---

# 53. Database Security

Database security requirements include:

* Strong database credentials
* Restricted database access
* Least-privilege database users
* Secure server configuration
* Prepared queries
* Input validation
* Output escaping
* Controlled access to registration tables
* Regular backups

The application should never expose raw database errors to visitors.

---

# 54. Participant Data Protection

Registration information can contain personal information.

Access must therefore be restricted.

Only authorized roles should access participant data.

Example:

```text
Public Visitor
     |
     X
Registrations

Content Manager
     |
     X
Registrations

Registration Manager
     |
     v
Registrations

Administrator
     |
     v
Registrations
```

Actual permissions should be finalized with Rashtrotthana.

---

# 55. CSV Export

CSV export will read from the registration tables.

Flow:

```text
Administrator
      |
      v
Registrations
      |
      v
Filter
      |
      v
Export CSV
      |
      v
Generated File
```

Possible filters:

```text
Activity
Event
Form
Status
Date Range
```

CSV export must be protected by WordPress capabilities.

The export endpoint must not be publicly accessible.

---

# 56. Database Backup

The database backup must include:

```text
WordPress core data
Custom content
Registration tables
Options
Users
Metadata
Taxonomies
```

Database restoration should be tested in staging periodically.

---

# 57. Development Database

Each developer should have a separate local database.

Example:

```text
Developer 1
    |
    +-- Local DB

Developer 2
    |
    +-- Local DB

Developer 3
    |
    +-- Local DB
```

The source code is synchronized through Git.

Database content itself should not normally be committed to Git.

---

# 58. Database Seed Data

Where required, the project may provide development seed data.

Examples:

```text
Sample Activities
Sample Centers
Sample Events
Sample Resources
Sample Forms
Sample Registrations
```

Seed data must be clearly identified as development/test data.

Production participant data must never be committed to the repository.

---

# 59. Database Migrations

Database changes must be versioned.

Example:

```text
Migration 001
Create registration tables

Migration 002
Add registration status

Migration 003
Add capacity fields

Migration 004
Add webhook status
```

Migration logic must be idempotent or safely version-controlled.

---

# 60. Conceptual Entity Relationship Diagram

```text
                         USERS
                           |
                           |
                           v
                    +-------------+
                    | WordPress   |
                    | Users       |
                    +-------------+
                           |
                           |
                           v
                    +-------------+
                    |   CONTENT   |
                    +-------------+
                     /     |      \
                    /      |       \
                   v       v        v
              ACTIVITY   CENTER    EVENT
                  |         |        |
                  |         |        |
                  +----+----+--------+
                       |
                       v
                REGISTRATION FORM
                       |
                       v
                 FORM FIELDS
                       |
                       v
                 REGISTRATIONS
                       |
                       v
              REGISTRATION ANSWERS
```

---

# 61. Simplified Data Relationship

```text
CENTER
  |
  +------< ACTIVITIES
  |
  +------< EVENTS


ACTIVITY
  |
  +------> REGISTRATION FORM
                 |
                 +------< FORM FIELDS
                 |
                 +------< REGISTRATIONS
                              |
                              +------< ANSWERS


EVENT
  |
  +------> REGISTRATION FORM
                 |
                 +------< FORM FIELDS
                 |
                 +------< REGISTRATIONS
                              |
                              +------< ANSWERS
```

---

# 62. Recommended Naming Convention

Custom database tables:

```text
{prefix}ry_forms
{prefix}ry_form_fields
{prefix}ry_registrations
{prefix}ry_registration_answers
```

Custom PHP classes/functions should use the project prefix:

```text
RY_
ry_
```

or an agreed namespace such as:

```text
Rashtrotthana\
```

The exact coding standard is documented separately in `coding-standards.md`.

---

# 63. Data Lifecycle

## Content

```text
Draft
  |
  v
Review
  |
  v
Published
  |
  v
Updated
  |
  v
Archived
```

## Registration

```text
Submitted
   |
   v
Pending
   |
   +----> Confirmed
   |
   +----> Waitlisted
   |
   +----> Cancelled
```

---

# 64. Database Performance Guidelines

The implementation should:

1. Avoid unnecessary custom tables.
2. Avoid excessive post metadata for transactional queries.
3. Add indexes to frequently filtered registration columns.
4. Avoid loading all registrations into memory.
5. Paginate administrative registration screens.
6. Use efficient queries.
7. Avoid repeated queries inside loops.
8. Cache non-transactional content where appropriate.
9. Avoid querying private data on public pages.
10. Monitor slow queries during testing.

---

# 65. Database Scalability

The initial database model is designed for the current website requirements.

Future functionality may introduce additional tables for:

```text
Payments
Volunteers
Learning Courses
Certificates
Advanced Analytics
AI Knowledge Base
Mobile Applications
```

Future tables must be introduced only when the feature is approved.

---

# 66. Important Implementation Rule

The database should distinguish between:

```text
Content
```

and:

```text
Transactional Data
```

Content:

```text
Activities
Centers
Events
Resources
Pages
```

should primarily use WordPress.

Transactional data:

```text
Registrations
Registration Answers
Form Definitions
```

should use dedicated custom tables where appropriate.

This distinction keeps the WordPress content system manageable while allowing the registration system to scale independently.

---

# 67. Final Database Structure

The final conceptual structure is:

```text
WORDPRESS NATIVE
|
├── Users
├── Pages
├── Activities
├── Centers
├── Events
├── Resources
├── Testimonials
├── FAQs
├── Media
├── Taxonomies
├── Menus
└── Options
        |
        v
CUSTOM REGISTRATION
|
├── Forms
├── Form Fields
├── Registrations
└── Registration Answers
        |
        v
EXTERNAL SERVICES
|
├── Google Maps
└── WATI
```

---

# 68. Database Design Principles

The following rules should be followed throughout development:

1. Use WordPress native data structures whenever they are appropriate.
2. Use Custom Post Types for structured repeatable website content.
3. Use custom tables for registration-specific transactional data.
4. Never hardcode the WordPress database prefix.
5. Use `$wpdb` and prepared queries for custom database operations.
6. Validate relationships before inserting records.
7. Index frequently queried registration fields.
8. Protect participant information using WordPress capabilities.
9. Never commit production data to Git.
10. Never expose API credentials through the database to public users.
11. Do not delete registration data simply because a plugin is deactivated.
12. Version database schema changes.
13. Test migrations before production deployment.
14. Back up the database regularly.
15. Test restoration procedures.
16. Keep content data separate from transactional registration data.
17. Avoid unnecessary duplication of information.
18. Do not store sensitive data in logs unless explicitly required.
19. Do not expose raw database errors to visitors.
20. Maintain compatibility with the selected multilingual solution.

---

# 69. Summary

The Rashtrotthana Yoga website will use WordPress's native database model for normal website content and dedicated custom tables for the registration system.

The primary content model will consist of:

```text
Activities
Centers
Events
Resources
Gallery
Testimonials
FAQs
Pages
```

The registration subsystem will consist of:

```text
Forms
Form Fields
Registrations
Registration Answers
```

This architecture provides a structured, flexible and maintainable foundation for the current website while leaving room for future functionality such as payments, volunteer management, learning platforms, analytics and the currently deferred AI Knowledge Assistant.
