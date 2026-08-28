# Rashtrotthana Yoga Website
## Multilingual Architecture and Content Management

**Document:** `multilingual.md`  
**Project:** Rashtrotthana Yoga Website  
**Version:** 1.0  
**Status:** Development Specification  
**Platform:** WordPress  
**Initial Languages:** English, Kannada  

---

# 1. Purpose

This document defines the multilingual architecture for the Rashtrotthana Yoga website.

The initial website languages are:

```text
English
Kannada
```

The objective is to provide a consistent multilingual experience while allowing authorized WordPress administrators to independently manage translated content.

---

# 2. Objectives

The multilingual system must:

- Support English
- Support Kannada
- Allow administrators to manage translations
- Maintain relationships between translated content
- Support multilingual navigation
- Support multilingual Activities
- Support multilingual Centers where applicable
- Support multilingual Events
- Support multilingual Resources
- Support multilingual SEO metadata
- Support multilingual search
- Support language-specific URLs
- Provide an accessible language switcher
- Avoid mixing languages accidentally

---

# 3. Multilingual Architecture

```text
                         WORDPRESS
                             |
                 +-----------+-----------+
                 |                       |
                 v                       v
             ENGLISH                 KANNADA
                 |                       |
                 v                       v
           English Content         Kannada Content
                 |                       |
                 +-----------+-----------+
                             |
                             v
                         DATABASE
```

---

# 4. Translation Model

Translated content should be treated as related versions of the same logical content.

Example:

```text
Logical Activity
       |
       +---- English Version
       |
       +---- Kannada Version
```

The two versions should maintain a translation relationship.

---

# 5. Example

English:

```text
Title:
Yoga for Beginners

Description:
A program designed for people who are new to yoga.
```

Kannada:

```text
Title:
ಯೋಗ ಆರಂಭಿಕರಿಗಾಗಿ

Description:
ಯೋಗಕ್ಕೆ ಹೊಸದಾಗಿ ಪರಿಚಯವಾಗುತ್ತಿರುವವರಿಗಾಗಿ ವಿನ್ಯಾಸಗೊಳಿಸಲಾದ ಕಾರ್ಯಕ್ರಮ.
```

The exact Kannada translations must be approved by Rashtrotthana.

---

# 6. Multilingual Plugin

A WordPress multilingual plugin should be used rather than building a complete translation engine from scratch.

The final plugin should be selected based on:

- WordPress compatibility
- Custom Post Type support
- Custom field support
- Taxonomy support
- SEO compatibility
- Performance
- Translation workflow
- Developer control
- Long-term maintainability

---

# 7. Plugin Selection

The project should evaluate a suitable WordPress multilingual solution before development is finalized.

Potential options include:

```text
WPML
Polylang
TranslatePress
```

The final selection must be approved based on:

- Licensing
- Required features
- Compatibility
- Performance
- Existing WordPress environment
- Maintenance requirements

Do not install multiple multilingual plugins simultaneously.

---

# 8. Language Configuration

Initial languages:

```text
English
Kannada
```

English may be configured as the default language unless Rashtrotthana specifies otherwise.

---

# 9. Default Language

Recommended:

```text
Default Language:
English
```

The final default language must be confirmed before production launch.

---

# 10. Language URLs

The multilingual implementation should use a clear and consistent URL strategy.

Possible structure:

```text
/en/
/kn/
```

Example:

```text
/en/about/
/kn/about/
```

Alternatively, the selected multilingual plugin may provide another supported structure.

The final URL structure must be decided before launch.

---

# 11. URL Stability

Once production URLs are established, they should not be changed unnecessarily.

If multilingual URL structures change:

```text
Old URL
   |
   v
301 Redirect
   |
   v
New URL
```

SEO redirects should be managed carefully.

---

# 12. Language Switcher

The website should provide a visible language switcher.

Example:

```text
EN | ಕನ್ನಡ
```

The switcher should preferably take the visitor to the equivalent page in the selected language.

---

# 13. Equivalent Page Switching

Example:

```text
English Activity
/en/activities/yoga-for-beginners/

        |
        v

Language Switch

        |
        v

Kannada Activity
/kn/activities/yoga-for-beginners/
```

