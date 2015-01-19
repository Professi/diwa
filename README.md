## diwa
DiWA is a Ding-based Web Application which is built on top of Yii2(>=PHP 5.4)
It's similar to dict.cc and dict.leo.org without community aspects. The main difference to them is, that the application code is free. It's intended to be used in a network without direct access to the internet(e.g. intranets). The language files shipped with this repository are provided by Frank Richter and Matthias Buchmeier(both GPL).
Actually only the import for "simple" text files works. (word1:word2 | word1a,word1b:word2 | word1a,word1b:word2a,word2b)
It's planned to implement import(maybe export) for TMX, dict, XDXF and TEI files.

This application is only tested with mysql and postgresql as DBMS. Other DBMS supported by Yii2 can also work, but I won't support them.
For caching you can use every by yii2 supported cache method(MemCache, FileCache, etc.).

See for more informations:
http://synlos.net/redmine/projects/diwa

You can checkout this demo:
http://synlos.net/diwa/

### Author
Christian Ehringfeld c.ehringfeld[at]t-online.de