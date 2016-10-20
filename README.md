# CSV4Twig
## CSV escaping filter for the Twig templating engine

[![Build Status](https://travis-ci.org/mbaynton/csv4twig.svg?branch=master)](https://travis-ci.org/mbaynton/csv4twig)

CSV4Twig enables Twig templates to generate safe, properly-escaped
CSV output. It's useful when you need to get CSV reports out of an 
existing application that has a Twig-enabled output layer.

### Usage
1. Add it to your project with composer:  
   `composer require mbaynton/csv4twig:1.0.*`
2. Tell Twig about it. You'll need to get a hold of the
   `\Twig_Environment` instance that will generate the CSV; then
   just pass it to `\mbaynton\CSV4Twig\Filter::registerFilters()`.
3. Use it in your template with the autoescape tag:

       {% autoescape "csv" %}
       {{ some_value }},{{ another_value }}
       {% endautoescape %}
   The contents of `some_value` and `another_value` will be
   escaped using the default CSV-escaping conventions
   of PHP's `fputcsv()` function. `fputcsv()` is the function this
   filter uses internally.
   
   If you prefer, you can also escape certain values explicitly:
   
       {% autoescape false %}
       {{ some_value|e("csv") }},{{ another_value }}
       {% endautoescape %}
   
That's it!
