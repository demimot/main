# DemiMot
## Intro
Demimot uses: 
- Smarty Template Engine - http://www.smarty.net
- Zurb Foundation responsive CSS - http://foundation.zurb.com/

How it's done:
- index.php - 'pré' front controller
- header.php - front controller
- css/pub_css.php - Load custom css from DB
- .htaccess - translate filename###.css into a call to pub_css.php?pub=###
- config/dmm_config.php - functions library and default donfiguration initialization vars
- smarty/templates/* - tempaltes to be rendered by smarty
- smarty/libs/plugins/* - tempalte functions
## Issues

1. Migrate to Symfony - Twig, etc?
2. Remove data retrieving from template functions - must be handled by controllers
3. define article object - article sections and componnents
4. article components blocks, order, priority, mandatory... etc
5. define article pubs relationships

## Code
```php
 $example = 3 + 2;
```