If a Kannada translation does not exist, the system should follow the selected multilingual plugin's configured fallback behavior.

---

# 14. Missing Translation

If an English page exists but Kannada translation has not been created:

```text
English:
Published

Kannada:
Not Translated
```

The system must not display incomplete or misleading translated content.

The final fallback behavior must be defined during implementation.

Recommended approach:

```text
Display available language
+
Clearly indicate language switcher state
```

---

# 15. Content Types Requiring Translation

The following should support translations where applicable:

- Pages
- Posts / News
- Activities
- Centers
- Events
- Resources
- FAQs
- Testimonials
- Banners
- Menus

Not every field necessarily requires translation.

---

# 16. Activity Translation

Activities should support translated:

- Title
- Short Description
- Description
- Category Label
- Instructor Information where applicable
- Registration Text
- CTA Text

Structured values such as:

- Duration
- Capacity
- Latitude
- Longitude

usually do not require translation.

---

# 17. Center Translation

Center information may contain both translatable and non-translatable fields.

Translatable:

- Center Name where required
- Description
- Opening Information
- Additional Instructions

Non-translatable/structured:

- Latitude
- Longitude
- Phone
- Email

Address translation requirements must be decided based on the actual visitor-facing content.

---

# 18. Event Translation

Events may contain:

- Title
- Description
- Venue Display Name
- Instructions
- Registration Text

Dates and times remain the same logical event values unless the event itself is language-specific.

---

# 19. Resource Translation

Resources may have:

- Title
- Description
- Category
- Content

The actual resource file may itself be language-specific.

Example:

```text
Resource:
Yoga Guide

English:
yoga-guide-en.pdf

Kannada:
yoga-guide-kn.pdf
```

These should be represented as related language versions where appropriate.

---

# 20. Gallery Translation

Images themselves are not translated.

However, associated text may require translation:

- Caption
- Title
- Description
- Alt Text where appropriate

The same image may be reused across languages when its visual meaning is identical.

---

# 21. Testimonials

Testimonials may be:

```text
English
Kannada
```

If a testimonial is originally provided in Kannada, it should not automatically be machine-translated and published without approval.

---

# 22. FAQs

FAQ questions and answers must support translation.

Example:

```text
English FAQ
     |
     +-- Question
     +-- Answer

Kannada FAQ
     |
     +-- Question
     +-- Answer
```

---

# 23. Homepage Translation

The homepage should be translated as a complete content experience.

Possible sections:

```text
Hero
Introduction
Featured Activities
Featured Centers
Upcoming Events
Gallery
Testimonials
FAQs
Resources
Contact CTA
```

Each translatable element should have a corresponding Kannada version.

---

# 24. Global Settings

Global website settings may contain language-neutral and language-specific values.

Example:

```text
Global
 |
 +-- Phone
 +-- Email
 +-- Logo
 |
 +-- English Tagline
 +-- Kannada Tagline
```

The multilingual implementation must avoid duplicating values unnecessarily.

---

# 25. Menus

Menus should be independently configured for each language where required.

Example:

```text
English Menu
------------
Home
About
Activities
Centers
Events
Gallery
Resources
Contact
```

Kannada:

```text
ಕನ್ನಡ ಮೆನು
------------
ಮುಖಪುಟ
ನಮ್ಮ ಬಗ್ಗೆ
ಚಟುವಟಿಕೆಗಳು
ಕೇಂದ್ರಗಳು
ಕಾರ್ಯಕ್ರಮಗಳು
ಗ್ಯಾಲರಿ
ಸಂಪನ್ಮೂಲಗಳು
ಸಂಪರ್ಕಿಸಿ
```

Final Kannada labels must be approved by Rashtrotthana.

---

# 26. Navigation Relationship

A translated menu item should point to the translated destination.

Incorrect:

```text
Kannada Menu
    |
    v
English Activity Page
```

Correct:

```text
Kannada Menu
    |
    v
Kannada Activity Page
```

---

# 27. Forms

Registration forms require special multilingual handling.

The following may need translation:

- Field Labels
- Placeholder Text
- Validation Messages
- Required Field Messages
- Submit Button
- Success Message
- Error Messages
- Consent Text

---

# 28. Registration Data

Participant responses should not be translated automatically.

For example:

```text
Name
Phone
Email
Address
```

are stored as submitted.

The language in which the registration form was displayed may optionally be stored as metadata.

Example:

```text
registration_language = en
```

or:

```text
registration_language = kn
```

---

# 29. Registration Confirmation

Confirmation messages may be language-specific.

Example:

```text
English Registration
        |
        v
English Confirmation
```

```text
Kannada Registration
        |
        v
Kannada Confirmation
```

This applies to:

- Website confirmation
- Email confirmation
- WhatsApp template

where supported.

---

# 30. WATI Multilingual Messaging

WATI messages may require separate approved templates.

Example:

```text
Registration Confirmation
        |
        +---- English Template
        |
        +---- Kannada Template
```

The exact template availability depends on WATI/WhatsApp configuration.

---

# 31. Language Selection for WATI

The preferred approach is to associate the registration with the language used during registration.

Example:

```text
Visitor chooses Kannada
       |
       v
Kannada Registration Form
       |
       v
Registration
       |
       +-- language = kn
       |
       v
Kannada WATI Template
```

The exact implementation must be aligned with the approved WATI templates.

---

# 32. Email Language

Email notifications may similarly use:

```text
registration_language
```

to determine the notification language.

If a translated email template does not exist, the system should use the approved fallback language.

---

# 33. Search

Search must respect the selected language.

Example:

```text
Language:
Kannada

Search:
ಯೋಗ

       |
       v

Kannada Results
```

English content should not unintentionally dominate Kannada search results unless fallback behavior is explicitly configured.

---

# 34. Search Index

The multilingual implementation should ensure that:

```text
English Content -> English Search
Kannada Content -> Kannada Search
```

Translated versions should be separately searchable.

---

# 35. SEO

Each language version must be independently SEO-friendly.

Potential fields:

- SEO Title
- Meta Description
- Canonical URL
- Social Title
- Social Description
- Social Image

---

# 36. Hreflang

The multilingual implementation should generate appropriate language/alternate metadata where supported.

Conceptually:

```text
English Page
    |
    +-- alternate hreflang = en

Kannada Page
    |
    +-- alternate hreflang = kn
```

The selected SEO/multilingual solution should manage this where possible.

---

# 37. Canonical URLs

Each language version should have an appropriate canonical URL.

Do not canonicalize every Kannada page to the English page merely because English is the default language.

---

# 38. Sitemap

The multilingual SEO solution should generate appropriate sitemap information for translated pages.

The sitemap should not expose unpublished translations.

---

# 39. Metadata Translation

SEO metadata should be translated rather than simply copying English text.

Example:

```text
English:
Yoga Activities | Rashtrotthana Yoga

Kannada:
ಯೋಗ ಚಟುವಟಿಕೆಗಳು | ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗ
```

Actual SEO copy must be approved.

---

# 40. Browser Language

The website may detect the browser language, but automatic redirection should be used cautiously.

Recommended:

```text
User chooses language
        |
        v
Remember preference
```

Do not repeatedly redirect visitors based solely on browser language.

---

# 41. Language Persistence

The visitor's selected language should remain consistent during navigation.

Example:

```text
Kannada
   |
   +-- Activities
   +-- Centers
   +-- Events
   +-- Resources
```

The user should not unexpectedly switch back to English.

---

# 42. Cookies

If the selected multilingual solution uses cookies for language preference, the implementation must follow applicable privacy requirements and the site's cookie policy.

---

# 43. Admin Translation Workflow

Recommended workflow:

```text
Content Manager
      |
      v
Create English Content
      |
      v
Publish / Approve
      |
      v
Create Kannada Translation
      |
      v
Review
      |
      v
Publish Kannada
```

The exact workflow may differ if Rashtrotthana has a dedicated translation team.

---

# 44. Translation Ownership

The organization should define who is responsible for:

- English Content
- Kannada Translation
- Translation Review
- Publishing
- Corrections

The CMS should allow appropriate users to perform these tasks.

---

# 45. Translation Status

Useful statuses may include:

```text
Not Translated
Draft Translation
In Review
Published
Needs Update
```

The selected multilingual plugin may provide equivalent statuses.

---

# 46. Translation Synchronization

When English content changes:

