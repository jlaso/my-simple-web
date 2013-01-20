Translation Notes
=================

Pf4wp is POEdit friendly. MO files should be located in the plugin's `/resources/l10n` directroy, stored as `locale + .mo`, for example `en-US.mo`. They will be automatically loaded by Pf4wp, based on the current locale and availability.

Using POEdit and Twig templates
-------------------------------

By default, POEdit does not have the ability to import Twig templates. This can be resolved by adding an additional parser (_Edit -> Preferences -> Parsers_) with the following options:

- Language: `Twig`
- List of extensions: `*.twig`
- Invocation:
    - Parser command: `xgettext --force-po -LPython -o %o %C %K %F`
    - An item in keyword list: `-k%k`
    - An item in input file list: `%f`
    - Source code charset: `--from-code=%c`

Then as keywords you need to use `__` (double underscore).

Pf4wp offers both a Twig filter and Twig function for translations. 

The function is called using the double underscore as following:

    {{ __('Hello World') }}

The filter, called `trans` can be used as following:

    {{ 'Hello World' | trans }}

The drawback of using the filter is that it will not be picked up by POEdit as a translatable string. It is possible to use the view cache instead, usually stored in `store/cache/views`, and to use the keyword `transFilter`.

