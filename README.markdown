xBoilerplate
==================================

xBoilerplate was built to kickstart the development of small dynamic webpages. It can also be used to design
websites or web applications directly in CSS3. xBoilerplate is inspired by [HTML5 Boilerplate](http://html5boilerplate.com/)
and lots of code is copied from HTML5 Boilerplate. The main difference is that xBoilerplate allows dynamic pages
with PHP and includes dynamic libraries like lessphp.

The goal of xBoilerplate is to be simple and to keep it simple. Even though it could be enhanced with more objects
and functionality, this is not the goal. It should offer a simple solution to start with a dynamic project.


Getting Started
---------------
To get you started as fast as possible, xBoilerplate uses Vagrant. The only thing you have to do to setup
the project and have it running in Apache is to execute vagrant up. Sure, you have to
[install vagrant](http://vagrantup.com/docs/getting-started/index.html) first.


Documentation
-------------
xBoilerplate allows a maximum navigation level is 2. All urls are in the form `/category/page`. All content for the
pages is stored in `httpdocs/content`. The default category and page is index, so if you access `/`, the file
`httpdocs/content/index/index.php` is opened. If you call the url `/contact`, the file `httpdocs/content/contact/index.php`
is opened. For the page `/about/team`, it's `httpdocs/content/contact/team.php`.

The basic template around every page is in `httpdocs/layout/template.php`. This file loads the default `header.php` and
`footer.php` which already has the basic content needed. To create your own template, overwrite the code in template.php
but keep the loadLayout for header and footer and the loadPage command.



Changes
-------
For changes in the API please check the file [changes.txt](https://github.com/ruflin/xBoilerplate/blob/master/changes.txt)
