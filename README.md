## diwa
DiWA is a Ding-based Web Application
It's similar to dict.cc and dict.leo.org without community aspects. The main difference to them is, that the application code is free. It's intended to be used in a network without direct access to the internet(e.g. intranets). The language files shipped with this repository are provided by Frank Richter and Matthias Buchmeier(both GPL).
Actually only import for "simple" text files works. (word1:word2 | word1a,word1b:word2 | word1a,word1b:word2a,word2b)
It's planned to implement import(maybe export) for TMX, dict, XDXF and TEI files.

This application supports mysql and postgresql for storing data.
For caching you can use every by yii2 supported cache method(MemCache, FileCache, etc.).

See for more informations:
http://synlos.net/redmine/projects/diwa
