# Carrington Theme for WordPress
http://carringtontheme.com

by Crowd Favorite  
http://crowdfavorite.com

Released under the GPL license  
http://www.opensource.org/licenses/gpl-license.php

---

## What is Carrington?

1. An elegant, high-end WordPress theme for end-users.
2. A developer friendly theme and conventions-based templating system.
3. A set of best practices for theme organization.

## Basic Theme Concept

Carrington is an attempt to better abstract WordPress theme organization, and simplify commonly needed theme functionality.

Theme functionality is broken up into thoughtfully crafted abstractions to enable customizations at different levels (the loop, the post/page content, comments, etc.) and a context-aware hierarchical template override system that chooses which template to be used for each segment of the theme.

The abstractions and supported template types are designed to easily handle most of the customization scenarios we commonly see.

## Theme Organization

WordPress themes generally have a file structure similar to this:

- 404.php
- archive.php
- archives.php
- [...]
- sidebar.php
- single.php
- style.css

While this organization works well in many instances, it doesn't well support the concept of atomic elements that are combined to create a theme. For example, a representation of just a post's content, or just a comment, is not represented here.

Carrington respects the supported WordPress file naming conventions (for example `get_header()` will still work), but eschews them in favor of an organizational structure that better suits the abstraction and customization commonly needed for a WordPress theme.

Template files are layered into each other using the following basic approach:

1. top level templates that include
2. common elements like a header, footer and sidebar along with a
3. loop that includes 
4. atomic post/page content or excerpt templates and, where appropriate, a
5. comments area template that includes 
6. atomic template for comments and a 
7. template for the comment form

### Context

WordPress provides a number of functions to help you determine what type of view a theme is showing. These include:

- `is_home()`
- `is_single()`
- `is_page()`
- `is_archive()`
- `in_category()`
- etc.

Carrington abstracts these to deduce a "context" for a particular page.

### Template Override System

At each level, templates are chosen based on a built-in context override system that uses simple file naming conventions to provide default functionality that allows for easy display customization based on various criteria.

For a given directory, a variety of options are available. These vary slightly at each level - here are a couple of examples.

#### posts/

This directory holds the top level templates for pages that show multiple posts. This includes the home page, date archives, category archives, author archives, search results, etc.

Supported filenames:

- *posts-default.php* (default.php also supported) - used if no other templates are available or match for the current context.
- *author.php* - used for author archive pages
- *author-{username}.php* - used for author archive pages for the "username" user
- *category.php* - used for category archive pages
- *cat-{example}.php* - used for category archive pages for the "example" category
- *tag.php* - used for tag archive pages
- *tag-{example}.php* - used for tag archive pages for the "example" tag
- *search.php* - used for search results pages
- *single.php* - used for a "single post" page
- *home.php* - used for the home page

#### content/

This directory holds the templates used for displaying atomic post content.

Supported filenames:

- *content-default.php* (default.php also supported) - Used when there are no other templates that match for a given post/page.
- *author-{username}.php* - Used when a user with that username authors a post/page. For example, a template with a file name of _author-jsmith.php_ would be used for a poat/page by user _jsmith_. Any WordPres username can take the place of {username} in the file name.
- *meta-{key}-{value}.php* - Used when there is a custom field for the post/page matching the key and value listed in the file name. This is useful if you want to be able to flag posts as "featured" or similar, and give those posts some custom treatment. In this example, you could add a custom field of "featured" with a value of "yes" to a post/page and it would use a template of _meta-featured-yes.php_ if that template exists.
- *cat-{slug}.php* - Used when a post is in a given category. The category is matched by the "slug" - for example a post in category "General" (with a category slug of "general") could use a template of _cat-general.php_.
- *role-{role}.php* - Used when a post/page is authored by a user with a particular role. The {role} is an all lowercase representation of the role string - for example, an author with an "Administrator" role might use a template of _role-administrator.php_. This is primarily useful if you have a set of authors that are given a Contributor role; or a Guest Columnist role or similar. Any WordPress role can take the place of {role} in the file name.
- *tag-{slug}.php* - Used when a post has a certain tag applied to it. The tag is matched by the "slug" - for example a post with tag "Reference" (with a category slug of "reference") could use a template of _tag-reference.php_.
- *parent-{slug}.php* - Used when a page is a sub-page of a certain page. The page is matched by the "slug" - for example a sub-page of a parent page with a slug of "knowledge-base" could use a template of _parent-knowledge-base.php_.
- *author.php* - Used when the content is being displayed on an "author" page (a page listing posts by author).
- *category.php* - Used when the content is being displayed on a "category" page (a page listing posts by category).
- *tag.php* - Used when the content is being displayed on an "tag" page (a page listing posts by tags).
- *page.php* - Used when the content is being displayed is a page (not a post).
- *single.php* - Used when the content is being displayed on an "single" page (a page showing only one post).
- *search.php* - Used when the content is being displayed are search results (a page listing posts matching a user search).
- *home.php* - Used when the page being displayed is the home page.

