---
layout: index
title: Something with codes
---

ToolPhar is a new idea to install your development tools such as PHPUnit.
 You can just add a few lines to your composer.json, and composer will automatically download the phar to your *vendor/bin* folder.

## How?
You just have to add the toolphar repository to your composer json and then you can easily install development tools such as PHPUnit.
See the following composer.json and what it does below.
{% highlight json %}
{
    "name": "hco/composer-phar-installer-test",
    "require": {
        "toolphar/phpunit": "3.7.37"
    },
    "repositories": [
        {
            "type": "composer",
            "url": "http://toolphar.org/"
        }
    ]
}
{% endhighlight %}


<div class="shell">
<span style="color:white;">$ composer update</span><br>
<span style="color:green;">
Loading composer repositories with package information<br>
Installing dependencies (including require-dev) from lock file<br>
</span>
&nbsp;&nbsp;- Installing <span style="color:green;">hco/phar-installer-plugin</span> (<span style="color:olive;">0.1.0</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;Downloading: <span style="color:olive;">100%</span><br>
<br>
&nbsp;&nbsp;- Installing <span style="color:green;">toolphar/phpunit</span> (<span style="color:olive;">3.7.37</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;Downloading: <span style="color:olive;">100%</span><br>
<span style="color:green;">Generating autoload files</span><br><br>
<span style="color:white;">$ ./vendor/bin/phpunit --version<br>
PHPUnit 3.7.37 by Sebastian Bergmann.
</span>
</div>


I uploaded a simple sample project to [https://github.com/hco/composer-phar-installer-test](https://github.com/hco/composer-phar-installer-test) - you can easily try it out there.

## Why?

Why is this necessary?
Well, currently there are several ways on how to install phpunit:

1. download the phar manually
1. include it as a regular (dev-)dependency in your composer.json
1. use a tool like ant, phing, …

At least from my point of view none of these ways is perfect. I'm gonna explain why.


### Downloading the phars manually
This way makes getting started more complicated for new developers.
In addition, your developers will most likely have different versions of the tools,
which is something I would strongly discourage, because it helps the well known ["works for me"](http://www.urbandictionary.com/define.php?term=works+for+me) issue.

### Include as a regular dependency in your composer.json
This is something i've see quite often - people add their development tools to their composer.json, as a *require-dev* dependency.
Most people install their require-dev dependencies in development, testing and maybe even staging, but not in production.

Why is this bad? Well, for instance phpunit depends on *symfony/yaml*. This means that *symfony/yaml* is available in your development environment,
which means that your IDE will suggest you to use it, if you ever come in need of a yaml parser.
The tests on your continuous integration server will work as well (because you install your *require-dev*s here),
but as you do not install dev dependencies on your production servers, *symfony/yaml* will be missing there,
which might break your live site. Boom.

 A way to work around this would be to list your development tools as non-dev dependencies (or install your development requirements on production).
But this comes with an issue as well: If you also happen to use phpmd, and phpmd *would* start depending on *symfony/yaml* in a new version of 3.0,
these tools would have conflicting dependencies - even though they would perfectly work if you install them as separate phars.

Or to give you another example: Imagine you want to use phpmd, which depends upon *symfony/dependency-injection* 2.5,
but your application is only working with *symfony/dependency-injection* 2.1, you would not be able to install phpmd using composer.

### Use a tool like ant, phing, …
Yep, that's completely fine (if done right - keep in mind, you all want to use the same versions of your tools!).
I know several people who do this. I just don't want to install phpunit using these tools,
and prefer to do it with composer.


## How ToolPhar helps
ToolPhar only downloads the PHARs of the tools.
This will make them not conflict with your dependencies, with some exceptions - you can still conflict with phpunits dependencies, but it will be fine with several other tools.
The issue with PHPUnit is that PHPUnit *runs* your code in the same context that PHPUnit runs in, and you cannot redeclare a class that PHPUnit already included.
I think this cannot be avoided :(

You might want to exclude the *vendor/bin/* directory from your IDE, so that it does not include the contents of the PHARs in it's code completion.

## Which tools are available?
Not many - this is kind of a "proof of concept".
I'll add more as soon as I get the feedback, that anyone else would like something like this.

- [PHPMD](http://phpmd.org/)
- [PHPUnit](https://phpunit.de/)
- [PHP_Depend](http://pdepend.org/)
- [phpab](http://phpab.net)
- [PHPLOC](https://github.com/sebastianbergmann/phploc)
- [PHPCPD](https://github.com/sebastianbergmann/phpcpd)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/)

See http://toolphar.org/packages.json (and the linked .json files) for the whole list of versions.


## What's the state of ToolPhar?
I created the installer in one night - it's not the best code I ever wrote, but it works for me.
Currently only a small amount of tools is supported, and I have to maintain the repository of packages in github.
I would like to figure out if this project makes sense to others as well, and in that case I will try to improve the ecosystem.

If you want a tool added, just create a [issue on github](https://github.com/toolphar/toolphar/issues), with a link to the list of phars.

If you are the maintainer of a tool that you want to be added, get in touch - we'll find a (hopefully simple) way on how you can add them on your own.

If you are the maintainer of a tool that I added to the toolphar repository but you don't want me to, please get in touch via <toolphar.org@muh-die-kuh.de>.
I hope we can work this out together.

There might be bugs. Please let me know if you find one.
