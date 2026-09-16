# Rashtrotthana Yoga Website

## API Specification

**Document:** `api.md`
**Project:** Rashtrotthana Yoga Website
**Version:** 1.0
**Status:** Development Specification
**Platform:** WordPress

---

# 1. Purpose

This document defines the API architecture for the Rashtrotthana Yoga WordPress website.

The project does not require a separate FastAPI backend for the current implementation.

WordPress will act as the primary application platform.

APIs will be used where required for:

* WordPress internal communication
* AJAX operations
* Dynamic frontend functionality
* Registration submission
* Search
* Google Maps integration
* WATI integration
* Future external applications
* Future AI integration

---

# 2. API Architecture

The API architecture is:

```text
                         CLIENT
                           |
                           | HTTPS
                           v
                    WORDPRESS API
                           |
             +-------------+-------------+
             |             |             |
             v             v             v
          Content      Registration   Integrations
             |             |             |
             v             v             v
        WordPress DB   Custom Tables   External APIs
```

---

# 3. API Principles

All APIs must follow these principles:

1. HTTPS must be used.
2. Public endpoints must expose only public data.
3. Private endpoints must require authorization.
4. Input must be validated.
5. Output must be sanitized/escaped appropriately.
6. Nonces must be used where applicable for authenticated browser requests.
7. Capability checks must be performed for administrative operations.
8. API credentials must never be exposed to visitors.
9. Error responses must not reveal sensitive implementation details.
10. External API failures must be handled gracefully.

---

# 4. WordPress REST API

The project may use the WordPress REST API for structured content.

Potential public endpoints include:

```text
/wp-json/wp/v2/pages
/wp-json/wp/v2/posts
```

Custom Post Types may expose REST endpoints when required.

For example:

```text
/wp-json/wp/v2/activity
/wp-json/wp/v2/center
/wp-json/wp/v2/event
/wp-json/wp/v2/resource
```

The exact public exposure of each endpoint must be reviewed during implementation.

---

# 5. Public API Principle

Only information intended for public consumption should be exposed.

For example, an Activity endpoint may expose:

```json
{
  "id": 123,
  "title": "Yoga for Beginners",
  "description": "...",
  "featured_image": "...",
  "center": 25
}
```

It must not expose:

```text
Internal admin notes
Private metadata
Registration participant information
API credentials
Internal configuration
```

---

# 6. Content API

The content API provides structured website information.

Major content groups:

```text
Activities
Centers
Events
Resources
Pages
```

---

# 7. Activities API

Conceptual endpoints:

```text
GET /wp-json/ry/v1/activities
GET /wp-json/ry/v1/activities/{id}
```

Optional filtering:

```text
GET /wp-json/ry/v1/activities?category=yoga
GET /wp-json/ry/v1/activities?center=25
GET /wp-json/ry/v1/activities?featured=true
```

The exact route namespace should be finalized during implementation.

---

# 8. Activity List Response

Example conceptual response:

```json
{
  "items": [
    {
      "id": 123,
      "title": "Yoga for Beginners",
      "slug": "yoga-for-beginners",
      "short_description": "Introduction to yoga.",
      "featured_image": {
        "url": "https://example.com/image.jpg",
        "alt": "Yoga session"
      },
      "category": {
        "id": 5,
        "name": "Yoga"
      },
      "center": {
        "id": 25,
        "name": "Bangalore Center"
      },
      "registration_enabled": true
    }
  ],
  "pagination": {
    "page": 1,
    "per_page": 12,
    "total": 1
  }
}
```

This is an illustrative response model.

---

# 9. Activity Detail API

Conceptual:

```text
GET /wp-json/ry/v1/activities/{id}
```

Response may contain:

```text
ID
Title
Slug
Description
Featured Image
Gallery
Category
Center
Duration
Frequency
Instructor
Registration Status
Registration Form ID
```

Private registration information must not be returned.

---

# 10. Centers API

Conceptual endpoints:

```text
GET /wp-json/ry/v1/centers
GET /wp-json/ry/v1/centers/{id}
```

Optional filters:

```text
GET /wp-json/ry/v1/centers?city=...
GET /wp-json/ry/v1/centers?search=...
```

---

