# EduResource Manager - initial architecture

## Folder structure

```text
config/                 Database and application configuration
auth/                   Authentication and authorization
services/               Database repositories and business operations
actions/                Short POST/GET form handlers
pages/                  Application pages
assets/css/             Stylesheets
assets/js/              JavaScript
docs/                   Technical and user documentation
tests/                  Test cases and acceptance tests
```

## Planned responsibilities

- `config/db.php` - PDO connection and session setup
- `auth/guard.php` - authentication and role checks
- `auth/login_action.php` - login processing
- `auth/logout.php` - logout processing
- `services/resource_repo.php` - resource CRUD
- `services/loan_repo.php` - issue and return operations
- `services/ticket_repo.php` - ticket operations
- `actions/*.php` - form validation and redirects
- `pages/*.php` - server-side data loading and HTML rendering
- `assets/css/style.css` - application styles
- `assets/js/app.js` - browser-side interaction

Existing root files are left unchanged during this architecture step.
