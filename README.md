# Materialize & PHP Admin Panel Template
---
A template for an admin panel built with PHP and Materialize. The template comes with Google Analytics and Uptime Robot APIs built in, but still requires a database connection for the login system and user management system.

## Features
---
- Google Analytics API for Analytics
- Uptime Robot API for Site Status Monitoring
- Pre-built template for user management

## Getting Started
---
### 1. Get Google Analytics Credentials
In order for the template to work, a file needs to be present in the root of the template files. This file is called `client_secrects.json`. This file can be found by doing the following:
1. Go to this page: https://console.developers.google.com/apis/credentials
2. Click Create credentials and select OAuth client ID
3. For the Application type select Web application
4. Name the client ID whatever you like and click Create
5. Leave the Authorized JavaScript origins blank
6. Set the Authorized redirect URIs to http://yourdomain.tld/path/to/oauth2callback.php
7. Click Create
8. On the Credentials page click the newly created client ID, click Download JSON and save it as `client_secrets.json` in the root of the template files

### 2. Get Uptime Robot Credentials
In order to access status updates from uptime robot an API Key is needed. This can be found by doing the following:
1. Log into your uptime robot account
2. Click my settings and find where it says Read-Only API Key (Must be read-only because the key will be exposed in the Javascript)
3. Copy the API Key and paste it into the config.php file where it says `$uptimeKey`

### 3. Find your Google Analytics ViewID
1. Go to google analytics and click on Admin
2. Under view click on view settings and at the top it should say view id
3. Copy this number and in the config.php file past it where it says `$analyticsViewID` in the second quotation marks after the `ga:`. If you get an error make sure `$analyticsViewID` is equal to `ga:YOURID`

### 4. Fill out the other values in the config.php file
1. Add your twitter handle - if you don't want to show a twitter feed, go to the index.php file and delete the div with the class twitterFeed.
2. Add a link to an RSS feed you want to show- if you don't want to show a RSS feed, go to the index.php file and delete the div with the class rssFeed.

### 5. Add the PHP to connect the admin panel to your database
1. The login.php and logout.php pages need to connect the the database
2. Each page needs a check at the beginning to see if the user is logged in or not