# Rashtrotthana Yoga Website
## Activity Registration Module

**Document:** `registration.md`  
**Project:** Rashtrotthana Yoga Website  
**Version:** 1.0  
**Status:** Development Specification  
**Platform:** WordPress  

---

# 1. Purpose

This document defines the functional, technical and operational requirements for the Activity Registration Module of the Rashtrotthana Yoga website.

The module will allow visitors to register online for Rashtrotthana Yoga activities, programs, workshops and events where registration is enabled.

The registration system will be integrated with WordPress and managed through the WordPress administration panel.

---

# 2. Objectives

The registration system should provide:

- Online registration
- Activity-specific registration forms
- Participant data collection
- Registration confirmation
- Registration management
- Participant reports
- Export functionality
- Capacity management
- Registration status management
- Email notifications
- WATI/WhatsApp integration where configured
- Multilingual registration
- Administrative controls
- Secure handling of participant information
- Auditability of administrative actions

---

# 3. Scope

The module covers:

- Activity registration
- Event registration where required
- Registration forms
- Participant records
- Registration statuses
- Capacity limits
- Confirmation
- Notifications
- Admin management
- Reports
- Export
- Multilingual registration
- Integration hooks for WATI
- Integration hooks for email
- Basic registration security

The following are outside the core scope unless separately approved:

- Online payments
- Membership management
- Subscription billing
- Complex ticketing
- Seat selection
- QR-code ticketing
- Advanced CRM
- Mobile application registration

---

# 4. High-Level Registration Flow

```text
Visitor
   |
   v
Activity Page
   |
   v
Register Now
   |
   v
Registration Form
   |
   v
Validation
   |
   v
Capacity Check
   |
   v
Create Registration
   |
   v
Confirmation
   |
   +----------+----------+
   |                     |
   v                     v
Email Notification    WATI Notification
```

---

# 5. Registration Lifecycle

A registration should move through defined statuses.

Recommended statuses:

```text
Pending
Confirmed
Waitlisted
Cancelled
Rejected
Completed
```

The exact statuses may be simplified based on operational requirements.

---

# 6. Registration Status Definitions

## Pending

Registration has been submitted but has not yet been confirmed.

## Confirmed

Registration has been accepted successfully.

## Waitlisted

Activity capacity has been reached and the participant has been placed on a waiting list.

## Cancelled

Registration was cancelled.

## Rejected

Registration was not accepted by an administrator.

## Completed

Participant attended/completed the activity, where attendance tracking is required.

---

# 7. Activity Registration Configuration

Each Activity should have registration settings.

Example:

```text
Registration Enabled
[Yes]

Registration Start
[Date/Time]

Registration End
[Date/Time]

Capacity
[50]

Waitlist Enabled
[Yes]

Confirmation Required
[No]
```

The exact fields depend on the approved implementation.

---

# 8. Registration Button

If registration is enabled:

```text
[ Register Now ]
```

If registration is disabled:

```text
Registration currently unavailable
```

The website must not display an active registration button for activities that are not accepting registrations.

---

# 9. Registration Availability

Registration availability should consider:

```text
Activity Published
        |
        v
Registration Enabled?
        |
        v
Registration Start Reached?
        |
        v
Registration End Passed?
        |
        v
Capacity Available?
        |
        v
Registration Available
```

---

# 10. Registration Window

An activity may define:

- Registration opening date/time
- Registration closing date/time

Example:

```text
Registration Opens:
01 September 2026, 09:00

Registration Closes:
10 September 2026, 18:00
```

Outside this window, registration should be disabled.

---

# 11. Capacity Management

Each activity may define a maximum participant capacity.

Example:

```text
Capacity:
50

Confirmed:
42

Available:
8
```

The system should prevent confirmed registrations from exceeding the configured capacity.

---

# 12. Capacity Calculation

Conceptually:

```text
Available Capacity =
Maximum Capacity - Active Confirmed Registrations
```

Cancelled registrations should not continue consuming capacity.

Waitlisted registrations should not count as confirmed capacity unless explicitly configured.

---

