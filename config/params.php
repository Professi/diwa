<?php

return [
    'adminEmail' => 'admin@example.com',
    'websiteLink' => 'synlos.net',
    'altWebsiteLink' => 'Website of synlos.net',
    'languages' => ['English' => 'en_US', 'Deutsch' => 'de'],
    'imprintName' => 'Name',
    'imprintStreet' => 'Street',
    'imprintPlace' => '00000 Location',
    'imprintEmail' => 'yourname@yourdomain.de',
    'cacheTranslatedWords' => false, //if true it can reduce your db query calls per translation result by 2 but it can increase the cache size(maybe double/triple or more(e.g. 1500 translation results) of the "normal" size) for translation results 
];
