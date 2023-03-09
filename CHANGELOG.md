# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## Unreleased

### Fixed
- Fixed an error that occurred if the Roll Your Own widget was set to use a nonexistent template

## 4.1.1 - 2022-11-30

### Fixed
- Fixed an error that occurred when executing a GraphQL query if a Width field existed in the Craft install

## 4.1.0 - 2022-10-20

### Added
- Added `spicyweb\oddsandends\fields\DisabledProducts` - Commerce Products (Disabled) field type
- Added `spicyweb\oddsandends\fields\DisabledVariants` - Commerce Variants (Disabled) field type
- Added `spicyweb\oddsandends\fields\ProductsSearch` - Commerce Products (Search) field type
- Added `spicyweb\oddsandends\fields\VariantsSearch` - Commerce Variants (Search) field type

### Fixed
- Fixed some style issues with element search fields

## 4.0.0 - 2022-10-19

### Added
- Added support for Craft 4 (requires Craft 4.2.1 or later)

### Removed
- Removed support for Craft 3

## 3.0.2 - 2022-10-20

### Fixed
- Fixed an error that could occur when editing element search field contents
- Fixed a bug where previously selected elements for element search fields couldn't be removed

## 3.0.1 - 2022-10-19

### Fixed
- Fixed an error that occurred when attempting inline editing of entries selected for an Entries (Search) field, and categories selected for a Categories (Search) field

## 3.0.0 - 2022-10-18

> {note} The plugin’s package name has changed to `spicyweb/craft-odds-and-ends`. If you’re updating with Composer, you will need to run `composer require spicyweb/craft-odds-and-ends` and then `composer remove supercool/tools`.

### Changed
- Name changed from 'Tools' to 'Odds & Ends'
- Now maintained by Spicy Web
- Now requires Craft 3.7.55.3 or later Craft 3 releases

### Fixed
- Fixed an error that occurred when creating a width field on Craft 3.7.46 or later Craft 3 releases
- Fixed a bug where Roll Your Own widgets were always displaying 'Roll Your Own' as the title, instead of the user-specified title
- Fixed a JavaScript error that could occur with Entries (Search) and Categories (Search) fields
- Fixed a bug where Entries (Search) and Categories (Search) fields could fail to return results
- Fixed an error that occurred with the Entries (Search) field if single sections were one of the sources set for the field
- Fixed an error that occurred when loading Ancestors field settings
- Fixed a bug where Ancestors field modals could fail to show elements

## 2.2.3 - 2022-05-24

### Fixed
- Width field styling

## 2.2.2 - 2022-05-09

### Fixed
- Width field data type for php 7.4

## 2.2.1.1 - 2021-01-20

### Fixed
- Validation error when grid data was typecasted to int

## 2.2.1 - 2021-01-19

### Changed
- Settings and UI for grid field

## 2.2.0 - 2020-09-24

### Added
- Support for craft 3.5

## 2.1.10.1 - 2021-01-20

### Fixed
- Small validation fix for grid field rework

## 2.1.10 - 2021-01-19

### Changed
- Grid field settings and UI overhauled

## 2.1.9 - 2020-10-07

### Fixed
- Fixed width field for Craft 3.3.5+

## 2.1.8 - 2019-03-15

### Added
- Added `supercool\tools\fields\data\GridData::leftRight()` field for use in templates

## 2.1.7 - 2019-03-04

### Fixed
- Fixed a composer.json issue

## 2.1.6 - 2019-03-04

### Fixed
- Fixed an error that could occur with width fields

## 2.1.5 - 2018-12-17

### Added
- Added default value for width

## 2.1.4 - 2018-12-13

### Added
- Added global settings for width

## 2.1.3 - 2018-12-11

### Fixed
- Fixed multiple width fields

## 2.1.2 - 2018-12-06

### Added
- Added toggle for show/hide width field

## 2.1.1 - 2018-11-13

### Fixed
- Fixed a composer.json issue

## 2.1.0 - 2018-11-13

### Added
- Added a grid field type which is going to be used as a width field

## 2.0.0 - 2018-08-02

### Added
- Initial Craft CMS 3 release