# 13. Registration Race Condition

Capacity checks must account for simultaneous registrations.

Example:

```text
Capacity = 1

User A ----+
           |
           +---- Registration System
           |
User B ----+
```

The system must prevent both users from being confirmed for the final available slot.

The database/application implementation should use appropriate transaction and locking behavior.

---

# 14. Waitlist

If waitlist is enabled and capacity is full:

```text
Activity Full
     |
     v
Waitlist Enabled?
     |
   +---+---+
   |       |
  Yes      No
   |       |
   v       v
Waitlist  Closed
```

---

# 15. Waitlist Promotion

If a confirmed registration is cancelled:

```text
Confirmed Registration Cancelled
              |
              v
       Capacity Available
              |
              v
      First Waitlisted User
              |
              v
         Promotion
```

Automatic promotion may be implemented if approved.

Otherwise an administrator may manually promote participants.

---

# 16. Registration Form

A basic registration form may include:

```text
Full Name *
Mobile Number *
Email Address *
Age
Gender
City
Address
Emergency Contact
Activity
Consent
```

The exact fields must be finalized with Rashtrotthana.

Only required information should be collected.

---

# 17. Required Fields

Required fields should be clearly indicated.

Example:

```text
Full Name *
Mobile Number *
Email Address *
```

The backend must enforce required fields even if frontend validation is bypassed.

---

# 18. Field Validation

Validation must occur:

```text
Frontend
+
Backend
```

Frontend validation improves user experience.

Backend validation provides the actual security boundary.

---

# 19. Name Validation

The name field should:

- Reject empty values
- Trim unnecessary whitespace
- Enforce a reasonable maximum length
- Permit valid Indian/local-language names
- Avoid overly restrictive character rules

Do not restrict names to ASCII characters only.

---

# 20. Phone Validation

Phone numbers should be normalized where appropriate.

The system should support Indian phone numbers.

Example:

```text
+91XXXXXXXXXX
```

The exact validation rule must accommodate the organization's expected participant base.

---

# 21. Email Validation

Email addresses should be validated using appropriate standard email validation.

The system should not rely only on a simple browser input type.

---

# 22. Duplicate Registration

The system should define whether duplicate registrations are allowed.

Recommended approach:

```text
Same Activity
+
Same Email/Phone
+
Active Registration
=
Potential Duplicate
```

The user should receive a clear message if duplicate registration is blocked.

The exact duplicate-detection policy must be approved.

---

# 23. Registration Identifier

Every registration should receive a unique registration ID.

Example:

```text
RY-2026-000123
```

The format is illustrative.

The identifier must be unique and must not expose sensitive information.

---

# 24. Registration Record

A registration record should contain at least:

```text
Registration ID
Activity ID
Participant Name
Phone
Email
Status
Registration Date
Registration Language
Notification Status
```

Additional fields depend on the final registration form.

---

# 25. Registration Database

The recommended registration table may contain:

```text
registrations
```

Potential fields:

| Field | Purpose |
|---|---|
| registration_id | Primary key |
| registration_uuid | Public-safe unique identifier |
| activity_id | Related activity |
| participant_name | Participant name |
| phone | Participant phone |
| email | Participant email |
| status | Registration status |
| language | Registration language |
| created_at | Submission time |
| updated_at | Last update |
| confirmed_at | Confirmation time |
| cancelled_at | Cancellation time |

Additional fields may be added as requirements evolve.

---

# 26. Activity Relationship

A registration belongs to an Activity.

Conceptually:

```text
Activity
   |
   +---- Registration
   +---- Registration
   +---- Registration
```

Deleting or unpublishing an Activity must not silently delete historical registration records.

---

# 27. Registration History

Registration records should remain auditable.

Recommended:

```text
Created
Updated
Confirmed
Cancelled
Waitlisted
Rejected
```

Important status changes should be logged.

---

# 28. Audit Trail

Administrative actions may be recorded.

Example:

```text
Admin
 |
 +-- Changed registration status
 +-- Cancelled registration
 +-- Exported registrations
 +-- Edited participant record
```

