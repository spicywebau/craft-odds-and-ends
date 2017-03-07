## Field types

### Width
This lets you define the width of a block as well as left and right padding. This field simply outputs three sets of classes which can be defined when setting the field up.

![width Field Settings](https://raw.githubusercontent.com/supercool/Tools/master/screenshots/width-settings.png)
![width Field](https://raw.githubusercontent.com/supercool/Tools/master/screenshots/width-field.png)

### Dropdown (other)
Like a normal Dropdown field but with an additional text option that the user can add what they like to.

![Dropdown (other)](https://raw.githubusercontent.com/supercool/Tools/master/screenshots/dropdown-other.gif)

You can customise the label and placeholder of the extra field, and also access all of the options from twig in the same way you can on a normal Dropdown field, see the official docs on this [here](https://craftcms.com/docs/dropdown-fields#templating).

If the ‘other’ option has been selected then the value will be set to `other` and you can access the extra text the user entered via `{{ entry.dropdownField.otherValue }}`.

### Default Number
An extension of the standard Number field to let you add a default value.

### Author Instructions
This lets you output markdown instead of a field, which is useful when you have a Matrix block that doesn’t have any fields.

![Author Instructions Example](https://raw.githubusercontent.com/supercool/Tools/master/screenshots/author-instructions-example.png)

### Categories (multiple groups)
A Categories input that lets you select multiple Category groups.

### Ancestors
An Entries input that only shows the ancestors of the current Entry.

### Search Fields
Like the Tags input, but for Entries and Categories (without the auto-creation feature).

### Disabled Fields
The same as regular fields, but disabled. Useful for situations where you want to integrate with a third party API and store that information in a field but don’t want the user to change it.

The following field types are currently supported:

- Entries
- Categories
- Lightswitch
- Number
- PlainText
- Dropdown


## Widgets

### Roll Your Own
A simple widget that lets you assign a template to load from your site templates folder. Go nuts.


## CP Tools

The “Tools” section, accessible from the main menu, has a few simplified tools in it, much like the tools you can find on the Settings page. At present there are three:

- Clear Tasks - empties the Tasks table, which is useful if you get a stuck Task
- Clear Caches - clears only the template caches
- Rebuild Search Indexes - behaves the same as the Settings page one


## Config variables


### `openInstructionLinksInNewWindow`

Default: `true`

Set this to true to force all instruction links to open in new a window/tab.

## Miscellaneous

### Download File
A controller action that will force download a file.

The `id` parameter is required and must be a valid Asset id.

Usage:
```
<a href="{{ actionUrl('supercoolTools/downloadFile', { id : file.id }) }}">Download</a>
```

### Clear Cache
A controller action that will delete the all the template caches.

Here is an example you could use with cron:
```
/usr/bin/curl --silent -H "X-Requested-With:XMLHttpRequest" http://example.com/actions/supercoolTools/clearCache
```

# Roadmap

- Lock/Unlock field types - like on the password fields
- More disabled and searchable fields - ask if you want one thats not there already
- Release notes widget / dashboard integration


# Changelog

### 1.10.0

- Removed Zendesk support.

### 1.7.0

- Added a new field type called Width which lets you define the width of a block as well as left and right padding. This field simply outputs three sets of classes which can be defined when setting the field up.
- Added a Zendesk widget.
- Removed the support for Freshdesk.

### 1.6.1

- Added a new field type called Default Number that mimics the behaviour of the normal Number field type but lets you set a default value.",
- Added a new field type called Dropdown (other) that lets you add an ‘other’ option to a dropdown field. When ‘other’ is selected another text input is shown to allow the user to enter something other than the standard options provided.",

### 1.6.0
- Added a new field type called Author Instructions that lets you output markdown instead of a field. Useful when you have a Matrix block that doesn’t have any fields.

### 1.5.4
- Fixed a bug where clearing all Tasks wouldn’t actually kill it, it would lie in wait and the next time a Task of the same name ran it would piggy back on that db row ...

### 1.5.3
- Made all the field types previewable.

### 1.5.2
- Fixed a casing bug that would cause the Tools cp tab to error on some servers.

### 1.5.1
- Switched the Freshdesk icon from ‘help’ to ‘mail’.

### 1.5.0
- Added the `openInstructionLinksInNewWindow` config variable which when set to true will open all instruction links in new a window.",
- Added a freshdesk widget that opens in a new window.",
- Added a “Roll Your Own” widget that lets you assign a template to load from your site templates folder. Go nuts.",
- Added a cp section with some simplified tools in it (Clear Tasks, Clear Template Caches and Re-build Search Indexes).",
- Sorted out the changelog to be compatible with the `getReleaseFeedUrl()` method."

### 1.4.2
- Added a new field type ‘Categories (multiple groups)’ that lets you select multiple groups in a Categories field.

### 1.4.1
- Fixed disabled element fields not showing up in Live Preview and theoretically emptying their contents on save.

### 1.4.0
- Added a disabled Entries field type.

### 1.3.1
- Fixes a bug where all file downloads were generating a temporary file that never got deleted until someone cleared the temporary files from the settings page in the cp. Now any assets file in the temp folder that is over 24 hours old will be removed on the next `supercoolTools/downloadFile` request.

### 1.3.0
- Added a controller action to clear caches.

### 1.2.1
- Fixed an error with checking for the locale in the search input templates.

### 1.2.0
- Added a fuzzy search field type for Categories.

### 1.1.1
- Fixed the title search on EntriesSearch fields not being totally inclusive.

### 1.1.0
- Disabled dropdown field type.
- Fixed some re-naming issues.

### 1.0.0
- Initial release.
