# Rashtrotthana Yoga Website
## Security Architecture and Implementation

**Document:** `security.md`  
**Project:** Rashtrotthana Yoga Website  
**Version:** 1.0  
**Status:** Development Specification  
**Platform:** WordPress  

---

# 1. Purpose

This document defines the security requirements for the Rashtrotthana Yoga WordPress website.

The objective is to protect:

- WordPress administration
- Website content
- Participant registration data
- User accounts
- API credentials
- WATI credentials
- Google Maps credentials
- Media
- Custom plugins
- Database
- Integrations
- Infrastructure

Security must be considered throughout development, deployment and maintenance.

---

# 2. Security Objectives

The website must provide:

- Confidentiality
- Integrity
- Availability
- Authentication
- Authorization
- Secure API communication
- Secure administration
- Secure data storage
- Input validation
- Output escaping
- Protection against common web attacks
- Secure backups
- Monitoring and logging
- Controlled access to sensitive information

---

# 3. Security Architecture

```text
                         INTERNET
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
             +--------------+--------------+
             |              |              |
             v              v              v
          Theme          Plugins        REST API
             |              |              |
             +--------------+--------------+
                            |
                            v
                         DATABASE
                            |
                            v
                         BACKUPS
```

---

# 4. HTTPS

Production website traffic must use HTTPS.

HTTP requests should redirect to HTTPS.

Conceptually:

```text
HTTP
 |
 v
301 Redirect
 |
 v
HTTPS
 |
 v
Website
```

---

# 5. TLS Certificate

A valid TLS certificate must be configured for the production domain.

The certificate must:

- Be valid
- Not be expired
- Cover required domains
- Use modern TLS configuration

Certificate renewal should be automated where practical.

---

# 6. WordPress URL

Production WordPress URLs must use HTTPS.

Example:

```text
https://example.com
```

The actual production domain will be configured during deployment.

---

# 7. Secure Administration

The WordPress admin area must be protected.

Example:

```text
/wp-admin/
```

Administrative access should require authentication.

---

# 8. Administrator Accounts

Each administrator should have an individual account.

Do not share:

```text
admin@example.com
password123
```

between multiple people.

Individual accounts provide:

- Accountability
- Auditing
- Easier revocation
- Better security

---

# 9. Strong Passwords

Administrator passwords must be strong and unique.

Passwords must not be:

- Shared
- Stored in Git
- Written in documentation
- Sent through insecure channels

---

# 10. Multi-Factor Authentication

MFA should be enabled for privileged WordPress accounts where supported.

Recommended:

```text
Password
   +
Second Factor
   |
   v
Admin Access
```

---

# 11. Role-Based Access Control

WordPress capabilities must be used to restrict access.

Example:

```text
Administrator
    |
    +-- Full Management

Content Manager
    |
    +-- Website Content

Registration Manager
    |
    +-- Registrations

Editor
    |
    +-- Content Editing
```

Exact roles must be finalized with Rashtrotthana.

---

# 12. Principle of Least Privilege

Users should receive only the permissions required for their responsibilities.

Do not give administrator privileges to users who only need content editing.

---

# 13. Account Removal

When an administrator leaves the organization:

```text
Employee Leaves
       |
       v
Disable Account
       |
       v
Revoke Access
```

Accounts should not remain active unnecessarily.

---

# 14. Password Reset

Password resets must use WordPress's secure reset mechanisms.

Do not implement custom insecure password reset flows.

---

# 15. Login Protection

The WordPress login endpoint should be protected against brute-force attacks.

Possible measures:

- Rate limiting
- Login attempt throttling
- MFA
- Security plugin controls
- IP restrictions where appropriate

---

# 16. Brute Force Protection

Repeated failed logins should trigger appropriate protection.

Conceptually:

```text
Failed Login
     |
     v
Repeated Attempts
     |
     v
Rate Limit / Temporary Block
```

---

