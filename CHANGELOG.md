# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2017-06-26
### Added
- Added support for model parameters of `make:controller`, `make:factory`, `make:observer` and `make:policy`

### Removed
- Laravel 5.8 support

### Changed
- Replace extended class with macro and afterResolving hooks

## [1.0.3] - 2017-06-24
### Removed
- Production mode checking to make comply with the Laravel way.

## [1.0.2] - 2017-06-24
### Added
- Support for Laravel 5.8

## [1.0.1] - 2017-06-24
### Added
- This changlog
- MIT license

### Fixed
- The Provider does not return the model:make command any more in production environment

## [1.0.0] - 2017-06-24
### Added
- Initial version implementing the configurable model make command
