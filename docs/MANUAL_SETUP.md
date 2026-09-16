# Registration Manual Setup

The Rashtrotthana Registration plugin requires the following manual setup tasks to become fully operational in a production environment.

## 1. WATI (WhatsApp) Integration Templates

**WHAT:** Approval and Creation of WhatsApp Templates in WATI.
**WHERE:** Inside the Rashtrotthana WATI Dashboard.
**HOW:** Create templates that match the hook arguments (e.g., `name`, `activity`, `date`, `time`, `venue`, `registration_id`). Create both English and Kannada versions. Provide the template names to the developer integrating WATI.
**VERIFY:** Trigger a test registration and ensure the WATI integration (being built by the other developer) successfully sends the template message.

## 2. Event/Activity Registration Metadata

**WHAT:** Setting Capacity and Dates on Events/Activities.
**WHERE:** WordPress Admin -> Events / Activities.
**HOW:** 
- Set `_ry_requires_registration` to `1`.
- Set `_ry_maximum_participants` (e.g., `100`).
- Set `_ry_registration_start` and `_ry_registration_end` (MySQL DateTime format, e.g. `2026-10-01 10:00:00`).
**VERIFY:** Attempt to register outside the date window or past capacity to verify the system rejects or waitlists the registration correctly.

## 3. Creating Forms

**WHAT:** Adding actual Registration Forms to the database.
**WHERE:** Directly in `wp_ry_forms` and `wp_ry_form_fields` (A Form Builder UI is not in scope for the initial core plugin, so initial forms must be seeded).
**HOW:** Insert a record into `wp_ry_forms` (e.g., ID 1, "Standard Registration"). Insert fields into `wp_ry_form_fields` (e.g. `name`, `email`, `phone`).
**VERIFY:** Visit the public REST API `GET /wp-json/ry/v1/forms/1` to ensure the structure returns correctly.