# 17. Public Registration Security

Public registration forms are exposed to automated attacks.

They must implement:

- Input validation
- Sanitization
- Spam protection
- Rate limiting where appropriate
- Nonce/request protection
- Capacity validation
- Duplicate handling

---

# 18. Input Validation

All external input must be validated.

Sources include:

- Forms
- REST APIs
- URL parameters
- POST requests
- Query parameters
- Webhooks
- Admin forms

---

# 19. Sanitization

Input should be sanitized before storage.

Conceptually:

```text
User Input
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

# 20. Output Escaping

Data retrieved from the database must be escaped appropriately before rendering.

This is particularly important for:

- User-submitted content
- Participant information
- Custom fields
- Search results
- Admin data

---

# 21. Cross-Site Scripting

The application must protect against XSS.

Do not render untrusted input directly into HTML.

Example unsafe pattern:

```php
echo $_POST['name'];
```

Use appropriate WordPress escaping functions instead.

---

# 22. SQL Injection

Database queries must use WordPress database APIs and prepared statements where raw queries are necessary.

Never concatenate untrusted user input directly into SQL.

Unsafe:

```php
$sql = "SELECT * FROM users WHERE id = " . $_GET['id'];
```

Use prepared queries instead.

---

# 23. CSRF

Administrative actions must be protected against Cross-Site Request Forgery.

WordPress nonces should be used for appropriate actions.

Examples:

- Delete content
- Update settings
- Change registration status
- Export data
- Modify users

---

# 24. WordPress Nonces

Custom plugin actions should use WordPress nonce mechanisms.

Conceptually:

```text
Admin Request
     |
     v
Nonce Validation
     |
   +---+---+
   |       |
 Valid   Invalid
   |       |
   v       v
Action   Reject
```

---

# 25. Authorization

Authentication only establishes identity.

Authorization determines whether the user is allowed to perform an action.

Example:

```text
Logged In
   |
   v
Has Required Capability?
   |
 +---+---+
 |       |
Yes      No
 |       |
 v       v
Allow   Deny
```

---

# 26. Capability Checks

Custom admin functionality should use WordPress capability checks.

Do not rely only on:

```php
is_user_logged_in()
```

for privileged operations.

---

# 27. REST API Security

REST API endpoints must be classified as:

```text
Public
Authenticated
Administrator-only
```

Only the minimum required information should be public.

---

# 28. Public API

Public APIs may expose:

- Published Activities
- Published Centers
- Published Events
- Published Resources
- Public settings

They must not expose:

- Passwords
- API tokens
- Participant data
- Internal administrative metadata

---

# 29. Administrative API

Administrative endpoints must require:

- Authentication
- Appropriate capability
- Nonce where applicable
- Input validation

---

# 30. Registration API

Public registration endpoints require additional protection.

Recommended:

```text
POST /wp-json/ry/v1/registrations
```

Must implement:

- Validation
- Sanitization
- Spam protection
- Capacity checking
- Duplicate handling
- Rate limiting
- Safe error responses

---

# 31. Sensitive Data

Sensitive information may include:

- Participant phone numbers
- Email addresses
- Addresses
- Emergency contact information
- Registration records
- API credentials

Such data must not be exposed publicly.

---

# 32. Data Minimization

Only collect information necessary for the approved business process.

Avoid collecting unnecessary participant data.

---

# 33. Registration Privacy

Registration information should be visible only to authorized personnel.

Public visitors must never be able to enumerate registrations.

---

# 34. Enumeration Protection

Do not expose sequential database IDs as authorization mechanisms.

Avoid designs such as:

```text
/registration?id=1
/registration?id=2
/registration?id=3
```

Use secure identifiers for participant-facing operations.

---

# 35. File Upload Security

The media library must restrict allowed file types.

The system should validate:

- File extension
- MIME type
- File size
- Upload permissions

---

# 36. Upload Restrictions

Only authorized users should upload media.

Potential allowed types:

```text
JPG
JPEG
PNG
WebP
SVG where safely configured
PDF
```

The exact list should be finalized according to content requirements.

---

# 37. SVG Security

SVG files can contain active content.

SVG uploads should be allowed only if they are properly sanitized and the organization accepts the associated risk.

---

# 38. File Names

Uploaded file names should not contain executable content or unsafe path characters.

The WordPress media system should be used rather than implementing arbitrary filesystem writes.

---

# 39. Directory Traversal

User input must never be used directly to construct arbitrary filesystem paths.

Prevent:

```text
../
```

style traversal attacks.

---

# 40. Malware Scanning

If infrastructure permits, uploaded files may be scanned for malware.

This is especially useful for:

- PDFs
- Documents
- User-submitted files

---

# 41. Plugin Security

Only trusted plugins should be installed.

Every plugin must be evaluated for:

- Source
- Maintenance
- Compatibility
- Security history
- Required functionality

Avoid unnecessary plugins.

---

# 42. Plugin Updates

Plugins must be kept updated.

Before major production updates:

```text
Backup
 |
 v