The project audit logging approach should be consistent with the overall security architecture.

---

# 29. Admin Registration Dashboard

WordPress administrators should be able to view registrations.

Example:

```text
Registrations

Activity: Yoga for Beginners

-----------------------------------------
ID       Name       Status      Date
-----------------------------------------
000123   Person A   Confirmed   01 Sep
000124   Person B   Confirmed   01 Sep
000125   Person C   Waitlist   01 Sep
-----------------------------------------
```

---

# 30. Registration Filters

The admin should be able to filter by:

- Activity
- Event
- Status
- Date
- Language
- Participant
- Email
- Phone

The exact filter set depends on implementation scope.

---

# 31. Registration Search

Administrators should be able to search registrations by:

```text
Registration ID
Name
Email
Phone
```

Search must not expose registration information to public visitors.

---

# 32. Registration Detail

An administrator should be able to open an individual registration.

Example:

```text
Registration:
RY-2026-000123

Activity:
Yoga for Beginners

Participant:
Example Name

Phone:
+91 XXXXX XXXXX

Email:
example@example.com

Status:
Confirmed

Registered:
01 September 2026
```

---

# 33. Admin Editing

Authorized administrators may update appropriate participant information.

Changes should be logged where audit logging is enabled.

Administrators must not be allowed to modify protected identifiers arbitrarily.

---

# 34. Registration Cancellation

An administrator should be able to cancel a registration.

Conceptual flow:

```text
Confirmed
   |
   v
Cancel
   |
   v
Cancelled
   |
   v
Capacity Released
```

If waitlisting is enabled, the system may promote the next participant.

---

# 35. Participant Cancellation

If self-cancellation is required, the implementation must provide a secure cancellation mechanism.

Possible approach:

```text
Confirmation Email
        |
        v
Cancellation Link
        |
        v
Secure Token
        |
        v
Cancel Registration
```

The exact implementation requires approval.

---

# 36. Confirmation

After successful registration, the visitor should see a confirmation page.

Example:

```text
Registration Successful

Registration ID:
RY-2026-000123

Activity:
Yoga for Beginners

Date:
15 September 2026

Thank you for registering.
```

---

# 37. Email Confirmation

If email is available, a confirmation email may be sent.

Example:

```text
Registration Confirmed

Dear Participant,

Your registration for [Activity] has been received.

Registration ID:
[ID]

Date:
[Date]

Venue:
[Venue]
```

The final email content must be approved.

---

# 38. Email Failure

If email delivery fails, the registration itself should not necessarily fail.

Recommended:

```text
Registration Created
        |
        +---- Email Success
        |
        +---- Email Failed
```

Email delivery status should be recorded for troubleshooting.

---

# 39. Email Delivery Status

Potential statuses:

```text
Not Sent
Queued
Sent
Failed
```

The exact status model depends on the mail system.

---

# 40. WATI Integration

Where WATI is configured, the registration module should provide an integration point.

```text
Registration
      |
      v
WATI Integration
      |
      v
WhatsApp Template
```

WATI integration details are documented separately in `wati.md`.

---

# 41. Registration Language

The registration language should be stored.

Example:

```text
language = en
```

or:

```text
language = kn
```

This can be used for:

- Confirmation
- Email
- WATI
- Reporting

where appropriate.

---

# 42. Multilingual Form

English:

```text
Full Name
Mobile Number
Email
Register
```

Kannada:

```text
[Approved Kannada labels]
```

The form structure should remain the same while presentation text changes by language.

---

# 43. Consent

If participant consent is required, it should be explicitly collected.

Example:

```text
[ ] I agree to the terms and conditions.
```

The final legal wording must be supplied/approved by Rashtrotthana.

---

# 44. Privacy

Participant information must be treated as protected application data.

The system should:

- Collect only required information
- Restrict administrative access
- Use HTTPS
- Avoid exposing participant records publicly
- Avoid putting personal data in URLs
- Protect exports
- Maintain appropriate backups

---

# 45. Public Registration Data

Participant records must never be included in public APIs unless a specific approved use case exists.

Public Activity API:

