Feed Reader Application
============================

A PHP web application can read multiple rss feeds and store them to database. Moreover, it allows user manipulate both feeds and their items. The project include two type of communication, console and web application.

Sample feeds http://www.feedforall.com/sample-feeds.htm. 

Some technicals applied to this project:
- CSRF Token
- Validation
- Pagination
- HTML encode and purifier.
- PJAX
- WYSIWYG
- Bootstrap
- Date picker
- Select2
- Packages management
- Automation build
- Code standard PSR1, PSR2

REQUIREMENTS
------------
- Apache 2.2 or later
- PHP 5.4.0 or later
- MySQL 5.5 or later
- Composer 1.1.2 or later

CONFIGURATION
-------------
Modify file `build-default.properties` with your environment data.

### Environment

    app.env=prod

### Database

    app.db.driver=mysql
    app.db.host=localhost
    app.db.user=root
    app.db.password=root
    app.db.name=feeds_reader

### Log file path

    app.log.path=${project.basedir}/runtime/logs/console.log

INSTALLATION
------------
### Automation
1. You only need to run install file follow command in project root directory

        $./install

2. The project is installed successful if you can see this message.

        BUILD FINISHED

### Semi-Automation
1. You need install project packages dependency by run command in project root directory

        $composer install

2. You can start build with phing in project root directory.

        $vendor/phing/phing/bin/phing

3. If error occurs during building process, you may want to try to run build command with root permission.

        $sudo vendor/phing/phing/bin/phing

4. The project is installed successful if you can see this message.

        BUILD FINISHED

USAGE
-----
### As a developer

You can add multiple feeds by run the command in root directory of project.

    $./yii feed/add "url_1, url_2"

You can monitor any console message response in log file. Ex.

    ${project.basedir}/runtime/logs/console.log
### As a user

You can access website by route

    http://localhost/feeds-reader/src/web/

In addtion, you also can:

    - Subscribe multiple feeds
    - Unsubscribe a feed
    - View a list of feeds with 10 items per page.
    - Mannually create a feed item
    - Update a feed item
    - Delete a feed item
    - Filter feeds by category

CREDIT
------
The project is powered by **Yii2 frameworks**.

    http://www.yiiframework.com/

In addition, it also used some packages from:

    yii2-ajaxcrud: https://github.com/johnitvn/yii2-ajaxcrud
    yii2-redactor: https://github.com/yiidoc/yii2-redactor
    kartik-select2: https://github.com/kartik-v/yii2-widget-select2
    kartik-datepicker: https://github.com/kartik-v/yii2-widget-datepicker
    phing: https://github.com/phingofficial/phing

AUTHOR
------
Tuan Vu tuanvu.se@gmail.com
