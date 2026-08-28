# Rashtrotthana Yoga Website
## Google Maps Integration

**Document:** `google-maps.md`  
**Project:** Rashtrotthana Yoga Website  
**Version:** 1.0  
**Status:** Development Specification  
**Platform:** WordPress  
**Integration:** Google Maps Platform  

---

# 1. Purpose

This document defines the requirements and implementation approach for integrating Google Maps into the Rashtrotthana Yoga website.

The primary purpose of the integration is to help visitors:

- Find Rashtrotthana Yoga centers
- View center locations
- Understand center addresses
- Open locations in Google Maps
- Get navigation directions
- Access center contact information
- View location information on desktop and mobile

The integration should be implemented in a way that is secure, maintainable and reusable across the website.

---

# 2. Scope

The Google Maps integration includes:

- Center Location Management
- Map Display
- Map Markers
- Center Detail Maps
- Center Listing Maps
- Directions
- Google Maps Links
- Latitude/Longitude Management
- API Key Configuration
- Responsive Map Display

Optional functionality may include:

- Multiple Center Markers
- Marker Clustering
- Search by Location
- Map Filtering
- Distance-based Search

These optional features require separate confirmation before implementation.

---

# 3. High-Level Architecture

```text
                    WORDPRESS ADMIN
                           |
                           v
                       CENTER
                           |
              +------------+------------+
              |                         |
              v                         v
          Address                  Coordinates
              |                         |
              +------------+------------+
                           |
                           v
                    WORDPRESS DATABASE
                           |
                           v
                    PUBLIC WEBSITE
                           |
                           v
                    GOOGLE MAPS
```

---

# 4. Center Location Data

Each Center should contain structured location information.

Minimum recommended fields:

- Center Name
- Address
- City
- State
- Pincode
- Latitude
- Longitude
- Phone
- Email

The address is primarily human-readable information.

Latitude and longitude provide precise map positioning.

---

# 5. Coordinate Storage

Coordinates should be stored as numeric values.

Example:

```text
Latitude:
12.971600

Longitude:
77.594600
```

The exact coordinates must be supplied or verified for each Rashtrotthana center.

---

# 6. Why Coordinates Are Stored

Coordinates should not be calculated from the address every time a visitor loads the website.

Instead:

```text
Center
 |
 +-- Address
 |
 +-- Latitude
 +-- Longitude
```

This provides:

- Faster rendering
- More predictable marker placement
- Less dependence on geocoding requests
- Lower external API usage
- Better control over location accuracy

---

# 7. Admin Center Form

The WordPress Center editor should provide location fields.

Example:

```text
Location
----------------------------

Address
[________________________]

City
[________________________]

State
[________________________]

Pincode
[________________________]

Latitude
[________________________]

Longitude
[________________________]
```

The exact UI may be improved using a map picker if approved.

---

# 8. Coordinate Validation

Latitude must be within:

```text
-90 to +90
```

Longitude must be within:

```text
-180 to +180
```

Invalid coordinates must not be saved.

---

# 9. Google Maps API Key

Where Google Maps Platform APIs requiring a key are used, the project must use a Google Maps API key.

The key must belong to Rashtrotthana's Google Cloud/Google Maps Platform account.

---

# 10. API Key Ownership

The recommended ownership model is:

```text
Rashtrotthana
      |
      v
Google Cloud Project
      |
      v
Google Maps API Key
      |
      v
Website
```

Websiteo/development team should not permanently own the production Google Maps billing account or production API key.

---

# 11. API Key Security

The API key must be appropriately restricted.

Restrictions should be configured according to the Google Maps Platform services actually used.

Potential restrictions include:

- HTTP referrer restrictions
- API restrictions
- Application restrictions

The exact configuration depends on the selected Maps APIs.

---

# 12. APIs

Only required Google Maps Platform services should be enabled.

Potential services:

- Maps JavaScript API
- Places API
- Geocoding API
- Maps Embed API

Do not enable unnecessary APIs.

The final API list must be determined from the actual implementation.

---

# 13. Basic Map Display

For a simple Center map, the website may display:

```text
+---------------------------------------+
|                                       |
|               MAP                     |
|                                       |
|                   Marker              |
|                     📍                |
|                                       |
+---------------------------------------+
```

The marker represents the Center's coordinates.

---

# 14. Center Detail Page

A Center detail page should contain:

```text
Center Name

Description

Address
Phone
Email
Opening Hours

Google Map

[Get Directions]
```

---

# 15. Map Marker

Each Center should have a marker.

Conceptually:

```text
Center
   |
   v
Latitude + Longitude
   |
   v
Google Maps Marker
```

The marker may display the Center name when selected.

---

# 16. Marker Information

A marker information panel may contain:

```text
Center Name
Address
Phone
```

Example:

```text
Bangalore Yoga Center

Example Address
Bengaluru

Phone:
+91 XXXXX XXXXX

[Get Directions]
```

---

# 17. Multiple Center Map

