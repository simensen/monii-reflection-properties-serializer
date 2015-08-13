Reflection Properties Serializer
================================

A simple serializer that is completely controlled by PSR-5 `@var` typehints.

[![Latest Stable Version](https://poser.pugx.org/monii/reflection-properties-serializer/v/stable)](https://packagist.org/packages/monii/reflection-properties-serializer)
[![Total Downloads](https://poser.pugx.org/monii/reflection-properties-serializer/downloads)](https://packagist.org/packages/monii/reflection-properties-serializer)
[![Latest Unstable Version](https://poser.pugx.org/monii/reflection-properties-serializer/v/unstable)](https://packagist.org/packages/monii/reflection-properties-serializer)
[![License](https://poser.pugx.org/monii/reflection-properties-serializer/license)](https://packagist.org/packages/monii/reflection-properties-serializer)
<br>
[![Build Status](https://travis-ci.org/monii/monii-reflection-properties-serializer.svg?branch=master)](https://travis-ci.org/monii/monii-reflection-properties-serializer)


Requirements
------------

 * PHP 5.5+


Installation
------------

```bash
$> composer require monii/reflection-properties-serializer
```

Until a stable version has been released or if a development version is preferred, use:

```bash
$> composer require monii/reflection-properties-serializer:@dev
```


Goals and Target Use Cases
--------------------------

The goal of this package is to provide a simple strategy for serializing simple value objects that contain primitives and other value objects.

The target use case for this project is serializing and deserializing commands and events comprised of simple value objects.

We wanted to minimize the amount of configuration and work that needs to be done to serialize and deserialize events and commands in environments where these are simple immutable value objects.

It was our hope we could do this entirely with `@var` typehints and we are going to see how far this takes us before falling back on heavier solutions like Symfony Serializer or JMS Serializer.


Limitations
-----------

This package is intentionally simple and strives to use as few dependencies as possible. This means that there are some limitations that we are going to accept until we find a reason to address them.

 * All properties need to be typehinted using PSR-5 `@var` syntax.
 * We make a best guesss effort to support the right implementation of multiple `@var` types are listed.
 * We cannot deserialize objects from different types to the same property (meaning interfaces-only `@var` typehints are going to give you a hard time).


License
-------

MIT, see LICENSE.


Community
---------

Want to get involved? Here are a few ways:

 * Find us in the #monii IRC channel on irc.freenode.org.
 * Mention [@moniidev](https://twitter.com/moniidev) on Twitter.
