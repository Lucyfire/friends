Friends for Drupal 8
=================

Introduction
------------

The Friends module is an open social extension module that allows users to perform
friend requests (of one or more types) to other users.

One example use of Friends is user A sends a friend request to user B
user B receives a notification and Accepts or Declines the request
user A receives a notification depending on users B action.


Installation
------------

Friends 8.x is installed like any other Drupal 8 module and requires brief
configuration prior to use.

1. Download the module to your DRUPAL_ROOT/modules directory, or where ever you
install contrib modules on your site.
2. Go to Admin > Extend and enable the module.

Configuration
-------------

Configuration of Friends module involves creating one or more flags.

1. Go to Admin > Structure > Friends, and click "Manage Fields".
2. Request Type > Storage Settings and change the values to add or remove friend request types

You can do the same thing to status but the following three are required
- pending
- accept
- decline

Once you are done configuring head to a users page and you should see tab links
to add the user as the types you defined.