# 11. Center Response

Example:

```json
{
  "id": 25,
  "name": "Bangalore Yoga Center",
  "address": "Example Address",
  "city": "Bengaluru",
  "phone": "+91XXXXXXXXXX",
  "email": "example@example.com",
  "latitude": 12.9716,
  "longitude": 77.5946,
  "map": {
    "enabled": true
  }
}
```

Actual production contact information will come from Rashtrotthana.

---

# 12. Events API

Conceptual endpoints:

```text
GET /wp-json/ry/v1/events
GET /wp-json/ry/v1/events/{id}
```

Filtering:

```text
GET /wp-json/ry/v1/events?status=upcoming
GET /wp-json/ry/v1/events?status=past
GET /wp-json/ry/v1/events?center=25
```

---

# 13. Event Response

Example:

```json
{
  "id": 100,
  "title": "Yoga Workshop",
  "slug": "yoga-workshop",
  "description": "...",
  "start_date": "2026-09-15",
  "start_time": "10:00",
  "end_date": "2026-09-15",
  "end_time": "13:00",
  "venue": "Example Venue",
  "center": {
    "id": 25,
    "name": "Bangalore Center"
  },
  "registration_enabled": true,
  "capacity": 100
}
```

Capacity information may be exposed publicly only if required.

---

# 14. Resources API

Conceptual endpoints:

```text
GET /wp-json/ry/v1/resources
GET /wp-json/ry/v1/resources/{id}
```

Filters:

```text
GET /wp-json/ry/v1/resources?category=...
GET /wp-json/ry/v1/resources?language=en
GET /wp-json/ry/v1/resources?type=pdf
```

Only publicly accessible resources may be returned by public endpoints.

---

# 15. Search API

Conceptual endpoint:

```text
GET /wp-json/ry/v1/search?q=yoga
```

Possible parameters:

```text
q
page
per_page
type
language
category
```

Example:

```text
GET /wp-json/ry/v1/search?q=meditation&type=activity
```

---

# 16. Search Response

Example:

```json
{
  "query": "meditation",
  "results": [
    {
      "id": 10,
      "type": "activity",
      "title": "Meditation Program",
      "url": "/activities/meditation-program/",
      "excerpt": "..."
    },
    {
      "id": 25,
      "type": "resource",
      "title": "Meditation Guide",
      "url": "/resources/meditation-guide/",
      "excerpt": "..."
    }
  ],
  "pagination": {
    "page": 1,
    "per_page": 20,
    "total": 2
  }
}
```

---

# 17. Registration API

Registration APIs are private business functionality even though the submission originates from the public website.

Conceptual endpoints:

```text
GET  /wp-json/ry/v1/forms/{id}
POST /wp-json/ry/v1/forms/{id}/submit
```

The GET endpoint may expose only fields required to render the public registration form.

The POST endpoint accepts a registration submission.

---

# 18. Registration Form API

Example:

```text
GET /wp-json/ry/v1/forms/10
```

Response:

```json
{
  "id": 10,
  "title": "Yoga Workshop Registration",
  "fields": [
    {
      "key": "name",
      "label": "Full Name",
      "type": "text",
      "required": true
    },
    {
      "key": "email",
      "label": "Email",
      "type": "email",
      "required": true
    },
    {
      "key": "phone",
      "label": "Phone",
      "type": "phone",
      "required": true
    }
  ]
}
```

---

# 19. Registration Submission

Conceptual:

```text
POST /wp-json/ry/v1/forms/10/submit
```

Example request:

```json
{
  "activity_id": 123,
  "answers": {
    "name": "Example Person",
    "email": "example@example.com",
    "phone": "+91XXXXXXXXXX"
  }
}
```

The actual implementation may use a more structured answer array to support arbitrary fields.

---

# 20. Registration Validation

Validation must happen on the server.

Validation includes:

```text
Form exists
Activity/Event exists
Registration is enabled
Registration period is active
Capacity is available
Required fields are present
Field values match field types
Email is valid
Phone format is acceptable
Submitted data is sanitized
```

Browser validation is supplementary only.

---

# 21. Registration Response

Successful registration:

```json
{
  "success": true,
  "registration_id": 10001,
  "status": "confirmed",
  "message": "Registration submitted successfully."
}
```