```text
English Updated
      |
      v
Kannada Translation
      |
      v
Needs Review
```

The system should avoid silently assuming that the existing Kannada translation remains accurate after significant English changes.

---

# 47. Translation Independence

Minor changes to one language should not unnecessarily overwrite the other language.

Example:

```text
English Description Updated
        |
        X
Kannada Description Automatically Destroyed
```

This must be avoided.

---

# 48. Shared Fields

Some fields should remain logically shared.

Examples:

- Activity ID
- Center Relationship
- Event Date
- Latitude
- Longitude
- Capacity
- Registration Enabled

Translation should apply to presentation content, not duplicate the underlying business identity unnecessarily.

---

# 49. Shared Activity Relationship

Example:

```text
Logical Activity
       |
       +---- English
       |
       +---- Kannada
       |
       +---- Center Relationship
```

Both language versions should refer to the same logical Center relationship where appropriate.

---

# 50. Shared Event Date

An Event's date/time should remain consistent across language versions.

```text
English Event
Date: 15 September 2026

Kannada Event
Date: 15 September 2026
```

The display format may differ by locale/language.

---

# 51. Date Formatting

The website should use localized presentation where appropriate.

Example:

```text
English:
15 September 2026

Kannada:
15 ಸೆಪ್ಟೆಂಬರ್ 2026
```

The exact formatting should follow the approved design/localization rules.

---

# 52. Number Formatting

Where required, numbers may use localized display formatting.

However, internal database values must remain normalized.

Example:

```text
Database:
100

Display:
100
```

---

# 53. Time Zones

The website should use the organization's configured timezone for event dates and registration windows.

Language translation must not alter the underlying time value.

---

# 54. Language Codes

Recommended language codes:

```text
English = en
Kannada = kn
```

These codes should be used consistently throughout the system.

---

# 55. Content API

If custom REST APIs are used, language may be supplied as a parameter.

Example:

```text
GET /wp-json/ry/v1/activities?language=en
```

or:

```text
GET /wp-json/ry/v1/activities?language=kn
```

The final implementation should follow the selected multilingual plugin's APIs and data model.

---

# 56. API Language Validation

Only supported language codes should be accepted.

Example:

```text
en -> valid
kn -> valid
fr -> invalid unless added later
```

Invalid language values should result in an appropriate API error or fallback.

---

# 57. Future Languages

The architecture should allow additional languages later.

Possible future:

```text
English
Kannada
Hindi
Tamil
Telugu
Malayalam
```

These are examples only and are not part of the current scope.

Adding a language should not require rebuilding the entire website.

---

# 58. Translation of Theme Text

Hardcoded frontend strings must be translatable.

Examples:

```text
Read More
Register Now
View Details
Search
Submit
Contact Us
Get Directions
Upcoming Events
No Results Found
```

These strings should not be hardcoded only in English.

---

# 59. WordPress Translation Functions

Custom plugin/theme strings should use WordPress internationalization functions.

Examples:

```php
__( 'Register Now', 'rashtrotthana' );

_e( 'Search', 'rashtrotthana' );
```

The correct text domain must be used consistently.

---

# 60. Text Domain

Recommended project text domain:

```text
rashtrotthana
```

All custom theme/plugin translatable strings should use the appropriate project text domain.

---

# 61. JavaScript Translations

If JavaScript contains user-visible strings, they must also support translation.

Do not hardcode:

```javascript
"Loading..."
```

without making it available to the localization system.

---

# 62. Error Messages

Error messages should be translatable.

Examples:

```text
Please enter your name.
Please enter a valid email address.
Registration is closed.
Registration is full.
Something went wrong.
```

---

# 63. Accessibility

The language switcher must be accessible.

Example:

```html
<nav aria-label="Language">
```

The current language should be identifiable.

---

# 64. RTL Consideration

The current languages:

```text
English
Kannada
```

are left-to-right.

The CSS architecture should still avoid unnecessary assumptions that make adding RTL languages impossible in the future.

RTL support is not part of the current scope.

---

# 65. Images and Language

Images containing embedded text should be avoided where possible.

Instead of:

```text
Image with English Text
```

prefer:

```text
Image
+
HTML Text
```

This allows the text to be translated.

---

# 66. PDFs and Documents