```text
Activity Information
```

must not return:

```text
Participant Names
Phone Numbers
Emails
```

---

# 46. REST API

If custom REST endpoints are used, potential endpoints include:

```text
POST /wp-json/ry/v1/registrations
GET  /wp-json/ry/v1/activities/{id}/registration-status
```

Administrative endpoints should require authentication.

---

# 47. Public Registration Endpoint

A public registration endpoint must implement:

- Input validation
- Rate limiting where possible
- Spam protection
- Nonce or equivalent request protection
- Duplicate handling
- Capacity validation
- Sanitization
- Database transaction handling

---

# 48. Spam Protection

Registration forms should have protection against automated abuse.

Potential mechanisms:

- Honeypot
- CAPTCHA
- Rate limiting
- Request throttling

The final mechanism should balance security and user experience.

---

# 49. CSRF Protection

Authenticated administrative actions must use WordPress-supported nonce/security mechanisms.

Registration endpoints must also protect against unauthorized request submission where applicable.

---

# 50. Sanitization

All submitted values must be sanitized before storage.

Validation and sanitization are separate steps:

```text
Input
 |
 v
Sanitize
 |
 v
Validate
 |
 v
Store
```

---

# 51. Output Escaping

Participant information must be escaped before being rendered in HTML.

This helps prevent stored XSS vulnerabilities.

---

# 52. Database Security

Database queries must use WordPress database APIs or appropriately prepared queries.

Do not construct SQL queries using unsanitized user input.

---

# 53. Authentication

Only authorized WordPress administrators should access registration records.

Role permissions should control:

- View registrations
- Edit registrations
- Cancel registrations
- Export registrations
- Manage registration settings

---

# 54. Role-Based Access

Example:

```text
Administrator
    |
    +-- Full Access

Content Manager
    |
    +-- Content Access

Registration Manager
    |
    +-- Registration Access
```

The exact roles should be finalized with the Rashtrotthana IT team.

---

# 55. Export

Authorized administrators should be able to export registrations.

Possible format:

```text
CSV
```

Potential columns:

```text
Registration ID
Activity
Name
Phone
Email
Status
Registration Date
Language
```

---

# 56. Export Security

Exports contain participant information.

Therefore:

- Only authorized users may export
- Export actions should be logged where possible
- Files should not be publicly accessible
- Temporary files should be handled securely
- Administrators should delete exports when no longer needed

---

# 57. Report

The registration module should support basic reporting.

Example:

```text
Activity:
Yoga for Beginners

Capacity:
50

Confirmed:
42

Waitlisted:
5

Cancelled:
3
```

---

# 58. Activity-Level Statistics

Possible statistics:

- Total registrations
- Confirmed registrations
- Waitlisted registrations
- Cancelled registrations
- Available capacity
- Registration conversion where measurable

---

# 59. Date-Based Reporting

Administrators may need to filter registrations by:

```text
Today
This Week
This Month
Custom Date Range
```

---

# 60. Registration Confirmation Number

The public-facing registration ID should be safe to share with participants.

Do not expose internal database IDs if they are sequential and sensitive to enumeration.

Use a UUID or secure public identifier where appropriate.

---

# 61. Registration Security Token

If secure links are provided for cancellation or status lookup, use sufficiently unpredictable tokens.

Do not use:

```text
?id=123
```

as the sole authorization mechanism.

---

# 62. Registration Lookup

A public registration lookup feature is not required by default.

If later required, it must use:

- Secure identifier
- Authentication/verification
- Rate limiting
- Minimal data exposure

---

# 63. Notification Architecture

```text
                 Registration
                      |
             +--------+--------+
             |                 |
             v                 v
          Email              WATI
             |                 |
             v                 v
       Participant        Participant
```

Administrative notifications may also be triggered.

---

# 64. Administrator Notifications

Administrators may receive notifications when:

- New registration arrives
- Activity reaches capacity
- Registration is cancelled
- Waitlist promotion occurs
- Registration system encounters a significant failure

The exact notification matrix must be approved.

---

# 65. Capacity Notification

