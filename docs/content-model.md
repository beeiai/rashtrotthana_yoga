# Rashtrotthana Yoga Website

## Content Model

**Document:** `content-model.md`
**Project:** Rashtrotthana Yoga Website
**Version:** 1.0
**Status:** Development Specification
**CMS:** WordPress

---

# 1. Purpose

This document defines the content model for the Rashtrotthana Yoga website.

The content model describes:

* What content exists
* Where content is stored
* How administrators create content
* How content entities relate to one another
* Which fields each entity contains
* Which content is public
* Which content is administrative
* How content is presented on the website
* How content can be reused across different sections

The objective is to ensure that the website does not depend on hardcoded content and that Rashtrotthana administrators can maintain the website through WordPress.

---

# 2. Content Architecture

The website content is divided into the following major groups:

```text
CONTENT
|
├── General Content
│   ├── Pages
│   ├── Posts / News
│   └── Menus
│
├── Structured Content
│   ├── Activities
│   ├── Centers
│   ├── Events
│   ├── Resources
│   ├── Gallery
│   ├── Testimonials
│   ├── FAQs
│   └── Banners
│
├── Global Content
│   ├── Site Settings
│   ├── Contact Details
│   └── Social Links
│
└── Transactional Content
    └── Registrations
```

---

# 3. Content Principles

The following principles apply to all content.

## 3.1 Structured Data

Repeatable content must be stored as structured data.

For example, Activities should not be created as manually formatted HTML pages.

Instead:

```text
Activity
    |
    +-- Title
    +-- Description
    +-- Category
    +-- Center
    +-- Registration
    +-- Image
```

This allows Activities to be:

* Searched
* Filtered
* Categorized
* Related to Centers
* Related to Registration Forms
* Displayed in lists
* Featured on the homepage

The technical specification explicitly requires Activity data to be structured for searching, filtering, categorization and relationships.

---

# 4. Content Types

The primary content types are:

| Content Type    | WordPress Implementation         |
| --------------- | -------------------------------- |
| Pages           | WordPress Pages                  |
| News            | WordPress Posts or approved CPT  |
| Activities      | Custom Post Type                 |
| Centers         | Custom Post Type                 |
| Events          | Custom Post Type                 |
| Resources       | Custom Post Type                 |
| Gallery         | Media + custom gallery structure |
| Testimonials    | Custom Post Type                 |
| FAQs            | Custom Post Type                 |
| Banners         | Custom structure/CPT             |
| Contact Details | Settings / structured content    |
| Registrations   | Custom registration tables       |

---

# 5. Public Website Structure

The public website contains:

```text
Home
About
Activities
Centers
Events & News
Gallery
Resources
Contact
Search
English
Kannada
```

Each section should use the content model rather than hardcoded data.

---

# 6. Pages

WordPress Pages will be used for relatively stable organizational content.

Examples:

```text
Home
About Us
Our Mission
Our Vision
Contact
Privacy Policy
Terms & Conditions
```

The exact pages may change according to final approved website content.

---

# 7. Homepage

The homepage will be composed from reusable content blocks/components.

Possible sections:

```text
Hero / Banner
Introduction
Featured Activities
Featured Centers
Upcoming Events
Gallery Highlights
Testimonials
FAQs
Resources
Contact CTA
```

The administrator should be able to manage the content displayed in configurable sections where required.

---

# 8. Homepage Banner

A banner may contain:

```text
Title
Subtitle
Description
Image
Mobile Image
CTA Text
CTA URL
Display Order
Start Date
End Date
Active
```

Example:

```text
Title:
Discover the Path of Yoga

Subtitle:
Wellness for Body and Mind

CTA:
Explore Activities
```

---

# 9. Activities

Activities represent programs, yoga practices, classes or offerings.

Example:

```text
Activity
---------------------------
Surya Namaskar
```

The Activity contains structured information.

---

# 10. Activity Fields

| Field                | Type             | Required |
| -------------------- | ---------------- | -------: |
| Title                | Text             |      Yes |
| Short Description    | Text/Rich Text   |       No |
| Description          | Rich Text        |      Yes |
| Featured Image       | Media            |       No |
| Gallery              | Media            |       No |
| Category             | Taxonomy         |       No |
| Center               | Relationship     |       No |
| Duration             | Text/Number      |       No |
| Frequency            | Text             |       No |
| Instructor           | Text             |       No |
| Registration Enabled | Boolean          |      Yes |
| Registration Form    | Relationship     |       No |
| Featured             | Boolean          |       No |
| Status               | WordPress status |      Yes |