Resources may contain language-specific documents.

Example:

```text
Resource:
Yoga Guide

English:
yoga-guide-en.pdf

Kannada:
yoga-guide-kn.pdf
```

The multilingual system should relate the two versions when possible.

---

# 67. Video Content

Videos may have language-specific:

- Title
- Description
- Captions
- Transcript
- Thumbnail

The actual video may be shared if it is language-neutral.

---

# 68. Gallery Captions

Gallery captions should be translated when necessary.

Example:

```text
English:
International Yoga Day Celebration

Kannada:
ಅಂತರರಾಷ್ಟ್ರೀಯ ಯೋಗ ದಿನಾಚರಣೆ
```

Actual translations require approval.

---

# 69. Footer

The footer must be available in both languages.

Potential content:

```text
Organization Information
Contact
Quick Links
Social Media
Privacy
Terms
Copyright
```

---

# 70. Legal Pages

Legal pages must be handled carefully.

Potentially translated:

```text
Privacy Policy
Terms & Conditions
Cookie Policy
```

Translations should be reviewed/approved before publication.

---

# 71. Social Media Links

Social media URLs themselves do not need translation.

Labels around them may require translation.

---

# 72. 404 Page

A localized 404 page should be available.

English:

```text
Page Not Found
```

Kannada:

```text
[Approved Kannada Translation]
```

The actual Kannada wording must be approved.

---

# 73. Search Empty State

The empty search state must be localized.

Example:

```text
English:
No results found.

Kannada:
[Approved Kannada Translation]
```

---

# 74. Loading States

Loading messages must also be translatable.

Example:

```text
Loading...
Please wait...
```

---

# 75. Form Validation

Validation messages must be available in both languages.

Example:

```text
English:
This field is required.

Kannada:
[Approved Kannada Translation]
```

---

# 76. Content Fallback

Fallback rules must be documented before production.

Recommended principle:

```text
Requested Language
       |
       v
Translation Exists?
       |
   +---+---+
   |       |
  Yes      No
   |       |
   v       v
Show    Approved Fallback
```

The final fallback behavior should be selected based on the multilingual plugin.

---

# 77. Translation QA

Every translated page should be checked for:

- Correct translation
- Correct links
- Correct images
- Correct forms
- Correct CTA
- Correct language
- Correct SEO metadata
- Correct navigation
- Correct formatting

---

# 78. Translation QA Checklist

For every important page:

```text
[ ] English content approved
[ ] Kannada translation complete
[ ] Kannada content reviewed
[ ] Links verified
[ ] Images verified
[ ] Alt text reviewed
[ ] SEO title reviewed
[ ] Meta description reviewed
[ ] Language switcher tested
[ ] Mobile tested
```

---

# 79. SEO QA

For each language:

```text
[ ] Correct URL
[ ] Correct canonical
[ ] Correct language metadata
[ ] Correct title
[ ] Correct description
[ ] Correct sitemap entry
[ ] No accidental duplicate indexing
```

---

# 80. Performance

The multilingual system should avoid unnecessary database queries.

Caching should remain compatible with the selected multilingual plugin.

The implementation should test:

```text
English page load
Kannada page load
Language switching
Search
Activities
Centers
Events
Resources
```

---

# 81. Caching

Language-specific pages must not be mixed by cache.

Incorrect:

```text
Kannada request
      |
      v
English cached page
```

Correct:

```text
English Cache
    |
    +-- English Page

Kannada Cache
    |
    +-- Kannada Page
```

The caching/CDN configuration must respect language-specific URLs and cookies where applicable.

---

# 82. CDN

If a CDN is used, multilingual URL/cache configuration must be tested carefully.

Each language version must return the correct language content.

---

# 83. Database Considerations

The multilingual plugin will manage translation relationships.

Custom plugin developers must not bypass the multilingual plugin by directly modifying translation metadata unless the plugin's documented APIs require it.

---

# 84. Developer Integration

When creating Custom Post Types:

```php
register_post_type(
    'ry_activity',
    $args
);
```

the CPT must be registered in a way compatible with the selected multilingual plugin.

The same applies to:

```text
ry_activity
ry_center
ry_event
ry_resource
ry_testimonial
ry_faq
```

---