Optional threshold:

```text
Capacity:
50

Confirmed:
45

Threshold:
45
```

The system may notify administrators that the activity is nearing capacity.

---

# 66. Registration Closure

When capacity is reached:

```text
Activity Full
```

The website should show:

```text
Registration Full
```

or:

```text
Join Waitlist
```

depending on configuration.

---

# 67. Manual Override

Authorized administrators may need to manually confirm a participant even if normal online registration is closed.

If implemented, such actions should be clearly identified as administrative overrides and logged.

---

# 68. Registration Deadlines

The system must use the configured WordPress/site timezone consistently.

Do not compare dates using inconsistent server/browser time zones.

---

# 69. Time Zone

The WordPress site timezone must be correctly configured before production.

All stored timestamps should use a consistent strategy and be converted appropriately for display.

---

# 70. Data Retention

The project should define how long registration records are retained.

Possible policy:

```text
Active registration data
Historical registration data
Archived data
Deletion/anonymization
```

The exact retention period must be provided by Rashtrotthana based on organizational and legal requirements.

---

# 71. Data Deletion

If participant data must be deleted, the process should distinguish:

```text
Delete Personal Data
```

from:

```text
Delete Historical Registration Record
```

The final policy must be approved before implementation.

---

# 72. Backup

Registration data must be included in secure backups.

Backups should be protected with the same level of care as the production database.

---

# 73. Restore Testing

Backups should periodically be tested to confirm that registration data can be restored correctly.

---

# 74. Performance

The registration system should remain responsive under expected traffic.

Potential performance considerations:

- Indexed registration queries
- Efficient activity capacity checks
- Pagination in admin tables
- Avoiding loading all registrations at once
- Background notification processing where appropriate

---

# 75. Database Indexes

Likely useful indexes include:

```text
activity_id
status
email
phone
created_at
registration_uuid
```

Indexes should be finalized based on the actual database implementation and query patterns.

---

# 76. Concurrency

Capacity-sensitive operations should be transaction-safe.

Example:

```text
Check Capacity
      |
      v
Reserve/Confirm
      |
      v
Commit
```

The implementation must avoid a situation where concurrent requests exceed capacity.

---

# 77. Transaction Failure

If registration creation fails:

```text
No Partial Registration
```

The user should receive a clear error message and be able to retry.

---

# 78. User Experience

The registration flow should be simple.

Recommended:

```text
Activity
   |
   v
Register
   |
   v
Form
   |
   v
Review/Submit
   |
   v
Confirmation
```

Avoid unnecessary steps.

---

# 79. Form Accessibility

Registration forms must provide:

- Proper labels
- Required indicators
- Keyboard navigation
- Error messages
- Focus management
- Accessible buttons
- Screen-reader compatible controls

---

# 80. Error Handling

User-facing errors should be understandable.

Example:

```text
Registration could not be completed.
Please try again.
```

Do not expose:

```text
SQL error
Database exception
Stack trace
```

to users.

---

# 81. Logging

Technical errors should be logged securely for administrators/developers.

Logs must not unnecessarily contain:

- Passwords
- API keys
- Authentication tokens
- Sensitive participant information

---

# 82. Email Templates

Email templates should support:

- English
- Kannada

where required.

Templates should be centrally manageable rather than hardcoded throughout the codebase.

---

# 83. WATI Templates

WATI templates should be maintained in WATI and referenced by the integration.

The website should not attempt to create or bypass WhatsApp template approval processes.

---

# 84. Registration Status API

A frontend may need a lightweight availability endpoint.

Example:

```text
GET /wp-json/ry/v1/activities/25/registration-status
```

Example response:

```json
{
  "registration_enabled": true,
  "status": "open",
  "capacity": 50,
  "confirmed": 42,
  "available": 8
}
```

The exact response should be finalized during development.

---

# 85. API Response Security

Public APIs must return only the minimum information needed.

Do not return internal registration IDs, participant details or administrative metadata.

---

# 86. WordPress Implementation

The registration system should preferably be implemented as a custom WordPress plugin rather than placing substantial business logic inside the theme.