The response must not expose unnecessary participant information.

---

# 22. Registration Failure

Example:

```json
{
  "success": false,
  "code": "registration_closed",
  "message": "Registration is currently closed."
}
```

Possible error codes:

```text
invalid_form
invalid_activity
invalid_event
registration_disabled
registration_closed
capacity_full
invalid_field
missing_required_field
server_error
```

---

# 23. Registration Security

Registration endpoints must implement appropriate protections against:

* Spam
* Automated submissions
* CSRF
* Malicious payloads
* SQL injection
* XSS
* Excessive requests

Rate limiting and anti-spam measures may be implemented according to final infrastructure requirements.

---

# 24. Administrative Registration API

Administrative registration endpoints must require authentication and authorization.

Conceptual:

```text
GET /wp-json/ry/v1/admin/registrations
GET /wp-json/ry/v1/admin/registrations/{id}
POST /wp-json/ry/v1/admin/registrations/{id}/status
GET /wp-json/ry/v1/admin/registrations/export
```

These endpoints must not be publicly accessible.

---

# 25. Administrative Capability Checks

Before returning registration information, the server must check the appropriate WordPress capability.

Example conceptual capability:

```text
manage_ry_registrations
```

The exact capability name will be finalized during implementation.

---

# 26. Registration Filtering

Administrative filtering may support:

```text
Activity
Event
Form
Status
Date Range
Email
Phone
```

Example:

```text
GET /wp-json/ry/v1/admin/registrations?event=100&status=confirmed
```

---

# 27. Registration Pagination

Administrative registration endpoints must paginate results.

Example:

```text
?page=1&per_page=50
```

The system should not load thousands of registration records into memory unnecessarily.

---

# 28. CSV Export API

Conceptual:

```text
GET /wp-json/ry/v1/admin/registrations/export
```

Possible filters:

```text
activity
event
status
start_date
end_date
```

The endpoint must require appropriate administrative permissions.

---

# 29. WATI Integration API

WATI is an external API and should be called from the WordPress server.

Flow:

```text
WordPress
    |
    | HTTPS
    v
WATI API
    |
    v
WhatsApp
```

WATI credentials must never be sent to browsers.

---

# 30. WATI Server-Side Flow

Example:

```text
Registration
     |
     v
WordPress
     |
     v
Registration Saved
     |
     v
WATI Service
     |
     v
WATI API
     |
     v
WhatsApp
```

The registration should not depend on a successful frontend API call to WATI.

---

# 31. WATI Message API

The exact WATI API endpoint will depend on the WATI account/API version provided by Rashtrotthana.

The implementation must use the official WATI API documentation and credentials supplied by Rashtrotthana.

The plugin should isolate WATI-specific API calls behind a service layer.

Conceptually:

```text
Registration Service
       |
       v
WATI Service
       |
       v
WATI API Client
       |
       v
WATI
```

---

# 32. WATI Configuration

The plugin configuration may contain:

```text
API Base URL
API Token
Account Configuration
Template IDs
Sender Configuration
Webhook Configuration
```

Sensitive values must not be exposed publicly.

---

# 33. WATI Error Handling

If WATI fails:

```text
Registration
     |
     v
Database Save
     |
     +---- Success
     |
     v
Attempt WATI
     |
     +---- Success
     |
     +---- Failure
             |
             v
         Log Error
```

The registration should remain stored if WATI communication fails after successful registration.

---

# 34. WATI Webhooks

If enabled by the approved WATI integration, WordPress may receive webhook events.

Conceptual endpoint:

```text
POST /wp-json/ry/v1/wati/webhook
```

Potential events:

```text
message_sent
message_delivered
message_read
message_failed
```

The exact event types depend on WATI capabilities.

---

# 35. Webhook Security

Webhook requests must be verified using the security mechanism supported by WATI.

The endpoint must reject unauthenticated or invalid webhook requests.

Webhook payloads should be validated before processing.

---

# 36. Google Maps Integration

Google Maps is an external frontend/service integration.

The primary Center location data is stored in WordPress:

```text
Latitude
Longitude
Address
```

The frontend uses these values to display the location.

---

