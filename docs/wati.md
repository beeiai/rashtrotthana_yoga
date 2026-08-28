# Rashtrotthana Yoga Website
## WATI / WhatsApp Automation Integration

**Document:** `wati.md`  
**Project:** Rashtrotthana Yoga Website  
**Version:** 1.0  
**Status:** Development Specification  
**Platform:** WordPress  
**External Platform:** WATI  
**Purpose:** WhatsApp automation and participant communication  

---

# 1. Purpose

This document defines the integration between the Rashtrotthana Yoga WordPress website and Rashtrotthana's existing WATI platform.

The objective is to automate WhatsApp communication associated with:

- Activity registrations
- Event registrations
- Registration confirmations
- Event reminders
- Activity notifications
- Administrative notifications
- Other approved participant communications

The website will use WATI's official APIs and the existing Rashtrotthana WATI account.

---

# 2. Scope

The integration includes:

- WATI API configuration
- Secure credential storage
- Registration-triggered WhatsApp messages
- Event reminders where supported
- Activity notifications
- Administrative notifications
- Template-based messaging
- Language-aware messaging
- Delivery status handling where supported
- Error handling
- Logging
- Retry handling where appropriate

The following are outside the core scope unless separately approved:

- Creating a new WhatsApp Business account
- Replacing WATI
- Building a WhatsApp server
- Direct WhatsApp infrastructure
- Unapproved bulk messaging
- Unapproved marketing automation
- WhatsApp payment processing

---

# 3. Existing WATI Account

Rashtrotthana will provide:

- Existing WATI account
- Required API credentials
- API configuration details
- Approved WhatsApp templates
- Sender/number configuration
- Required permissions

The development team should not create a separate production WATI account unless specifically requested.

---

# 4. Ownership

Production WATI resources should remain owned by Rashtrotthana.

Recommended:

```text
Rashtrotthana
      |
      v
WATI Account
      |
      +-- WhatsApp Business Configuration
      |
      +-- Approved Templates
      |
      +-- API Credentials
      |
      v
WordPress Website
```

---

# 5. High-Level Architecture

```text
Visitor
   |
   v
WordPress Website
   |
   v
Registration Module
   |
   v
Registration Created
   |
   v
WATI Integration Layer
   |
   | HTTPS API
   v
WATI
   |
   v
WhatsApp
   |
   v
Participant
```

---

# 6. Integration Principle

The registration system should not directly contain all WATI API logic.

Recommended:

```text
Registration
     |
     v
Event / Hook
     |
     v
WATI Service
     |
     v
WATI API
```

This keeps registration logic independent from the external communication provider.

---

# 7. WordPress Integration

The custom Rashtrotthana plugin should provide a WATI service.

Conceptual structure:

```text
rashtrotthana-core/
 |
 +-- integrations/
       |
       +-- wati/
             +-- client.php
             +-- service.php
             +-- templates.php
             +-- webhook.php
             +-- logger.php
```

The final implementation may use a different structure.

---

# 8. WATI Configuration

The WordPress administration area may provide configuration such as:

```text
WATI Integration
----------------------------

Enabled:
[Yes]

API Endpoint:
[________________]

API Token:
[***************]

Default Language:
[English]

Test Mode:
[Yes/No]
```

Sensitive values must not be displayed unnecessarily.

---

# 9. Credential Storage

WATI credentials must never be hardcoded into source code.

Do not commit:

```text
API Token
API Key
Client Secret
Password
```

to GitHub.

---

# 10. Environment Variables

Where server configuration permits, credentials should preferably be stored as environment variables or secure server configuration.

Conceptual example:

```text
WATI_API_URL
WATI_API_TOKEN
WATI_ENABLED
```

The exact variable names should be finalized during deployment.

---

# 11. Production Credentials

Production credentials must be supplied by Rashtrotthana.

Development credentials should be separate from production credentials where possible.

Recommended:

