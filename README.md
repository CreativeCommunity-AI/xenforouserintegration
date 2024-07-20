# XenForo User Integration

This plugin syncs the XenForo userbase with Craft CMS, allowing users to log in using their XenForo credentials.

## Installation

To install the plugin, follow these steps:

1. Download the plugin files.
2. Place the files in `craft/plugins/xenforouserintegration`.
3. Run `composer require creativecommunityai/xenforouserintegration`.
4. Enable the plugin in the Craft CMS control panel.

## Configuration

Configure the plugin by setting the following options in the Craft CMS control panel:

- Database Host
- Database Name
- Database Username
- Database Password

## Using XenForo Authentication in Twig Templates

The `XenForoUserIntegration` plugin allows you to authenticate users using their XenForo credentials and manage members-only areas on your Craft CMS site. This guide will walk you through setting up the login form and restricting access to authenticated users in your Twig templates.

### Setup

1. **Install the Plugin**:
   Ensure the `XenForoUserIntegration` plugin is installed and enabled in your Craft CMS control panel.

2. **Configure Database Settings**:
   Go to the plugin settings page and configure the XenForo database connection settings (Database Host, Database Name, Database Username, Database Password).

### Creating the Login Form

Create a Twig template for the login form where users can enter their XenForo credentials.

#### `templates/login.twig`

```twig
{% extends "_layouts/base" %}

{% block content %}
    <h1>{{ "XenForo Login" | t }}</h1>

    {% if craft.app.session.hasFlash('error') %}
        <div class="error">{{ craft.app.session.getFlash('error') }}</div>
    {% endif %}

    <form method="post" action="{{ url('actions/xenforouserintegration/auth/login') }}">
        {{ csrfInput() }}

        <div class="field">
            <label for="username">{{ "Username" | t }}</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="field">
            <label for="password">{{ "Password" | t }}</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="buttons">
            <button type="submit" class="btn submit">{{ "Login" | t }}</button>
        </div>
    </form>
{% endblock %}
```

### Restricting Access to Authenticated Users

You can restrict access to members-only areas by checking the user’s authentication status in your Twig templates.

Example file path: `templates/members-area.twig`

```twig
{% extends "_layouts/base" %}

{% block content %}
    <h1>{{ "Welcome to Another Page" | t }}</h1>

    {% if currentUser %}
        <p>{{ "Authenticated users see this content and enjoy no ads." | t }}</p>
        <!-- Additional member-only content and perks here -->
    {% else %}
        <p>{{ "You must be logged in to see exclusive content and remove ads." | t }}</p>
        <a href="{{ url('login', {redirect: craft.app.request.url}) }}">{{ "Login" | t }}</a>
    {% endif %}

    <div class="general-content">
        <p>{{ "This content is visible to all users." | t }}</p>
        <!-- General content here -->
    </div>
{% endblock %}
```

### Customizing the Login Process

1.	Handling Login Errors:
      Ensure that login errors are properly displayed to the user.
        ```twig
        {% if craft.app.session.hasFlash('error') %}
        <div class="error">{{ craft.app.session.getFlash('error') }}</div>
        {% endif %}
        ```
2. Redirecting After Login:
        After a successful login, you can redirect the user to a specific page.
            ```twig
            {% set redirectUrl = url('members-area') %}
            <input type="hidden" name="redirect" value="{{ redirectUrl }}">
            ```

### Using XenForo Authentication through GraphQL

The XenForoUserIntegration plugin also supports authentication through GraphQL. This allows you to authenticate users using their XenForo credentials via GraphQL mutations.

#### Setting Up GraphQL

Ensure that your Craft CMS site has a GraphQL endpoint configured and the XenForoUserIntegration plugin is installed and configured.

#### GraphQL Mutation for Login

Use the following GraphQL mutation to authenticate a user with their XenForo credentials:

```graphql
   mutation {
    login(username: "testuser", password: "testpassword")
   }
``` 

### Summary

By following these instructions, you can set up XenForo authentication for your Craft CMS site using both Twig templates and GraphQL. Here’s a summary of the steps:

1.	Install and configure the XenForoUserIntegration plugin.
2.  Create a login form using a Twig template.
3.	Handle login requests via the provided controller.
4.	Restrict access to members-only areas by checking the user’s authentication status.
5.	Use the provided GraphQL mutation to authenticate users with XenForo credentials.

#### Additional Notes
- Ensure that your `_layouts/base.twig` template contains the necessary structure and styling to accommodate the login and members-area templates.
- Customize the redirect URL and error handling as needed to fit your site’s requirements.
- Refer to the plugin’s settings or consult the Craft CMS documentation for further customization and troubleshooting.