# 37. Google Maps API Flow

```text
WordPress Center
      |
      +-- Latitude
      +-- Longitude
      |
      v
Frontend Map
      |
      v
Google Maps Platform
      |
      v
Map + Marker
```

The Google Maps API key must be appropriately restricted.

---

# 38. Google Maps Security

The implementation should:

* Restrict API keys
* Use HTTPS
* Enable only required Google APIs
* Keep billing under Rashtrotthana ownership
* Avoid exposing unrestricted server credentials

The exact Google API configuration will be finalized during deployment.

---

# 39. Email API

Email notifications may be sent after successful registration.

Possible flow:

```text
Registration
      |
      v
WordPress
      |
      +---- Email
      |
      +---- WATI
```

Email sending may use:

* WordPress mail functionality
* SMTP
* Approved transactional email provider

The final provider will be selected during deployment.

---

# 40. API Namespaces

Custom REST APIs should use a project-specific namespace.

Recommended:

```text
ry/v1
```

Example:

```text
/wp-json/ry/v1/activities
```

Versioning is required so future API changes can be introduced without unexpectedly breaking existing consumers.

---

# 41. API Versioning

Current:

```text
ry/v1
```

Future breaking changes may use:

```text
ry/v2
```

Existing clients should continue to work until a documented migration path is provided.

---

# 42. Authentication

Public content endpoints generally require no authentication.

Administrative endpoints require WordPress authentication and capability checks.

Possible authentication mechanisms include:

```text
WordPress authenticated session
Application Passwords
OAuth/plugin-supported authentication
```

The exact authentication mechanism for external consumers will depend on the integration requirement.

---

# 43. Nonces

Browser-based authenticated operations should use WordPress nonces where applicable.

Nonces protect against unauthorized cross-site requests but are not a replacement for authentication or authorization.

---

# 44. Capability Checks

Every protected operation must check capabilities.

Example:

```php
current_user_can( 'manage_ry_registrations' )
```

The actual capability names will be defined by the plugin.

---

# 45. Input Validation

All API input must be validated.

Examples:

```text
ID -> integer
Email -> valid email
URL -> valid URL
Date -> valid date
Boolean -> boolean
Capacity -> non-negative integer
Latitude -> numeric range
Longitude -> numeric range
```

Unexpected fields should be ignored or rejected according to endpoint design.

---

# 46. Input Sanitization

After validation, data should be sanitized according to its purpose.

Examples:

```text
Text -> sanitize_text_field()
Textarea -> appropriate textarea sanitization
URL -> esc_url_raw()
Email -> sanitize_email()
```

The exact sanitization method must match the field type.

---

# 47. Output Handling

API responses should return structured data.

HTML should not be unnecessarily returned by APIs.

When HTML is required, it must be sanitized according to the allowed HTML rules.

Frontend rendering must not blindly inject untrusted HTML.

---

# 48. Error Handling

API errors should use consistent structures.

Example:

```json
{
  "code": "invalid_request",
  "message": "The request could not be processed.",
  "data": {
    "status": 400
  }
}
```

Sensitive implementation details must not be returned.

Do not expose:

```text
SQL errors
File system paths
API tokens
Stack traces
Internal server configuration
```

---

# 49. HTTP Status Codes

Recommended status codes:

|  Status | Meaning                      |
| ------: | ---------------------------- |
|     200 | Successful request           |
|     201 | Resource created             |
|     400 | Invalid request              |
|     401 | Authentication required      |
|     403 | Forbidden                    |
|     404 | Resource not found           |
|     409 | Conflict                     |
|     422 | Validation failure           |
|     429 | Rate limited                 |
|     500 | Server error                 |
| 502/503 | External service unavailable |

Exact use should be consistent across endpoints.

---

# 50. API Pagination

List endpoints should support pagination.

Recommended parameters:

```text
page
per_page
```

Example:

```text
?page=2&per_page=20
```

The maximum `per_page` value should be limited.

---

# 51. API Filtering

Where appropriate, list endpoints should support filtering.

Examples:

```text
?category=yoga
?center=25
?status=published
?featured=true
?language=en
```

Filters must be validated against allowed values.

---

# 52. API Sorting

