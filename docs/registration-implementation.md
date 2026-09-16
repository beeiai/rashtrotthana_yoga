# Registration Implementation Notes

**Document:** `registration-implementation.md`
**Project:** Rashtrotthana Yoga Website

This document explains the technical implementation details of the Registration plugin.

## 1. Plugin Architecture
The plugin follows a modular structure separated into `Database`, `Forms`, `Submissions`, `Validation`, `Api`, `Admin`, and `Integrations`.
The main orchestrator (`class-plugin.php`) wires these components together upon initialization and handles activation (schema updates and capability grants).

## 2. Database Structures
We utilize 4 custom tables to efficiently store registration data without polluting the postmeta tables:
- `wp_ry_forms`
- `wp_ry_form_fields`
- `wp_ry_registrations`
- `wp_ry_registration_answers`

## 3. Registration Lifecycle
1. Visitor submits via `POST /wp-json/ry/v1/forms/{id}/submit`.
2. System checks Event/Activity metadata for `_ry_requires_registration`, capacity limits (`_ry_maximum_participants`), and date windows (`_ry_registration_start`).
3. Form answers are validated strictly via `class-validator.php`.
4. A transaction is opened (`START TRANSACTION`).
5. A row-level lock (`FOR UPDATE`) is briefly acquired on the Activity/Event to check capacity safely, preventing race conditions.
6. The registration is inserted with `status = 'confirmed'` (or `waitlisted` if capacity is reached).
7. Domain events (`rashtrotthana_registration_created`, `rashtrotthana_registration_confirmed`) are fired for WATI consumption.

## 4. REST Endpoints
**Public:**
- `GET /wp-json/ry/v1/forms/{id}` - Retrieves form definition.
- `POST /wp-json/ry/v1/forms/{id}/submit` - Submit form.

**Admin (Requires `manage_ry_registrations`):**
- `GET /wp-json/ry/v1/admin/registrations` - Retrieves paginated list.
- `POST /wp-json/ry/v1/admin/registrations/{id}/status` - Updates a status.

## 5. Admin Functionality
A custom `WP_List_Table` is registered under the "Registrations" admin menu.
Administrators can view registration details, answers, and change statuses directly from the WP Admin dashboard.

## 6. Capabilities
The plugin creates a new capability: `manage_ry_registrations`. It is automatically granted to Administrators and a new `Registration Manager` role upon plugin activation.

## 7. WATI & AI Integration Points
The registration plugin **does not** implement WATI HTTP endpoints or AI functionality.
It acts as a producer by emitting the following action hooks:
- `rashtrotthana_registration_created`
- `rashtrotthana_registration_confirmed`
- `rashtrotthana_registration_waitlisted`
- `rashtrotthana_registration_status_changed`
- `rashtrotthana_registration_cancelled`

The WATI plugin should hook into these to dispatch WhatsApp messages, using the registration ID and Language parameter to choose the correct template.

## 8. Multilingual
The `language` parameter (default `en`, alternatively `kn`) is passed during form submission and stored natively on the `wp_ry_registrations` row. This allows the integration layer to route to the correct WATI template. Form validation errors are translated using WordPress standard translation functions (`__`, `_x`).