Staging Test
 |
 v
Production Update
```

---

# 43. Theme Security

The custom theme must not contain business logic that belongs in plugins.

Avoid unnecessary PHP execution paths.

---

# 44. Custom Plugin Security

Custom plugins must follow WordPress coding and security practices.

All custom code should be reviewed for:

- Authentication
- Authorization
- Input validation
- Output escaping
- SQL injection
- XSS
- CSRF
- File handling
- API security

---

# 45. Dependency Management

Third-party PHP/JavaScript dependencies must be tracked.

Do not use abandoned libraries without justification.

---

# 46. Secrets Management

Secrets must never be committed to Git.

Examples:

```text
WATI_API_TOKEN
GOOGLE_MAPS_API_KEY
SMTP_PASSWORD
DATABASE_PASSWORD
JWT_SECRET
```

---

# 47. Environment Configuration

Sensitive configuration should be supplied through secure server/environment configuration where practical.

Recommended:

```text
Development
Staging
Production
```

must use separate credentials.

---

# 48. Git Security

The repository must not contain:

```text
.env
Database passwords
API tokens
Private keys
Production credentials
```

A suitable `.gitignore` must be configured.

---

# 49. Example `.gitignore`

```text
.env
.env.*
*.log
/wp-config-local.php
/node_modules/
/vendor/
```

The exact ignore rules depend on the project structure.

---

# 50. WordPress Configuration

Sensitive WordPress configuration must be protected.

Important values include:

- Database credentials
- Authentication salts
- API credentials
- Debug configuration

---

# 51. Debug Mode

Production should not expose WordPress debug information to visitors.

Production configuration should ensure:

```text
WP_DEBUG = false
```

unless a controlled troubleshooting process temporarily requires otherwise.

---

# 52. Error Messages

Public errors should be generic.

Do not display:

```text
Database credentials
SQL queries
Filesystem paths
Stack traces
API tokens
```

---

# 53. Logging

Application logs should be used for technical troubleshooting.

Logs must avoid sensitive data.

Never log:

```text
Passwords
API tokens
Authorization headers
Full payment details
```

---

# 54. Audit Logging

Important administrative actions should be logged.

Examples:

- Login
- Content deletion
- Registration status changes
- User changes
- Settings changes
- Exports
- Security changes

---

# 55. Backup Security

Backups contain sensitive data and must be protected.

Backups should not be stored in publicly accessible web directories.

---

# 56. Backup Encryption

Where supported, backups containing participant information should be encrypted.

---

# 57. Backup Access

Only authorized administrators should access production backups.

---

# 58. Restore Testing

Backups must be periodically tested.

A backup is not considered reliable merely because the backup job reports success.

---

# 59. Database Security

The production database should not be directly accessible from the public internet.

Recommended:

```text
Internet
   X
   |
   v