---

# 11. Activity Category

Activities may be grouped into categories.

Possible categories:

```text
Yoga
Meditation
Pranayama
Wellness
Children
Senior Programs
Workshops
Other
```

These are examples only. Final categories must be provided/approved by Rashtrotthana.

---

# 12. Activity-Center Relationship

Activities may be associated with Centers.

Example:

```text
Activity:
Morning Yoga

Center:
Bangalore Yoga Center
```

A single Center may have multiple Activities.

```text
Bangalore Center
       |
       +---- Morning Yoga
       +---- Meditation
       +---- Pranayama
```

The Center should be stored as a relationship rather than copying the full Center information into the Activity.

---

# 13. Activity Registration Relationship

An Activity may optionally have registration enabled.

```text
Activity
   |
   +-- Registration Enabled = Yes
   |
   +-- Registration Form
```

If registration is disabled:

```text
Activity
   |
   +-- Registration Enabled = No
```

The public website must not display a registration form when registration is disabled.

---

# 14. Centers

Centers represent physical Rashtrotthana Yoga locations.

A Center should provide visitors with:

* Name
* Address
* Contact information
* Operating information
* Location
* Activities
* Map
* Directions

---

# 15. Center Fields

| Field          | Type            |     Required |
| -------------- | --------------- | -----------: |
| Name           | Text            |          Yes |
| Description    | Rich Text       |           No |
| Address        | Text            |          Yes |
| City           | Text            |          Yes |
| State          | Text            |           No |
| Pincode        | Text            |           No |
| Phone          | Text            |           No |
| Email          | Email           |           No |
| Opening Hours  | Structured/Text |           No |
| Latitude       | Decimal         | Yes for Maps |
| Longitude      | Decimal         | Yes for Maps |
| Featured Image | Media           |           No |
| Gallery        | Media           |           No |
| Status         | Publish Status  |          Yes |

---

# 16. Center Display

A Center page should generally contain:

```text
Center Name
Hero Image
Description

Address
Phone
Email
Opening Hours

Activities Available

Map

Get Directions
```

---

# 17. Center Location

Location information must be structured.

Minimum map information:

```text
Latitude
Longitude
```

The same location data can be reused for:

* Center page
* Center listing
* Google Maps
* Directions
* Search/filtering
* Structured data where applicable

---

# 18. Events

Events represent scheduled programs and activities.

Examples:

```text
Yoga Workshop
International Yoga Day
Meditation Camp
Special Training Program
```

---

# 19. Event Fields

| Field                | Type           | Required |
| -------------------- | -------------- | -------: |
| Title                | Text           |      Yes |
| Description          | Rich Text      |      Yes |
| Start Date           | Date           |      Yes |
| Start Time           | Time           |       No |
| End Date             | Date           |       No |
| End Time             | Time           |       No |
| Venue                | Text           |      Yes |
| Center               | Relationship   |       No |
| Featured Image       | Media          |       No |
| Gallery              | Media          |       No |
| Registration Enabled | Boolean        |      Yes |
| Registration Form    | Relationship   |       No |
| Maximum Participants | Number         |       No |
| Registration Start   | DateTime       |       No |
| Registration End     | DateTime       |       No |
| Featured             | Boolean        |       No |
| Status               | Publish Status |      Yes |

---

# 20. Event Status

The system should distinguish between:

```text
Draft
Published
Cancelled
Completed
```

Upcoming/past display should primarily be calculated using event dates.

---

# 21. Upcoming Events

Upcoming events are events whose relevant start date/time has not passed.

Example:

```text
Current Date
     |
     v
Event Start
     |
     +---- Future -> Upcoming
```

---

# 22. Past Events

Past events are events whose relevant date/time has passed.

```text
Current Date
     |
     v
Event Start
     |
     +---- Past -> Past Event
```

Past events should remain available unless an administrator archives or removes them.

---

# 23. Events and Registrations

Events and registrations are separate entities.

```text
Event
   |
   +---- Registration Form
               |
               +---- Registrations
```

