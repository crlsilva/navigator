# CaféApi Library Test

[![Maintainer](http://img.shields.io/badge/maintainer-@cygnuscyber-blue.svg?style=flat-square)](https://twitter.com/cygnuscyber)
[![Source Code](http://img.shields.io/badge/source-crlsilva/navigator-blue.svg?style=flat-square)](https://github.com/crlsilva/navigator)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/crlsilva/navigator.svg?style=flat-square)](https://packagist.org/packages/crlsilva/navigator)
[![Latest Version](https://img.shields.io/github/release/crlsilva/navigator.svg?style=flat-square)](https://github.com/crlsilva/navigator/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/crlsilva/navigator.svg?style=flat-square)](https://scrutinizer-ci.com/g/crlsilva/navigator)
[![Quality Score](https://img.shields.io/scrutinizer/g/crlsilva/navigator.svg?style=flat-square)](https://scrutinizer-ci.com/g/crlsilva/navigator)
[![Total Downloads](https://img.shields.io/packagist/dt/crlsilva/navigator.svg?style=flat-square)](https://packagist.org/packages/ccrlsilva/navigator)

###### Navigation is a handy little component that adds pagination to websites or blogs easily and effectively.

Navigation é um pequeno componente muito prático de usar que acrescenta paginação em sites ou blogs de maneira fácil e eficaz.

Você pode saber mais **[clicando aqui](https://www.designcafe.com.br)**.

### Highlights

- Simple installation (Instalação simples)
- Composer ready and PSR-2 compliant (Pronto para o composer e compatível com PSR-2)

## Installation

Uploader is available via Composer:

```bash
"designcafe/navigator": "^1.0"
```

or run

```bash
composer require designcafe/navigator
```

## Documentation

###### For details on how to use, see a sample folder in the component directory. In it you will have an example of use for each class. It works like this:

Para mais detalhes sobre como usar, veja uma pasta de exemplo no diretório do componente. Nela terá um exemplo de uso para cada classe. Ele funciona assim:

#### User endpoint:

```php
<?php
require __DIR__ . "/../vendor/autoload.php";

$page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
$pager = new \DesignCafe\Navigator\Navigator();
$pager->pager($page, 100, 10);

echo $pager->render();
```

#### Output:

```html
<nav class="navigator">
    <a class='navigator_item' title="Primeira página" href="?page=1"><<</a>
    <span class="navigator_item navigator_active">1</span>
    <a class='navigator_item' title="Página 2" href="?page=2">2</a>
    <a class='navigator_item' title="Página 3" href="?page=3">3</a>
    <a class='navigator_item' title="Página 4" href="?page=4">4</a>
    <a class='navigator_item' title="Última página" href="?page=10">>></a>
</nav>

```

### Others

###### You can choose the format of the first and last page links and the number of links to display in pagination.

Você pode escolher o fomato dos links de primeira e última página e quantidade de links a serem exibidos na paginação.

## Contributing

Please see [CONTRIBUTING](https://github.com/crlsilva/uploader/blob/master/CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email contato@designcafe.com.br instead of using the issue tracker.

Se você descobrir algum problema relacionado à segurança, envie um e-mail para contato@designcafe.com.br em vez de usar o rastreador de problemas.

Thank you

## Credits

- [Cristiano Silva](https://github.com/crlsilva) (Developer)
- [Design Café](https://github.com/crlsilva) (Team)
- [All Contributors](https://github.com/crlsilva/navigator/contributors) (This Rock)

## License

The MIT License (MIT). Please see [License File](https://github.com/crlsilva/navigator/blob/master/LICENSE) for more information.