The Centers listing page may optionally display all centers on one map.

Example:

```text
+---------------------------------------------+
|                                             |
|       📍              📍                    |
|                                             |
|                    📍                       |
|                                             |
|  📍                         📍              |
|                                             |
+---------------------------------------------+
```

Each marker corresponds to a WordPress Center.

---

# 18. Center Listing

A recommended Center page layout:

```text
CENTERS

[ Search / Filter ]

+-------------------+
| Center Card       |
|                   |
| Address           |
| Phone             |
| [View Center]     |
+-------------------+

+-------------------+
| Center Card       |
+-------------------+

                MAP
```

The final design is subject to UI approval.

---

# 19. Get Directions

Each Center should provide a convenient way to open navigation.

The implementation may generate a Google Maps directions URL using the Center's coordinates or address.

Conceptually:

```text
Website
   |
   v
Get Directions
   |
   v
Google Maps
   |
   v
Navigation
```

The user may then use Google Maps' own navigation capabilities.

---

# 20. External Google Maps Link

A Center may also have a "View in Google Maps" action.

This should open Google Maps in an appropriate browser/app context.

The website should not attempt to reproduce Google Maps navigation functionality itself.

---

# 21. Mobile Behavior

Maps must work on:

- Mobile
- Tablet
- Desktop

On mobile:

```text
Center Details
       |
       v
Map
       |
       v
Get Directions
```

The map must not create horizontal page overflow.

---

# 22. Responsive Map Dimensions

The map container should use responsive sizing.

Example conceptual CSS:

```css
.map-container {
    width: 100%;
    min-height: 320px;
}
```

The exact dimensions depend on the approved design.

---

# 23. Accessibility

The map interface must not be the only method of accessing Center information.

Important information must also appear as text:

- Center Name
- Address
- Phone
- Email

Users who cannot use the map must still be able to access location information.

---

# 24. Keyboard Accessibility

Interactive controls around the map should be keyboard accessible.

Examples:

- View Center
- Get Directions
- View on Google Maps

Buttons and links must have meaningful accessible names.

---

# 25. Map Loading Performance

Maps can be relatively expensive resources.

The implementation should avoid unnecessarily loading Google Maps on every website page.

Recommended:

```text
Home
   |
   +-- No Map unless required

Centers
   |
   +-- Map

Center Detail
   |
   +-- Map
```

---

# 26. Lazy Loading

Where appropriate, maps should be loaded only when required or when they approach the viewport.

This helps reduce unnecessary page-load cost.

The exact implementation depends on the Google Maps integration method.

---

# 27. Map on Homepage

A homepage map should only be included if the approved design requires it.

If included:

```text
Featured Centers
       |
       v
Map
       |
       v
View All Centers
```

The homepage should not load an unnecessarily complex map.

---

# 28. Address and Coordinates

The system should maintain both:

```text
Human-readable Address
Precise Coordinates
```

Example:

```text
Address:
Example Road, Bengaluru

Latitude:
12.xxxxxx

Longitude:
77.xxxxxx
```

---

# 29. Address Changes

If a Center moves:

```text
Admin
 |
 v
Edit Center
 |
 +-- Update Address
 +-- Update Latitude
 +-- Update Longitude
 |
 v
Save
 |
 v
Website Map Updated
```

The administrator must update coordinates whenever the physical location changes.

---

# 30. Geocoding

If automatic geocoding is implemented, it should be treated as an administrative convenience rather than the only source of truth.

Recommended workflow:

```text
Admin enters address
        |
        v
Geocoding
        |
        v
Suggested Coordinates
        |
        v
Admin confirms
        |
        v
Coordinates stored
```

Automatic geocoding should not silently replace approved coordinates.

---

# 31. Geocoding API

If Google Geocoding API is used:

```text
WordPress
    |
    | Server-side HTTPS
    v
Google Geocoding API
    |
    v
Coordinates
```

The API key must remain protected according to the API's supported security model.

The final implementation should use the appropriate Google Maps Platform configuration.

---

# 32. Location Accuracy

Center coordinates should ideally point to:

```text
Actual Center Entrance
```

rather than merely:

```text
City Center
```

Coordinates must be verified before production launch.

---

# 33. Google Maps Billing

Rashtrotthana should own the production Google Cloud/Maps Platform billing account.

The organization must review:

- Google Maps usage
- Billing
- Quotas
- API restrictions

before production deployment.

---

# 34. Quotas

Where Google Maps Platform APIs are used, appropriate quotas and restrictions should be configured.

The development team should avoid uncontrolled API usage.

---

# 35. Development Environment

Development may use:

```text
Development Google Maps Key
```

where practical.

Production should use:

```text
Production Google Maps Key
```

Production credentials must not be committed to Git.

---

# 36. Environment Separation

Recommended:

```text
LOCAL
 |
 +-- Development configuration

STAGING
 |
 +-- Staging configuration

PRODUCTION
 |
 +-- Production configuration
```

---

# 37. WordPress Data Model