# 85. Custom Fields

Custom fields must be categorized as:

```text
Translatable
Copy Once
Shared
Not Translatable
```

Example:

```text
Activity Title
-> Translatable

Activity Description
-> Translatable

Activity Capacity
-> Shared

Latitude
-> Shared

Longitude
-> Shared

Registration Enabled
-> Shared
```

The exact field configuration depends on the selected multilingual plugin.

---

# 86. Taxonomies

Taxonomies may require translation.

Examples:

```text
Activity Category
Resource Category
Gallery Category
FAQ Category
```

Example:

```text
English:
Meditation

Kannada:
[Approved Kannada Translation]
```

---

# 87. Taxonomy Relationships

Translated taxonomy terms must maintain logical relationships.

Example:

```text
English Category:
Meditation

Kannada Category:
[Kannada Translation]

       |
       v

Same Logical Category
```

---

# 88. Slugs

Language-specific slugs may be used.

Example:

```text
English:
yoga-for-beginners

Kannada:
[Kannada slug or configured equivalent]
```

The final slug strategy depends on SEO requirements and multilingual plugin capabilities.

---

# 89. Slug Rules

Slugs should be:

- Stable
- Human-readable
- URL-safe
- Consistent
- SEO-friendly

Do not change slugs unnecessarily after launch.

---

# 90. Language Switcher on Detail Pages

On an Activity page:

```text
English Activity
       |
       +---- Kannada translation available
                     |
                     v
                  ಕನ್ನಡ
```

If no translation exists, the switcher should indicate the appropriate state rather than linking to an unrelated page.

---

# 91. Language Switcher on Listing Pages

For listing pages:

```text
English Activities
       |
       v
Kannada Activities
```

Filters and sorting should remain appropriate to the selected language.

---

# 92. Language and Search Parameters

Search URLs should remain language-aware.

Example:

```text
/en/search/?q=yoga
```

and:

```text
/kn/search/?q=ಯೋಗ
```

The exact URL format depends on the multilingual implementation.

---

# 93. Language and Registration

Registration forms must maintain language consistency.

Example:

```text
Kannada Activity
      |
      v
Kannada Registration Form
      |
      v
Kannada Confirmation
```

---

# 94. Language and Google Maps

Map functionality itself does not require separate maps for each language.

The Center's:

```text
Latitude
Longitude
```

remain shared.

The surrounding interface can be translated.

---

# 95. Language and AI

If the AI Knowledge Assistant is implemented later, the AI application should be able to distinguish English and Kannada content.

The AI architecture is separately documented and is not part of the core multilingual WordPress implementation.

---

# 96. Language and WATI

The WATI integration may use the registration language to choose the appropriate approved template.

Example:

```text
registration_language = en
        |
        v
English WATI Template
```

```text
registration_language = kn
        |
        v
Kannada WATI Template
```

This depends on available approved WATI templates.

---

# 97. Content Update Process

When English content changes:

```text
Editor
 |
 v
Update English
 |
 v
Save
 |
 v
Translation Marked for Review
 |
 v
Kannada Updated
 |
 v
Review
 |
 v
Publish
```

This prevents outdated translations from remaining unnoticed.

---

# 98. Emergency Updates

For urgent content updates:

```text
English Update
       |
       v
Immediate Publish
       |
       v
Kannada Translation
       |
       v
Review
       |
       v
Publish
```

The organization should establish an emergency translation procedure.

---

# 99. Translation Quality

AI/machine translation may be used as an internal drafting aid if Rashtrotthana approves it.

However:

```text
Machine Translation
        !=
Final Approved Translation
```

Public Kannada content should be reviewed by an appropriate human reviewer.

---

# 100. Translation Source of Truth

The approved WordPress content is the source of truth for public website content.

External translation documents should not become a competing source of truth.

---

# 101. Backup

Multilingual content must be included in regular WordPress/database backups.

Backups must include:

```text
English Content
Kannada Content
Translation Relationships
Media
Custom Fields
Menus
SEO Metadata
```

---

# 102. Migration

If the website is migrated:

```text
Source WordPress
       |
       v
Database Migration
       |
       v
Media Migration
       |
       v
Multilingual Relationships
       |
       v
Target WordPress
```