Database
```

Only the application server should access the database where possible.

---

# 60. Database Credentials

Database credentials must:

- Be unique
- Be strong
- Not be committed to Git
- Have only required permissions

---

# 61. Database Permissions

The WordPress database user should have only the permissions required by the application.

Avoid using a root database account for the application.

---

# 62. Server Security

The production Ubuntu server should be hardened.

Recommended measures:

- Security updates
- Firewall
- SSH key authentication
- Restricted SSH access
- Disabled unnecessary services
- Fail2ban or equivalent where appropriate
- Non-root administration
- Regular monitoring

---

# 63. SSH Security

SSH should use secure authentication.

Password-based root SSH access should be avoided.

---

# 64. Firewall

Only required ports should be exposed.

Typical web ports:

```text
80
443
```

SSH access should be restricted appropriately.

Database ports should not be publicly exposed.

---

# 65. Nginx Security

Nginx should:

- Terminate HTTPS
- Redirect HTTP to HTTPS
- Proxy appropriate requests
- Prevent access to sensitive files
- Apply reasonable request limits
- Provide security headers where appropriate

---

# 66. Security Headers

Appropriate security headers should be considered.

Potential headers:

```text
Strict-Transport-Security
Content-Security-Policy
X-Content-Type-Options
Referrer-Policy
Permissions-Policy
```

The exact policy must be tested with WordPress, analytics, Google Maps, AI and other integrations.

---

# 67. Content Security Policy

A CSP can improve security but must be configured carefully.

It must allow only required external services.

Potential sources may include:

- Website domain
- Google Maps
- WATI-related services where applicable
- Analytics
- Fonts
- AI integration

Do not blindly copy a generic CSP.

---

# 68. Rate Limiting

Rate limiting should be considered for:

- Login
- Registration
- Search
- REST API
- Webhooks

---

# 69. Spam Protection

Public forms should have appropriate anti-spam controls.

Potential:

- Honeypot
- CAPTCHA
- Rate limiting
- IP throttling

---

# 70. Webhook Security

WATI webhooks must be authenticated/verified according to WATI's supported mechanism.

Do not trust arbitrary incoming webhook requests.

---

# 71. API Credential Rotation

Credentials should be rotatable.

If a credential is compromised:

```text
Compromise Detected
       |
       v
Revoke Credential
       |
       v
Generate Replacement
       |
       v
Update Server
       |
       v
Test
```

---

# 72. Google Maps Credentials

Google Maps API keys must be appropriately restricted.

They should be limited to required APIs and application/referrer restrictions where applicable.

---

# 73. WATI Credentials

WATI credentials must be stored securely.

They must not appear in:

- Source code
- Git history
- Browser JavaScript
- Public REST responses
- Logs

---

# 74. AI API Credentials

If the AI Knowledge Assistant uses OpenAI or Google Gemini:

```text
Browser
   X
   |
   v
AI API Key
```

The browser must not receive the provider's secret API key.

Recommended:

```text
Browser
   |
   v
WordPress / AI Backend
   |
   v
AI Provider
```

---

# 75. AI Prompt Security

User input sent to the AI system should be treated as untrusted.

The AI integration must not expose:

- System prompts
- API keys
- Internal credentials
- Private database content
- Administrative information

---

# 76. Search Security

Search endpoints must sanitize query parameters.

Search must not expose:

- Draft content
- Private posts
- Participant records
- Administrative content

---

# 77. Media Security

Media URLs that are intended to be public may be publicly accessible.

Private administrative documents must not be uploaded to public media paths unless intentionally designed that way.

---

# 78. Resource Security

If Resources include internal/private documents, they require separate access controls.

Public resources should remain public.

Private resources must require authorization.

---

# 79. Admin URL

Changing the default WordPress login URL alone is not considered a complete security solution.

Primary protections should remain:

- Strong passwords
- MFA
- Rate limiting
- Least privilege
- Updates
- Monitoring

---

# 80. Security Monitoring

The system should monitor:

- Failed login attempts
- Plugin errors
- Server errors
- API failures
- Suspicious requests
- Unexpected admin activity

---

# 81. Vulnerability Management

Security vulnerabilities should be assessed promptly.

If a critical WordPress/plugin vulnerability is announced:

```text
Vulnerability
      |
      v