```text
LOCAL
 |
 +-- Development WATI configuration

STAGING
 |
 +-- Staging configuration

PRODUCTION
 |
 +-- Production WATI configuration
```

---

# 12. API Communication

The website communicates with WATI using HTTPS.

```text
WordPress
     |
     | HTTPS
     v
WATI API
```

Plain HTTP must not be used for production API communication.

---

# 13. API Client

The WATI client should centralize external API communication.

Conceptual responsibilities:

```text
WATI Client
 |
 +-- Authentication
 +-- HTTP Request
 +-- Headers
 +-- Timeout
 +-- Response Parsing
 +-- Error Handling
```

---

# 14. Timeout

External WATI requests must have a reasonable timeout.

The website should not hang indefinitely waiting for WATI.

If WATI does not respond within the configured timeout:

```text
WATI Timeout
     |
     v
Log Error
     |
     v
Continue Registration
```

Registration should not necessarily fail merely because WhatsApp notification failed.

---

# 15. Registration Integration

Recommended flow:

```text
Registration Created
        |
        v
Trigger WATI Notification
        |
        v
Build Template Payload
        |
        v
Call WATI API
        |
        v
Record Result
```

---

# 16. Registration Confirmation

When a registration is successfully created:

```text
Registration
      |
      v
Confirmed
      |
      v
WATI
      |
      v
Confirmation Template
```

The exact trigger depends on the registration status.

---

# 17. Confirmation Template

WATI should use an approved WhatsApp template.

Conceptual:

```text
Registration Confirmation

Hello {{name}},

Your registration for {{activity}} is confirmed.

Date: {{date}}
Time: {{time}}
Venue: {{venue}}

Registration ID: {{registration_id}}
```

The actual template must be created and approved in WATI/WhatsApp.

---

# 18. Template Variables

The website should supply only approved template variables.

Possible variables:

```text
name
activity
date
time
venue
registration_id
center
```

The final variables depend on the approved template.

---

# 19. Template Mapping

The website should maintain a logical mapping.

Example:

```text
registration_confirmation
        |
        +---- English Template
        |
        +---- Kannada Template
```

Avoid scattering template IDs throughout application code.

---

# 20. Language Selection

The registration's language should determine the notification language where approved templates exist.

Example:

```text
Registration Language:
en

       |
       v

English WATI Template
```

```text
Registration Language:
kn

       |
       v

Kannada WATI Template
```

---

# 21. Template Fallback

If a Kannada template does not exist:

```text
Kannada Registration
        |
        v
Kannada Template Available?
        |
      No
        |
        v
Approved Fallback
```

The fallback policy must be approved by Rashtrotthana.

The system must not automatically send arbitrary untranslated content.

---

# 22. Phone Number

WATI requires a valid participant phone number.

The registration system should:

- Validate phone number
- Normalize where appropriate
- Store securely
- Pass the correct format to WATI

The final phone format should follow WATI's API requirements.

---

# 23. International Format

Where required, phone numbers should be normalized to an international format.

Example:

```text
+91XXXXXXXXXX
```

The exact normalization rules must be implemented according to the accepted WATI format.

---

# 24. Opt-In / Consent

WhatsApp communication must follow applicable WhatsApp/WATI requirements and Rashtrotthana's approved consent policy.

Where required, the registration form should clearly communicate that WhatsApp messages may be sent.

Example:

```text
[ ] I agree to receive activity-related WhatsApp notifications.
```

The final wording must be approved.

---

# 25. Transactional vs Marketing Messages

The website should distinguish between:

```text
Transactional
```

and:

```text
Marketing
```

Examples of transactional:

- Registration confirmation
- Event reminder
- Activity update
- Cancellation notification

Marketing/broadcast messaging requires separate approval and policy handling.

---

# 26. Event Reminder

An approved reminder may be sent before an event.

Conceptual:

```text
Event
 |
 |-- 24 hours before
 |
 v
WATI
 |
 v
Reminder
```