As you can see, this is a little more complex than the template options in Kubrick - the WordPress default theme. However all of these named templates are optional. Carrington includes primarily "default.php" options and enables you to create your own additional templates as needed.

Note: "default.php" is a supported default file name for all directories, however we have found in real world usage that {dirname}-default.php is a preferable naming system. When you have a half-dozen "defaultphp" files open in your favorite text editor, telling them apart in the file list can be more difficult than it should be.

## Actions and Filters

Because Carrington is as much a theme framework as a theme itself, it includes a core set of functions that enable the override template hierarchy. These functions include actions and filters where appropriate so that their functionality can be customized and overridden as needed. Thess actions and filters use the same hook and filter system used in the WordPress core.

- `cfct_settings_form` (action) - allows you to add your own fields to the Carrington Settings form.
- `cfct_settings_form_after` (action) - allows you to add your content after the Carrington Settings form. Useful if you want to add a second form to the page, or some other content.
- `cfct_update_settings` (action) - allows you to take action when the Carrington settings are being saved (perhaps to also save fields you've added in the `cfct_settings_form` action).
- `cfct_context` (filter) - allows you to apply filters to the return value of the `cfct_context()` function; the function that checks to see what posts file, loop file, etc. to show.
- `cfct_comment` (filter) - allows you to change which comment template is used.
- `cfct_filename` (filter) - filter the output of the `cfct_filename()` function.
- `cfct_general_match_order` (filter) - set the order in which general templates are chosen (make it check for a cat-general template ahead of a cat-news template, etc.).
- `cfct_choose_general_template` (filter) - filter the output of the `cfct_choose_general_template()` function.
- `cfct_content_match_order` (filter) - set the order in which content templates are chosen (make it check for author templates ahead of meta template, etc.).
- `cfct_choose_content_template` (filter) - filter the output of the `cfct_choose_content_template()` function.
- `cfct_comment_match_order` (filter) - set the order in which content templates are chosen (make it check for role templates ahead of user templates, etc.).
- `cfct_choose_comment_template` (filter) - filter the output of the `cfct_choose_comment_template()` function.
- `cfct_meta_templates` (filter) - filter the return value of the `cfct_meta_templates()` function.
- `cfct_cat_templates` (filter) - filter the return value of the `cfct_cat_templates()` function.
- `cfct_tag_templates` (filter) - filter the return value of the `cfct_tag_templates()` function.
- `cfct_author_templates` (filter) - filter the return value of the `cfct_author_templates()` function.
- `cfct_role_templates` (filter) - filter the return value of the `cfct_role_templates()` function.
- `cfct_comment_templates` (filter) - filter the return value of the `cfct_comment_templates()` function.

## Plugins

Any .php files in the *plugins/* directory will be automatically loaded by Carrington. This is a great way to bundle in custom functions or to hook into Carrington's actions or filters.

---

## Tips

There is extra processing associated with the file system and context checks that Carrington requires. Because of this, use of a caching plugin is recommended.

## Misc.

Thanks to Scott Allan Wallick and the excellent Sandbox theme for code and inspiration.

