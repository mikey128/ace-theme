## Overview

Implement a custom frontend user module that uses WordPress core authentication and Tailwind UI, without wp-login screens or plugins. Carbon Fields is used only for options and extra user meta.

## Files & Structure

* inc/auth.php: Core hooks, access control, handlers, helpers (redirects, validation, nonces)

* inc/carbon-fields/user-fields.php: Theme options (enable registration, custom redirects) + extra user meta fields (company, telephone, address)

* template-parts/user/login-form.php: Tailwind login form (nonce, errors)

* template-parts/user/register-form.php: Tailwind registration form (nonce, field-level errors)

* template-parts/user/account.php: Protected account page (basic profile summary, optional meta update form)

* page-login.php: Page template rendering login-form.php

* page-register.php: Page template rendering register-form.php

* page-account.php: Page template rendering account.php

* header.php: Replace “Sign in/Sign up” with user dropdown when logged-in (username/avatar, Account, Logout)

* assets/js/user-menu.js: Small JS for dropdown toggle and click-away

## Theme Options (Carbon Fields)

* enable\_frontend\_registration (checkbox)

* redirect\_login\_success (text/url)

* redirect\_register\_success (text/url)

* redirect\_logout (text/url)

## Extra User Meta (Carbon Fields backend)

* company (text)

* telephone (text)

* address (textarea)

## Routing & Page Setup

* Create pages in WP admin: /login, /register, /account; assign corresponding templates.

* Access control via template\_redirect:

  * If logged-in visiting /login or /register → redirect to /account (or custom option)

  * If guest visiting /account → redirect to /login

## Header UI Logic

* is\_user\_logged\_in() decides rendering.

* Guest: show Sign in (/login) and Sign up (/register)

* Logged-in: show avatar (get\_avatar) or username, dropdown with Account + Logout.

* Logout link posts to custom endpoint with nonce (no wp-login screen).

## Login Flow

* Form: username/email, password, remember; nonce.

* POST target: admin-post.php action=ace\_login (nopriv and priv handlers).

* Handler:

  * Validate nonce, sanitize inputs.

  * Support email-as-username: if email given, resolve to username via get\_user\_by('email').

  * Call wp\_signon(\['user\_login','user\_password','remember']).

  * On success: WordPress sets auth cookie; redirect priority: valid redirect\_to param → theme option redirect\_login\_success → /account → home.

  * On failure: redirect back to /login with error code in query string; form reads and displays inline error.

## Registration Flow

* Respect setting: users\_can\_register() OR Carbon Fields enable\_frontend\_registration must be true; otherwise show a friendly disabled message.

* Form: username, email, password, optional company/telephone/address; nonce.

* POST target: admin-post.php action=ace\_register (nopriv handler).

* Handler:

  * Validate nonce, sanitize, validate uniqueness (username\_exists/email\_exists), enforce password length.

  * Create user via wp\_insert\_user (role = subscriber).

  * Save extra meta via update\_user\_meta.

  * Auto-login: wp\_set\_current\_user + wp\_set\_auth\_cookie.

  * Redirect priority: theme option redirect\_register\_success → /account.

  * On failure: redirect back to /register with field errors encoded; form shows per-field errors.

## Logout Flow

* Link submits to admin-post.php action=ace\_logout with nonce (both priv/nopriv); handler calls wp\_logout(); redirect to option redirect\_logout or home/login.

## Access Control & Security

* Nonces on all forms; verify with check\_admin\_referer or wp\_verify\_nonce.

* Sanitize inputs with sanitize\_text\_field/sanitize\_user/sanitize\_email.

* Validate redirect\_to via wp\_validate\_redirect; fallback to safe URLs.

* Block non-admins from wp-admin: admin\_init → if is\_admin() && !current\_user\_can('manage\_options') && !DOING\_AJAX → redirect to home.

* Prevent logged-in users accessing /login and /register using template\_redirect.

## UI Rendering (Tailwind)

* Mobile-first semantics; simple form components with accessible labels, errors under fields.

* Header dropdown: button with avatar/username → menu with Account/Logout; focus management handled by small JS.

## Implementation Details

* Helpers (inc/auth.php):

  * ace\_user\_url($slug): gets page URL by path or by option; no hard-coded URLs.

  * ace\_redirect($url): wp\_safe\_redirect and exit.

  * ace\_errors\_from\_query(): utility to decode and show messages.

  * ace\_get\_login\_redirect($request): resolve redirect priority chain.

* Handlers (admin\_post):

  * admin\_post\_nopriv\_ace\_login / admin\_post\_ace\_login

  * admin\_post\_nopriv\_ace\_register

  * admin\_post\_ace\_logout / admin\_post\_nopriv\_ace\_logout

* Templates render forms and messages; form actions point to admin-post with nonces.

## Minimal JS

* assets/js/user-menu.js: toggles dropdown, closes on outside click, ESC key.

## After Plan Approval

* Add Carbon Fields containers for options and user meta.

* Create PHP templates and auth handlers; wire template\_redirect and admin\_post hooks.

* Insert header UI logic and enqueue user-menu.js.

* Create /login, /register, /account pages and assign templates.

* Test flows: guest login/register, logged-in redirects, logout, header UI, account protection.

