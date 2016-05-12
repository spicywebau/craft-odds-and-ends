## Field types

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


### `freshdeskHandle`

Default: `null`

Set this to your Freshdesk subdomain handle (e.g. http://mycompanyhandle.freshdesk.com would be ‘mycompanyhandle’).
Once set this will add a “Support” link to the main nav that will pop open a modal with the widget in it. If you want to open the modal from some other arbitrary html then give it a class of `supercooltools-trigger-freshdesk`.


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