The exact reminder timing must be defined by Rashtrotthana.

---

# 27. Reminder Content

Example:

```text
Reminder

Hello {{name}},

This is a reminder for {{activity}}.

Date: {{date}}
Time: {{time}}
Venue: {{venue}}

We look forward to seeing you.
```

Actual wording must be approved.

---

# 28. Cancellation Notification

If a registration is cancelled:

```text
Registration Cancelled
        |
        v
WATI
        |
        v
Cancellation Template
```

This should only be enabled if an approved template exists.

---

# 29. Event Change Notification

If an event changes:

```text
Event Updated
      |
      v
Identify affected registrations
      |
      v
WATI Notification
```

This should be implemented only after requirements and messaging rules are approved.

---

# 30. Administrative Notifications

WATI may optionally notify administrators about:

- New registration
- Activity capacity reached
- Cancellation
- System errors

The exact administrative notification workflow must be approved.

---

# 31. Notification Queue

For reliable delivery, notifications may be queued.

Recommended architecture:

```text
Registration
     |
     v
Notification Job
     |
     v
Queue
     |
     v
WATI API
```

This prevents external API latency from blocking the visitor unnecessarily.

---

# 32. Synchronous vs Asynchronous

Simple MVP implementation may use:

```text
Registration
     |
     v
WATI API
```

For higher reliability/scale:

```text
Registration
     |
     v
Queue
     |
     v
Background Worker
     |
     v
WATI
```

The final approach depends on expected traffic.

---

# 33. Retry Policy

Transient WATI failures may be retried.

Example:

```text
Attempt 1
   |
   v
Failed
   |
   v
Wait
   |
   v
Attempt 2
   |
   v
Failed
   |
   v
Attempt 3
```

Retries must not create duplicate participant messages where the API request may already have succeeded.

---

# 34. Idempotency

Notification requests should be designed to avoid accidental duplicate messages.

A local notification record may store:

```text
registration_id
notification_type
language
provider_message_id
status
created_at
```

Before retrying, the system should determine whether the previous request may already have succeeded.

---

# 35. Notification Log

Recommended table:

```text
notification_logs
```

Potential fields:

| Field | Purpose |
|---|---|
| id | Primary key |
| registration_id | Related registration |
| notification_type | Confirmation/reminder/etc. |
| language | en/kn |
| phone | Recipient |
| status | queued/sent/failed |
| provider_message_id | WATI message ID |
| error_message | Failure information |
| created_at | Creation time |
| sent_at | Send time |

Sensitive values should be minimized.

---

# 36. Delivery Status

If WATI provides delivery status information, the system may record:

```text
Queued
Sent
Delivered
Read
Failed
```

The exact statuses depend on WATI's available API/webhook capabilities.

---

# 37. Webhooks

If WATI supports relevant webhooks, the website may expose a secure webhook endpoint.

Conceptual:

```text
WATI
  |
  | Webhook
  v
WordPress
  |
  v
Notification Status
```

---

# 38. Webhook Security

Webhook endpoints must verify that incoming requests are legitimate according to WATI's supported verification mechanism.

Do not blindly trust arbitrary POST requests.

---

# 39. Webhook Endpoint

A conceptual endpoint may be:

```text
POST /wp-json/ry/v1/wati/webhook
```

The exact endpoint is implementation-specific.

---

# 40. Webhook Data

The system should process only the fields required for delivery/status tracking.

Do not store unnecessary webhook payloads containing participant information.

---

# 41. WATI Failure

If WATI is unavailable:

```text
Registration
     |
     v
Database
     |
     v
WATI Failure
     |
     v
Log Failure
     |
     v
Retry / Admin Alert
```

The website should remain operational.

---

# 42. Registration Independence

The recommended rule is:

```text
Registration Success
        !=
WATI Success
```

A successful participant registration should not be rolled back solely because a WhatsApp notification failed, unless the business explicitly requires transactional notification success.