An event can exist without registration.

An event can also have a dedicated registration form.

---

# 24. Resources

Resources provide useful educational or informational materials.

Possible resource types:

```text
PDF
Document
Video
Article
Guide
External Link
```

---

# 25. Resource Fields

| Field            | Type              |    Required |
| ---------------- | ----------------- | ----------: |
| Title            | Text              |         Yes |
| Description      | Rich Text         |          No |
| Category         | Taxonomy          |          No |
| Resource Type    | Taxonomy          |         Yes |
| Language         | Taxonomy/Metadata |         Yes |
| File             | Media             | Conditional |
| External URL     | URL               | Conditional |
| Featured Image   | Media             |          No |
| Publication Date | Date              |          No |
| Featured         | Boolean           |          No |
| Visibility       | Status            |         Yes |

Either an attached file or external URL may be used depending on resource type.

---

# 26. Resource Categories

Possible categories:

```text
Yoga
Health & Wellness
Education
Publications
Training
Videos
Guides
Other
```

Final categories are subject to approval.

---

# 27. Resource Access

Resources may have different visibility rules.

Possible visibility:

```text
Public
Private
Restricted
```

Public resources may be accessed by visitors.

Private/restricted resources must not be exposed through public URLs or search without authorization.

---

# 28. Gallery

The Gallery is primarily a presentation of WordPress Media Library assets.

Gallery organization may use categories.

Example:

```text
Gallery
   |
   +-- Events
   +-- Activities
   +-- Centers
   +-- Workshops
```

---

# 29. Gallery Image Data

Each image should use WordPress Media Library metadata.

Optional additional information:

```text
Gallery Category
Caption
Alt Text
Event
Activity
Center
Display Order
```

---

# 30. Image Accessibility

All meaningful images should have appropriate alternative text.

Decorative images should be marked appropriately.

Alt text must describe the image's purpose rather than unnecessarily repeating surrounding text.

---

# 31. Testimonials

Testimonials contain feedback or statements approved for publication.

Fields:

```text
Name
Testimonial
Photo
Designation
Rating
Featured
Status
```

No testimonial should be published without appropriate approval.

---

# 32. FAQs

FAQs consist of:

```text
Question
Answer
Category
Display Order
Featured
Status
```

Example:

```text
Question:
How can I register for an activity?

Answer:
Select an activity and complete the registration form...
```

---

# 33. Contact Details

Contact information should be centrally maintained.

Possible information:

```text
Organization Name
General Phone
General Email
Address
Office Hours
Social Links
```

Center-specific contact details should remain with the Center entity.

---

# 34. Navigation

Navigation should be managed using WordPress menu functionality.

Primary navigation may include:

```text
Home
About
Activities
Centers
Events
Gallery
Resources
Contact
```

The actual final navigation is subject to design approval.

---

# 35. Search

Search should index approved public content.

Searchable entities may include:

```text
Pages
Activities
Centers
Events
Resources
```

Private administrative information must never be included.

---

# 36. Languages

The website will support:

```text
English
Kannada
```

Translation will be handled using the selected WordPress multilingual solution.

Content requiring translation should include:

```text
Pages
Activities
Centers
Events
Resources
Menus
Form Labels
System Messages
```

---

# 37. Content Status

All content entities should use an appropriate publishing workflow.

Typical statuses:

```text
Draft
Published
Archived
```

Events may additionally have:

```text
Cancelled
Completed
```

---

# 38. Publishing Workflow

Recommended workflow:

```text
Content Manager
      |
      v
Create Draft
      |
      v
Review
      |
      v
Publish
      |
      v
Update / Archive
```

The exact approval workflow may be adjusted according to Rashtrotthana's requirements.

---

# 39. Content Ownership

Each content record should have an identifiable author/creator where WordPress supports it.

Example:

```text
Activity
   |
   +-- Created By
   +-- Created Date
   +-- Modified By
   +-- Modified Date
```

WordPress's native author and revision capabilities should be used where appropriate.

---

# 40. Reusable Content

Content should be reusable.

Example:

```text
Center
   |
   +---- Activity Page
   |
   +---- Event Page
   |
   +---- Center Listing
```

The Center name/address should not need to be manually re-entered in every location.

---

# 41. Homepage Featured Content