Where required, endpoints may support controlled sorting.

Example:

```text
?orderby=date
?order=desc
```

Only approved fields should be accepted.

Arbitrary database columns must not be accepted from users.

---

# 53. API Rate Limiting

Public endpoints should be monitored for excessive requests.

Registration endpoints are especially sensitive.

Potential controls:

```text
IP-based rate limiting
Application-level throttling
Captcha/anti-spam
Web server rate limiting
```

The final implementation depends on hosting infrastructure.

---

# 54. API Caching

Public content APIs may be cached.

Potential cacheable content:

```text
Activities
Centers
Events
Resources
Pages
```

Transactional endpoints should not use unsafe stale caching.

Do not cache:

```text
Registration availability
Registration submission
Administrative registration data
WATI credentials
```

---

# 55. API Logging

Log important API failures and integration errors.

Examples:

```text
WATI API failure
Google Maps configuration error
Registration processing error
Webhook processing error
Authentication failure
```

Logs must avoid storing unnecessary participant information.

---

# 56. External API Timeout

External API requests should use appropriate timeouts.

A WATI or Google request must not cause the entire WordPress request to hang indefinitely.

Timeouts and retry behavior should be defined in the integration implementation.

---

# 57. Retry Strategy

Retries may be used for temporary external failures.

However, retries must not accidentally send duplicate WhatsApp messages or duplicate transactional operations.

Where retries are used, an idempotency mechanism or message tracking strategy should be considered.

---

# 58. API Security Rules

The following are mandatory:

```text
HTTPS
Input validation
Input sanitization
Capability checks
Authentication for private endpoints
Nonce protection where applicable
Prepared database queries
Rate limiting where appropriate
Secure credential storage
Safe error handling
```

---

# 59. Future Mobile Application

If Rashtrotthana later develops a mobile application:

```text
Mobile App
     |
     | HTTPS
     v
WordPress REST API
     |
     v
WordPress
     |
     v
MySQL/MariaDB
```

The current API architecture should make this possible without rebuilding the entire website.

---

# 60. Future AI Integration

The AI Knowledge Assistant is currently on hold.

If approved later:

```text
AI Application
      |
      | HTTPS
      v
WordPress API
      |
      v
Approved Public Content
```

The AI service should receive only the content and information it is authorized to access.

The AI service should not receive private registration data unless explicitly approved and securely designed.

---

# 61. API Documentation

Every custom endpoint should document:

```text
Endpoint
HTTP Method
Authentication
Authorization
Parameters
Request Body
Response
Errors
Permissions
Rate Limits
```

Example:

```text
GET /wp-json/ry/v1/activities

Authentication:
Not required for public published activities.

Parameters:
page
per_page
category
center
featured

Response:
Activity list.

Errors:
400
404
500
```

---

# 62. API Testing

Every API should be tested for:

```text
Valid requests
Invalid requests
Missing parameters
Invalid parameters
Unauthorized requests
Forbidden requests
Empty results
Large result sets
Malformed JSON
External API failure
Database failure
Rate limiting
```

Registration APIs require additional testing for capacity and duplicate submissions.

---

# 63. API Development Standards

Developers must:

1. Use the `ry/v1` namespace.
2. Avoid exposing unnecessary fields.
3. Validate all input.
4. Sanitize data before storage.
5. Escape output where applicable.
6. Use capability checks.
7. Use nonces for browser-based protected operations.
8. Use prepared database queries.
9. Handle external API failures.
10. Avoid leaking sensitive information.
11. Implement pagination.
12. Document every custom endpoint.
13. Version breaking changes.
14. Test unauthorized access.
15. Keep API credentials server-side.

---

# 64. API Summary

The API architecture is:

```text
                     WORDPRESS
                         |
             +-----------+-----------+
             |           |           |
             v           v           v
         Content     Registration  Admin APIs
           API           API
             |           |
             v           v
        WordPress DB  Custom Tables
                         |
                         |
             +-----------+-----------+
             |                       |
             v                       v
           WATI                 Google Maps
            API                      API
```

WordPress remains the central application platform.

External services are integrated through controlled server-side APIs.

The architecture supports the current website requirements while leaving a path for future mobile applications, AI integration and other approved services.