Translation relationships must be verified after migration.

---

# 103. Staging

All multilingual changes should be tested on staging before production where possible.

Test:

```text
English
Kannada
Language Switching
Forms
Search
SEO
Menus
Caching
```

---

# 104. Testing Matrix

| Feature | English | Kannada |
|---|---:|---:|
| Homepage | ✓ | ✓ |
| About | ✓ | ✓ |
| Activities | ✓ | ✓ |
| Centers | ✓ | ✓ |
| Events | ✓ | ✓ |
| Gallery | ✓ | ✓ |
| Resources | ✓ | ✓ |
| Contact | ✓ | ✓ |
| Search | ✓ | ✓ |
| Registration | ✓ | ✓ |
| Forms | ✓ | ✓ |
| SEO | ✓ | ✓ |
| Navigation | ✓ | ✓ |
| 404 | ✓ | ✓ |

---

# 105. Browser Testing

Test multilingual behavior on:

```text
Chrome
Firefox
Safari
Edge
Android browsers
iOS browsers
```

---

# 106. Mobile Testing

Verify:

```text
Language switcher
Navigation
Long Kannada text
Buttons
Forms
Maps
Cards
Tables
Modals
Error messages
```

Kannada text may occupy different amounts of space than English, so layouts must be tested with real translated content.

---

# 107. Typography

The design must use a font stack that supports Kannada correctly.

The final font should be selected based on:

- Kannada glyph coverage
- English glyph coverage
- Readability
- Performance
- Brand design
- Licensing

Do not assume that every Latin-only web font supports Kannada.

---

# 108. Text Overflow

The frontend must be tested for:

```text
Long Kannada titles
Long buttons
Long navigation labels
Long form labels
Long FAQ questions
```

Avoid fixed-width controls that assume English text length.

---

# 109. Accessibility

Both languages must maintain:

- Correct language metadata
- Readable typography
- Sufficient contrast
- Keyboard accessibility
- Screen reader compatibility
- Accessible form labels
- Accessible navigation

---

# 110. HTML Language Attribute

The rendered page should identify the current language appropriately.

Conceptually:

```html
<html lang="en">
```

for English and:

```html
<html lang="kn">
```

for Kannada.

The selected multilingual system should handle this where possible.

---

# 111. Content Model Summary

```text
                       CONTENT
                          |
             +------------+------------+
             |                         |
             v                         v
         ENGLISH                   KANNADA
             |                         |
             +------------+------------+
                          |
                          v
                  Translation Relation
                          |
                          v
                    WordPress CMS
```

---

# 112. Multilingual Architecture Summary

```text
                         VISITOR
                            |
                            v
                    Language Selection
                       /          \
                      /            \
                     v              v
                ENGLISH           KANNADA
                   |                 |
                   v                 v
              WordPress         WordPress
                   |                 |
                   +--------+--------+
                            |
                            v
                         Database
                            |
                            v
                       Integrations
                            |
              +-------------+-------------+
              |             |             |
              v             v             v
            WATI        Google Maps      Search
```

---

# 113. Development Rules

1. The website must support English and Kannada.
2. Use one approved multilingual WordPress solution.
3. Do not install multiple multilingual plugins.
4. Every public content type must be evaluated for translation.
5. Translation relationships must be preserved.
6. Do not duplicate shared business data unnecessarily.
7. Keep English and Kannada content independently editable.
8. Do not silently overwrite translations.
9. Translation changes should be reviewed when source content changes significantly.
10. All custom strings must support WordPress internationalization.
11. Custom Post Types must be compatible with the selected multilingual plugin.
12. Custom fields must be classified as translatable/shared/not translatable.
13. Search must respect the selected language.
14. SEO metadata must be language-specific.
15. Language-specific pages must have correct canonical/alternate metadata.
16. Language-specific caching must be configured correctly.
17. Registration forms must support both languages.
18. WATI templates should follow registration language where approved templates exist.
19. Kannada public content should receive appropriate human review.
20. Production URLs must be finalized before launch.
21. All translated content must be included in backups.
22. Multilingual functionality must be tested on desktop and mobile.
23. Typography must support Kannada correctly.
24. Layouts must not assume English text length.
25. Adding another language in the future should not require rebuilding the website.
