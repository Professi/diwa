## INSTALL

First download the application as a registered user (http://synlos.net/redmine/projects/diwa/repository) or download it from github(https://github.com/Professi/diwa).
Unpack it and move it to the web-path of your webserver.
After that you should copy the following files and remove the ".example" suffix:
src/config/db.php.example
src/config/mailer.php.example
src/config/params.php.example

In db.php you should edit the 'dsn', 'username', and 'password' specific to your database setup. For more informations you can visit: http://www.yiiframework.com/doc-2.0/guide-start-databases.html and Configuring a DB Connection.
In mailer.php you can define a mailer component. Actually I didn't tested the mailer component.
In params.php you can define some application variables, like the e-mail adress of the administrator or your website link.

After that you should also edit the web.php file.
- You MUST change the 'cookieValidationKey' to a secret key.
- If you want use any other caching component than FileCache you can change the 'cache' array. You can use the by Yii2 supported caching methods. See http://www.yiiframework.com/doc-2.0/guide-caching-data.html
- If you want pretty urls you can change the 'urlManager' array.
- You can also change the 'language' to 'en' or 'de'.

You can check out the requirements with http://path/to/your/site/diwa/requirements.php
You can invoke the site with http://path/to/your/site/diwa/web/index.php or make alternatively a soft link to src/web/index.php and invoke it without /web/ in url path.

### Use the provided dictionaries

Open your web browser and navigate to the URL to which you uploaded DiWA. Then open the menu and navigate to "Login" form. The initial credential is "admin":"admin".
After login you should navigate to menu point "Languages". Now click on "Create Language" and create for example German and English with the provided form.
Next you should navigate to "Dictionaries" and Create a Dictionary. Now you can create a dictionary(If you want use the language file "de-en.txt" of the resource folder, I recommend that you set German as the first language of the dictionary and english as the second one).
After the creation of a dictionary you should see the created dictionary in the overview. Then you can click on "Import translation file". Choose the dictionary, the delimiters and the file. If you use the translation/text file provided by Frank Richter(de-en.txt) you mustn't change the Delimiters. Choose a file and click Import. Depending on your machine this can take really long(you shouldn't do this on a raspberry).
After the upload of the "de-en.txt" should ~1.3 million data sets exist in your database with a size of ~140 MB.

Now you can use the search of DiWA.




