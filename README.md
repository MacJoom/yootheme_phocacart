This is still in Beta stage... but already in use for a product catalog
- Done: Display Categories
- New feature: Translations in ./languages

Still to do: 
- <s>Category List</s>
- Documentation

# Yootheme PhocaCart Bridge

This is a bridge of [YooThemePro (YTP) Page Builder](https://yootheme.com/page-builder) with [PhocaCart](https://phoca.cz). It provides a front-end, 'drag and drop' layout builder for PhocaCart Entities, such as Products and Categories, which are loaded as Dynamic Content [custom sources](https://yootheme.com/support/yootheme-pro/joomla/developers-sources) into YTP. It uses PhocaCart API, and integrates with Dynamic Content features including filtering and sorting by field, filtering by category & image URLs.

It was originally developed by [Deepak Srivastava](https://github.com/deepak-srivastava/) of [Mountev](https://mountev.co.uk/), with the support of [Joshua Gowans](https://lab.civicrm.org/josh) and [Nicol](https://lab.civicrm.org/nicol) Wistreich ([Vingle](https://github.com/vingle)) for CiviCRM
and was adapted for PhocaCart by Martin Kopp (https://infotech.ch)

![](images/yootheme_phocacart.gif)

## Installation

1. Install YooThemePro template (Joomla!)

2. Install this Child template in the Joomla Template Directory - named yootheme_phocacart

3. Activate Child in Yootheme 

4. Follow YTP's [documentation for Dynamic Content](https://yootheme.com/support/yootheme-pro/joomla/dynamic-content), selecting the relevent PhocaCart entites as Custom Sources - Products only at the moment.

> **It is recommended to use this only on test/dev sites until you are comfortable with, and understand, how it works**

### Warning 

If you screw something up in the code - yootheme will not load anymore (no error, just a white screen), because the settings and config of fields are loaded right at the beginning. In this case just rename the template to something else (e.g. yootheme_phocacart to zzzyootheme_phocacart). Yootheme will load again with the child template deactivated.