The Center Custom Post Type should contain the location metadata.

Conceptually:

```text
Center
 |
 +-- address
 +-- city
 +-- state
 +-- pincode
 +-- latitude
 +-- longitude
 +-- phone
 +-- email
```

---

# 38. REST API Representation

If Center data is exposed through the custom REST API:

```text
GET /wp-json/ry/v1/centers
```

The response may include:

```json
{
  "id": 25,
  "name": "Bangalore Center",
  "address": "Example Address",
  "city": "Bengaluru",
  "latitude": 12.9716,
  "longitude": 77.5946
}
```

Only public Center information should be returned.

---

# 39. Map Data Security

Location information for public Centers is generally public content.

However, administrative-only metadata must not be included in the public response.

---

# 40. Map Error Handling

If Google Maps fails to load:

```text
Google Maps unavailable
        |
        v
Display Address
        |
        v
Display "Open in Google Maps"
```

The Center page should remain usable.

---

# 41. API Failure

The website must not become unusable simply because the Google Maps service is unavailable.

Fallback content should include:

- Center Name
- Address
- Phone
- Email
- Google Maps Link

where available.

---

# 42. Invalid Coordinates

If a Center has invalid/missing coordinates:

```text
Center Page
    |
    v
Map unavailable
    |
    v
Display Address
    |
    v
Administrator fixes location data
```

The frontend must not attempt to initialize a map with invalid coordinates.

---

# 43. Marker Clustering

If the number of Centers becomes large, marker clustering may be considered.

Example:

```text
             15
              ●
```

The exact clustering solution should be selected only if required.

For a small number of Centers, clustering may be unnecessary.

---

# 44. Center Filtering

If the website supports Center filtering:

```text
State
City
Area
Activity
```

the map should update to show matching Centers where practical.

Example:

```text
Filter:
Bengaluru

       |
       v

Map
   |
   +-- Center A
   +-- Center B
   +-- Center C
```

---

# 45. Activity-Center Integration

Activities may reference a Center.

Example:

```text
Activity:
Morning Yoga

Center:
Bangalore Center

      |
      v
Activity Page

      |
      v
Center Location
```

The Activity page may provide a link to the Center page rather than duplicating complete map content.

---

# 46. Events-Center Integration

Events may also reference a Center.

Example:

```text
Event
 |
 +-- Venue
 |
 +-- Center
       |
       v
   Location
```

This allows consistent location information.

---

# 47. Google Maps Link Generation

The application may generate map links from:

```text
Latitude
Longitude
```

or:

```text
Address
```

Coordinates are preferred where available because they are more precise.

---

# 48. Security Rules

1. Never expose server-side Google API credentials.
2. Use API restrictions.
3. Use application/referrer restrictions where appropriate.
4. Enable only required Google APIs.
5. Do not commit credentials to Git.
6. Use HTTPS.
7. Do not trust arbitrary coordinates submitted by public users.
8. Validate coordinates before rendering.
9. Keep fallback address information available.
10. Monitor API usage and billing.

---

# 49. Testing

Google Maps integration must be tested on:

- Chrome
- Firefox
- Safari
- Edge
- Android
- iOS
- Desktop
- Tablet
- Mobile

Test:

- Map loads
- Marker appears
- Correct location
- Multiple markers
- Get Directions
- External Google Maps link
- Map failure
- Slow connection
- Invalid coordinates
- Mobile layout
- Keyboard controls
- Screen reader accessibility

---

# 50. Acceptance Criteria

The Google Maps integration is complete when:

- Centers contain structured location information.
- Valid coordinates can be stored.
- Center pages display maps where configured.
- Markers point to approved Center locations.
- Users can open directions.
- Maps are responsive.
- Location information remains available if Maps fails.
- API credentials are appropriately restricted.
- Production credentials are not committed to Git.
- Google Maps usage is owned by Rashtrotthana.
- The implementation passes agreed browser/device testing.

---

# 51. Final Architecture

```text
                  WORDPRESS ADMIN
                         |
                         v
                      CENTER
                         |
          +--------------+--------------+
          |                             |
          v                             v
       Address                   Latitude/Longitude
          |                             |
          +--------------+--------------+
                         |
                         v
                    WORDPRESS
                         |
                         v
                   PUBLIC WEBSITE
                         |
                         v
                  GOOGLE MAPS
                         |
          +--------------+--------------+
          |                             |
          v                             v
       Marker                      Directions
```

---

# 52. Development Rules

1. Store Center locations as structured data.
2. Store latitude and longitude with each Center.
3. Validate coordinates.
4. Use Google Maps only where required.
5. Avoid loading Maps unnecessarily.
6. Provide textual location information.
7. Provide a directions action.
8. Keep Google credentials secure.
9. Restrict API keys.
10. Use Rashtrotthana-owned production credentials.
11. Separate development and production configuration.
12. Provide graceful fallback behavior.
13. Test responsive behavior.
14. Verify every Center location before launch.