---

# 43. Admin Dashboard

The WordPress admin may show:

```text
WATI Status

Enabled: Yes

Last API Request:
[Date]

Notifications:
Sent: 125
Failed: 3
Pending: 2
```

This is optional and depends on implementation scope.

---

# 44. Test Mode

A test mode should be available during development where practical.

Example:

```text
WATI Test Mode:
Enabled
```

The system should prevent accidental production messaging during development.

---

# 45. Development Safety

Developers must not test using arbitrary real participant numbers without authorization.

Use designated test numbers supplied by Rashtrotthana.

---

# 46. Template Management

Templates should be created/managed in WATI rather than stored as arbitrary message text inside WordPress.

WordPress should reference approved templates.

---

# 47. Template IDs

Template IDs/names should be stored in configuration.

Example:

```text
registration_confirmation_en
registration_confirmation_kn
event_reminder_en
event_reminder_kn
```

The exact identifiers depend on WATI.

---

# 48. Template Versioning

If a WATI template changes significantly:

```text
Old Template
     |
     v
New Approved Template
     |
     v
Update WordPress Mapping
```

Template changes should be tested before production use.

---

# 49. Message Personalization

Only approved variables should be personalized.

Potential:

```text
{{name}}
{{activity}}
{{date}}
{{time}}
{{venue}}
```

Never inject arbitrary HTML or untrusted template code.

---

# 50. Character and Formatting Rules

WhatsApp message content should follow approved template formatting.

The website should not attempt to modify approved templates in a way that violates WATI/WhatsApp template requirements.

---

# 51. URL Links

If templates contain links, they should point to approved Rashtrotthana website URLs.

Example:

```text
View Activity
```

Links should use HTTPS.

---

# 52. Registration Link

Where required, the message may contain a registration/activity link.

Example:

```text
View Activity:
https://example.com/activities/...
```

The final production domain must be configured before launch.

---

# 53. Privacy

The WATI integration transfers participant information to WATI.

The organization should ensure:

- Appropriate privacy notice
- Approved data processing arrangement
- Appropriate consent where required
- Secure credentials
- Minimal data transfer

---

# 54. Data Minimization

Only send information required for the message.

Example:

```text
Name
Activity
Date
Time
Venue
Registration ID
```

Do not send unnecessary participant data.

---

# 55. Secrets

Never log:

```text
WATI API Token
Authorization Header
Secrets
```

Do not include credentials in:

```text
Git
Screenshots
Documentation
Error Messages
```

---

# 56. Logging

Logs should contain useful diagnostic information without exposing secrets.

Example:

```text
Notification:
registration_confirmation

Registration:
RY-2026-000123

Status:
Failed

Provider:
WATI

Error:
HTTP 500
```

Do not log full authorization headers.

---

# 57. API Rate Limits

The implementation must respect WATI API rate limits.

Where rate limits are encountered:

```text
429 / Rate Limited
        |
        v
Retry According to Policy
```

Do not repeatedly hammer the API.

---

# 58. API Versioning

The integration should isolate WATI-specific API details so that future API changes are easier to accommodate.

Recommended:

```text
Application
    |
    v
WATI Service Interface
    |
    v
WATI API Client
```

---

# 59. Service Abstraction

Conceptually:

```php
interface WhatsAppProviderInterface
{
    public function sendTemplate(
        string $phone,
        string $template,
        array $parameters
    );
}
```

The exact implementation may differ.

This makes future provider replacement easier.

---

# 60. WATI Service

The WATI service should handle:

- Template selection
- Language selection
- Payload preparation
- API invocation
- Response processing
- Error handling
- Logging

---

# 61. Registration Hook

The registration module may trigger:

```php
do_action(
    'ry_registration_confirmed',
    $registration_id
);
```

The WATI integration listens for this event.

---

# 62. Loose Coupling

Preferred:

```text
Registration Module
        |
        v
WordPress Hook
        |
        +---- Email Integration
        |
        +---- WATI Integration
        |
        +---- Audit Logging
```

Avoid:

```text
Registration Module
        |
        +---- WATI code everywhere
```

---

# 63. Multilingual Integration

WATI messaging should respect the registration language.

```text
Registration
 |
 +-- language=en -> English Template
 |
 +-- language=kn -> Kannada Template
```

---

# 64. Missing Kannada Template

If Kannada is selected but an approved Kannada template is unavailable:

```text
Kannada
   |
   v
Template Missing
   |
   v
Approved fallback
```

Do not automatically translate and send unapproved content.

---

# 65. Testing

WATI integration must be tested for:

- Valid credentials
- Invalid credentials
- API unavailable
- Timeout
- Rate limit
- Successful message
- Failed message
- Duplicate prevention
- English template
- Kannada template
- Registration confirmation
- Reminder
- Cancellation
- Webhook
- Delivery status
- Logging
- Retry

---

# 66. Acceptance Criteria

The WATI integration is complete when:

- Rashtrotthana WATI credentials can be configured securely.
- Production secrets are not stored in Git.
- Registration can trigger approved WhatsApp templates.
- English and Kannada templates can be selected where available.
- Phone numbers are validated/normalized appropriately.
- WATI failures do not unnecessarily break registration.
- Notification failures are logged.
- Retry behavior is safe.
- Duplicate messages are minimized.
- Webhooks are secured if implemented.
- Delivery statuses are recorded where supported.
- Administrators can diagnose notification failures.
- Test mode prevents accidental production messages.
- The integration uses official WATI APIs.
- Documentation explains required WATI configuration.

---

# 67. Deployment Requirements

Rashtrotthana must provide:

```text
WATI Account
API Credentials
API Endpoint/Configuration
WhatsApp Business Configuration
Approved Templates
Test Phone Numbers
Production Phone Number
```

The exact information depends on the WATI account configuration.

---

# 68. Handover

The final handover should include:

- WATI configuration guide
- Required environment variables
- Template mapping
- API integration documentation
- Webhook configuration if applicable
- Troubleshooting guide
- Testing procedure

---

# 69. Troubleshooting

## Message not sent

Check:

```text
WATI enabled?
Credentials valid?
Phone number valid?
Template approved?
Correct language?
API reachable?
Rate limit?
```

## Message failed

Check:

```text
Notification log
HTTP status
WATI response
Template status
Phone number
```

## Duplicate message

Check:

```text
Notification ID
Registration ID
Retry logic
Provider message ID
Queue state
```

---

# 70. Final Architecture

```text
                         WORDPRESS
                             |
                       Registration
                             |
                             v
                    Registration Event
                             |
                             v
                       WATI Service
                             |
                             v
                        WATI API
                             |
                             v
                      WhatsApp Platform
                             |
                             v
                        Participant
```

---

# 71. Development Rules

1. Use the existing Rashtrotthana WATI account.
2. Rashtrotthana owns production WATI resources.
3. Use official WATI APIs.
4. Use HTTPS.
5. Never hardcode credentials.
6. Prefer environment variables for secrets.
7. Separate development/staging/production configuration.
8. Use approved WhatsApp templates.
9. Do not bypass WhatsApp template approval.
10. Store registration language.
11. Support English and Kannada templates where approved.
12. Do not send arbitrary machine-translated content.
13. Minimize participant data sent to WATI.
14. Do not log API credentials.
15. Do not expose WATI credentials in admin UI unnecessarily.
16. Handle API timeouts gracefully.
17. Handle rate limits.
18. Implement safe retry behavior.
19. Prevent duplicate notifications where possible.
20. Keep WATI logic separate from registration business logic.
21. Secure webhook endpoints.
22. Log failures without sensitive information.
23. Provide test mode.
24. Test using authorized numbers only.
25. Document all production configuration requirements.