The homepage may display:

```text
Featured Activities
Featured Events
Featured Centers
Featured Resources
Featured Testimonials
```

Content can be selected using a `Featured` flag or another approved editorial mechanism.

---

# 42. News

Events & News may contain both:

```text
Events
News / Announcements
```

Events should use the Event Custom Post Type.

News may use standard WordPress Posts unless a separate News Custom Post Type is approved.

---

# 43. SEO Content

Each public content entity may require:

```text
SEO Title
Meta Description
Canonical URL
Social Image
```

The selected SEO plugin may manage these fields.

The content model should remain compatible with the selected SEO implementation.

---

# 44. URL Structure

Recommended URL structures:

```text
/activities/
/activities/{activity-slug}/

/centers/
/centers/{center-slug}/

/events/
/events/{event-slug}/

/resources/
/resources/{resource-slug}/
```

The final URL structure should be confirmed before production launch because changing public URLs later can create unnecessary redirects.

---

# 45. Slugs

Each public content entity should have a unique WordPress slug.

Examples:

```text
yoga-for-beginners
bangalore-yoga-center
international-yoga-day
yoga-beginners-guide
```

Slugs should be:

* Lowercase
* Human-readable
* Stable
* SEO-friendly
* Free of unnecessary special characters

---

# 46. Content Relationships Summary

```text
CENTER
   |
   +------< ACTIVITY
   |
   +------< EVENT


ACTIVITY
   |
   +------> REGISTRATION FORM


EVENT
   |
   +------> REGISTRATION FORM


REGISTRATION FORM
   |
   +------< FORM FIELD
   |
   +------< REGISTRATION


RESOURCE
   |
   +------> RESOURCE CATEGORY


GALLERY
   |
   +------> GALLERY CATEGORY
```

---

# 47. Content Validation

Administrators must not be allowed to save invalid structured content.

Examples:

```text
Latitude must be numeric.
Longitude must be numeric.
Email must be valid.
Capacity must be non-negative.
Event end date should not precede start date.
Registration end should not precede registration start.
```

Validation must happen server-side.

---

# 48. Content Deletion

Deleting content must consider relationships.

For example:

```text
Center
   |
   +---- Activities
   +---- Events
```

Before deleting a Center, the system should determine how related Activities and Events will behave.

The implementation should avoid orphaned relationships.

---

# 49. Content Revisions

Where supported, WordPress revisions should be used for important editorial content.

Administrators should be able to restore previous content versions when appropriate.

---

# 50. Media Guidelines

Images should be optimized before or during upload.

Recommended principles:

* Use appropriate dimensions
* Avoid unnecessarily large files
* Use descriptive filenames
* Provide alt text
* Use responsive WordPress image sizes
* Avoid uploading duplicate originals

---

# 51. Content Security

Public content may be displayed to visitors.

Administrative content must remain protected.

The following must never become public content:

```text
Registration data
API credentials
Administrative configuration
Private resources
Internal notes
```

---

# 52. Content Model Summary

The website's content model is:

```text
                    WEBSITE CONTENT
                           |
        +------------------+------------------+
        |                  |                  |
        v                  v                  v
   General Content    Structured Content   Global Data
        |                  |                  |
        v                  v                  v
     Pages            Activities          Settings
     News             Centers             Contacts
     Menus            Events              Social Links
                      Resources
                      Gallery
                      Testimonials
                      FAQs
                      Banners
```

Transactional data is kept separately:

```text
                 TRANSACTIONAL DATA
                         |
                         v
                  Registration
                         |
                         +---- Form
                         +---- Fields
                         +---- Answers
```

---

# 53. Content Management Rules

1. Use structured fields instead of manually formatted HTML for repeatable entities.
2. Do not duplicate Center information inside Activities and Events.
3. Use Custom Post Types for structured entities.
4. Use taxonomies for classification.
5. Use Media Library for standard media.
6. Keep registration data separate from normal content.
7. Protect private content.
8. Validate all structured fields server-side.
9. Maintain English and Kannada versions consistently.
10. Use stable URLs.
11. Avoid unnecessary hardcoded content in the theme.
12. Keep business logic outside the theme.
13. Maintain reusable templates.
14. Use WordPress revisions where appropriate.
15. Ensure deleted content does not create broken relationships.
