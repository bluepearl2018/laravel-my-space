# Laravel My Space
Where frontend users manage their account

## Introduction
This package allows front-end users - that is, those who have registered 
from the front-end or public site - to manage their account, as well as some 
common data such as contact information and social media.

In view of the general data protection regulations (GDPR), 
users must be able to request the deletion of their account and a copy of 
their personal data. This package therefore provides this possibility.

## Support us
More soon.

## Pre-requisites
### Laravel Version
This package requires Laravel 9 or higher. 

All Eutranet's core packages (but eutranet's laravel frontend) should be installed.

### Config file
This package publishes the eutranet-my-space config file.

## Installation in Laravel
This package can be used with Laravel 9.0 or higher.

### Installing
1. Have a look at the prerequisites section.
2. Installation command is php artisan eutranet:install-my-space
3. Access the demo account ('demo@demo.com', 'Password')
4. Publish package resources and config (php artisan vendor:publish --provider="Eutranet\MySpace\MySpaceServiceProvider"
5. Optimize (php artisan optimize)
6. Log in as super admin and check the installation

## Questions and issues
A bug? Problems with the package? Questions or suggestions? Tell us on GitHub.

## Changelog
All notable changes are documented on GitHub.

# For frontend users
My Space is the front-end users' workspace. This is where they 
manage personal info, as well as social medias. Overview options 
are made accessible from the dashboard page.

# For staff members
Staff members should never access My Space: it's the 
front-end users' workspace - and nobody else's.
Nevertheless, the backend users - the team members - are 
able to manage, filter... new registrations, etcetera.

# For administrators 
Administrators can check My Space installation status from 
their dashboard.
