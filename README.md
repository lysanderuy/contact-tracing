# CpE Contact Tracing

CpE Contact Tracing is the visitor management system for the Department of Computer Engineering - University of San Carlos, Talamban Campus, Cebu City. It tracks sign-ins and sign-outs for students, guests, visitors, staff, and faculty while maintaining complete visit records.

## What is CpE Contact Tracing?

CpE Contact Tracing provides a fast way for anyone (students, guests, visitors, staff, and faculty) to sign in and out of the CpE office. It gives admins real-time visibility into who is currently in the office and complete historical records of all visits.

### Core Principles

- **Fast sign-in for everyone.** Students, guests, staff, and faculty should all be able to sign in within seconds.
- **Inclusive tracking.** No one is left out - every visitor type is logged the same way.
- **Instant visibility.** Admins see who is currently inside at a glance.
- **Simple repeat visits.** Returning visitors are looked up by USC ID or contact number - no re-typing.
- **Complete audit trail.** Every sign-in and sign-out is recorded with timestamps.

### Who Should Use CpE Contact Tracing

- **Students.** Sign in when visiting the CpE office for consultations, labs, or inquiries.
- **Faculty and staff.** Track office presence and visitor interactions.
- **Guests and visitors.** External visitors without USC ID can sign in via guest entry.
- **Admins and front desk.** Monitor who is inside and maintain complete visit records.

### Key Features

- **Quick visitor lookup.** Find existing visitors by USC ID or contact number.
- **Guest entry.** Support for visitors without USC ID.
- **Registration flow.** Capture new visitor details with auto sign-in.
- **Sign in/out tracking.** Complete visit logs with timestamps.
- **Admin dashboard.** See who is currently inside plus all visit records.
- **Visitor detail view.** Full profile and complete visit history per visitor.
- **Single admin account.** Simple authentication for authorized access.

## Project Structure

```text
contact-tracing/
├── app/
│   ├── api/
│   │   ├── check_user.php
│   │   ├── register.php
│   │   └── sign_action.php
│   ├── includes/
│   │   ├── api_helpers.php
│   │   ├── footer.php
│   │   └── header.php
│   └── pages/
│       ├── admin_dashboard.php
│       ├── admin_login.php
│       ├── confirmation.php
│       ├── guest_entry.php
│       ├── home.php
│       ├── logout.php
│       ├── register.php
│       ├── verify.php
│       └── visitor_detail.php
├── config/
│   └── db.php
├── database/
│   └── schema.sql
├── public/
│   ├── css/
│   │   ├── admin.css
│   │   ├── admin_dashboard.css
│   │   ├── admin_login.css
│   │   ├── home.css
│   │   └── visitor_detail.css
│   ├── index.php
│   └── js/
│       ├── admin_dashboard.js
│       ├── confirmation.js
│       ├── guest_entry.js
│       ├── home.js
│       ├── register.js
│       ├── utils.js
│       ├── verify.js
│       └── visitor_detail.js
└── README.md
```

## Setup

1. Install XAMPP with Apache, MySQL, and PHP.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create the `contact_tracing` database.
4. Import `database/schema.sql`.
5. Update `config/db.php` if your local credentials differ.
6. Access the application:
   - Visitor side: http://localhost/contact-tracing/public/
   - Admin login: http://localhost/contact-tracing/public/?page=admin_login

## Questions?

For support or questions about CpE Contact Tracing, contact the CpE Office.
