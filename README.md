# AsseticBundle v3.0

Manage your Laminas assets in conjunction with [assetic/framework](https://github.com/assetic-php/assetic), wired through Laminas config.



## Acknowledgements

* Original version - [widmogrod/zf2-assetic-module](https://github.com/widmogrod/zf2-assetic-module).
* Subsequent fork - [fabiang/assetic-module](https://github.com/fabiang/assetic-module).
* Both of which relied on the original [kriswallsmith/assetic](https://github.com/kriswallsmith/assetic).

Credit given to all predecessors, thank you.

## Todo

 * [ ] Connect tests to a proper GitHub action
 * [ ] Fix this README and its links

## What is this?

Assets management per module made easy.
Every module can come with their own assets (JS, CSS, Images etc.) and this
module make sure the assets are moved into your public folder and are directly
available in your views.

This also helps you to load all assets for your Laminas application which you've
installed with npm, yarn etc.

  * **Optimize your assets**. Minify your css, js; compile scss, and more...
  * **Adapts To Your Needs**. Using custom template engine and want to use power of this module, just implement `Circlical\AsseticBundle\View\StrategyInterface`
  * **Well tested**. Besides unit test this solution is also ready for the production use.
  * **Great fundations**. Based on [Assetic](https://github.com/assetic/framework) and [Laminas](https://getlaminas.org)
  * **Excellent community**. Everything is thanks to great support from GitHub & PHP community!
  * **Listen to your ideas**. Have a great idea? Bring your tested pull request or open a new issue.


## Installation

Read [the quick start guide for Laminas\Mvc](https://github.com/saeven/assetic-module/blob/master/docs/howto-mvc.md)
or [the quick start guide for Mezzio?](https://github.com/saeven/assetic-module/blob/master/docs/howto-mezzio.md)

## Documentation

  * [How to start with Laminas MVC?](https://github.com/saeven/assetic-module/blob/master/docs/howto-mvc.md)
  * [How to start with Mezzio?](https://github.com/saeven/assetic-module/blob/master/docs/howto-mezzio.md)
  * [Configuration](https://github.com/saeven/assetic-module/blob/master/docs/config.md)
  * [Tips & Tricks](https://github.com/saeven/assetic-module/blob/master/docs/tips.md)
  * [Migration guide](https://github.com/saeven/assetic-module/blob/master/docs/migration.md)

## Developing

We've two main branches here:

- master: current version with dropped Zend Framework and added Mezzio support
- 2.x: version compatible with Zend Framework 2/3 and Laminas