Recommended:

```text
wp-content/
 |
 +-- plugins/
      |
      +-- rashtrotthana-core/
```

Registration logic belongs in the core/custom plugin.

---

# 87. Theme Responsibility

The theme should primarily handle:

- Display
- Templates
- Styling
- Frontend components

The plugin should handle:

- Registration logic
- Data storage
- Validation
- Notifications
- APIs
- Admin functionality

---

# 88. Plugin Architecture

Conceptually:

```text
rashtrotthana-core
 |
 +-- registration/
 |     +-- post-types.php
 |     +-- database.php
 |     +-- validation.php
 |     +-- service.php
 |     +-- notifications.php
 |     +-- api.php
 |     +-- admin.php
 |
 +-- activities/
 +-- centers/
 +-- events/
 +-- media/
 +-- security/
```

The exact folder structure may evolve.

---

# 89. WordPress Hooks

The module should use WordPress actions and filters where appropriate.

Examples:

```php
do_action( 'ry_registration_created', $registration_id );
```

This allows integrations such as WATI and email notifications to remain decoupled.

---

# 90. Integration Event

Example:

```text
Registration Created
       |
       +---- Email Handler
       |
       +---- WATI Handler
       |
       +---- Audit Handler
```

This is preferable to hardcoding every integration into one registration function.

---

# 91. Testing

The registration module must be tested for:

- Successful registration
- Invalid form data
- Missing required fields
- Duplicate registration
- Capacity reached
- Waitlist
- Cancellation
- Confirmation
- Email failure
- WATI failure
- Concurrent registrations
- Admin editing
- Export
- Multilingual forms
- Mobile usability
- Accessibility
- Security

---

# 92. Acceptance Criteria

The module is complete when:

- Visitors can register for enabled activities.
- Required fields are validated.
- Backend validation is implemented.
- Capacity limits are enforced.
- Duplicate handling follows the approved policy.
- Registrations receive unique identifiers.
- Administrators can view registrations.
- Administrators can filter/search registrations.
- Authorized users can export registrations.
- Registration statuses are manageable.
- Confirmation is displayed.
- Email notifications work where configured.
- WATI integration hooks work where configured.
- English and Kannada registration flows work.
- Participant information is protected.
- Concurrent registration cannot exceed capacity.
- Errors are handled gracefully.
- Registration data is backed up.
- The implementation passes security and functional testing.

---

# 93. Final Registration Architecture

```text
                         VISITOR
                            |
                            v
                       ACTIVITY PAGE
                            |
                            v
                       REGISTER NOW
                            |
                            v
                    REGISTRATION FORM
                            |
                            v
                       VALIDATION
                            |
                            v
                     CAPACITY CHECK
                            |
                 +----------+----------+
                 |                     |
             Available                Full
                 |                     |
                 v                     v
             Register              Waitlist
                 |
                 v
          DATABASE RECORD
                 |
        +--------+--------+
        |                 |
        v                 v
      EMAIL              WATI
        |                 |
        +--------+--------+
                 |
                 v
             CONFIRMATION
```

---

# 94. Development Rules

1. Registration logic must be implemented in a custom WordPress plugin.
2. Do not put core registration business logic exclusively inside the theme.
3. Validate all input on the server.
4. Sanitize input before storage.
5. Escape output before rendering.
6. Protect administrative registration data.
7. Enforce capacity atomically.
8. Prevent registration race conditions.
9. Give each registration a unique public-safe identifier.
10. Store registration language.
11. Support English and Kannada forms.
12. Keep notification integrations decoupled.
13. Provide WATI integration hooks.
14. Provide email notification hooks.
15. Do not expose participant data through public APIs.
16. Restrict registration administration using WordPress capabilities.
17. Protect exports.
18. Log important administrative actions.
19. Do not expose technical errors to visitors.
20. Include registration data in backups.
21. Follow an approved data retention policy.
22. Test registration under concurrent submissions.
23. Test mobile and accessibility behavior.
24. Keep the implementation extensible for future payments or integrations.
25. Document all custom registration functionality.