Assess Impact
      |
      v
Backup
      |
      v
Patch
      |
      v
Test
      |
      v
Deploy
```

---

# 82. Incident Response

A basic incident response procedure should exist.

```text
Detect
  |
  v
Contain
  |
  v
Investigate
  |
  v
Remediate
  |
  v
Recover
  |
  v
Review
```

---

# 83. Credential Compromise

If credentials are exposed:

1. Revoke the credential.
2. Generate a replacement.
3. Update production configuration.
4. Check logs for misuse.
5. Remove exposed secrets from repositories where appropriate.
6. Review related credentials.
7. Document the incident.

---

# 84. Security Testing

Before production launch, test:

- Authentication
- Authorization
- Registration
- REST APIs
- File uploads
- Search
- Forms
- WATI webhook
- Google Maps configuration
- AI integration
- Admin roles
- Rate limiting
- XSS
- SQL injection
- CSRF
- Access control

---

# 85. Dependency Testing

All production dependencies should be checked for known vulnerabilities before launch.

---

# 86. Production Checklist

```text
[ ] HTTPS enabled
[ ] HTTP redirects to HTTPS
[ ] Admin accounts reviewed
[ ] MFA enabled where available
[ ] Least-privilege roles configured
[ ] Strong passwords
[ ] Plugins reviewed
[ ] Plugins updated
[ ] Theme reviewed
[ ] Custom plugin reviewed
[ ] Database protected
[ ] Firewall configured
[ ] SSH secured
[ ] Secrets removed from Git
[ ] Environment configuration secured
[ ] Backups configured
[ ] Backup restore tested
[ ] Security headers configured
[ ] Rate limiting configured
[ ] Spam protection configured
[ ] WATI credentials secured
[ ] Google Maps key restricted
[ ] AI credentials secured
[ ] Error disclosure disabled
[ ] Logging configured
```

---

# 87. Acceptance Criteria

The security implementation is complete when:

- Production uses HTTPS.
- Administrative access is authenticated.
- Privileged users have appropriate capabilities.
- Sensitive data is not exposed publicly.
- Registration data is protected.
- APIs enforce appropriate authorization.
- Public APIs return only approved data.
- Inputs are validated and sanitized.
- Outputs are escaped.
- CSRF protections are implemented where applicable.
- SQL injection protections are implemented.
- File uploads are restricted.
- Secrets are not committed to source control.
- Database access is restricted.
- Server access is hardened.
- Backups are protected.
- Security logs are available.
- WATI credentials are secure.
- Google Maps credentials are appropriately restricted.
- AI credentials remain server-side.
- Security testing is completed before launch.

---

# 88. Development Rules

1. Treat all external input as untrusted.
2. Validate input server-side.
3. Sanitize before storage.
4. Escape before output.
5. Use prepared database queries.
6. Use WordPress nonces for applicable actions.
7. Check capabilities for privileged operations.
8. Never expose secrets to browsers.
9. Never commit secrets to Git.
10. Use HTTPS everywhere in production.
11. Use least-privilege access.
12. Protect registration information.
13. Protect backups.
14. Keep WordPress and plugins updated.
15. Remove unnecessary plugins.
16. Secure file uploads.
17. Secure REST APIs.
18. Secure webhooks.
19. Use rate limiting where appropriate.
20. Monitor important security events.
21. Maintain an incident response process.
22. Test backups.
23. Test security before production.
24. Keep development, staging and production credentials separate.
25. Document security configuration during handover.
