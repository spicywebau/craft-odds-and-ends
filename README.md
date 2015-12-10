Tools for your Craft website.

---

## Field types

### Ancestors
An Entries input that only shows the ancestors of the current Entry.

### Search Fields
Like the Tags input, but for Entries and Categories (without the auto-creation feature).

### Disabled Fields
The same as regular fields, but disabled. Useful for situations where you want to integrate with a third party API and store that information in a field but don’t want the user to change it.

The following field types are currently supported:

- Categories
- Lightswitch
- Number
- PlainText
- Dropdown


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
- Custom Dashboard - a starting point for the user that we set up for each site with links to each section, our support portal and other bits and bobs
- More disabled and searchable fields - ask if you want one thats not there already
- Release notes widget / dashboard integration


# Changelog

### 1.3.0
- Added a controller action to clear caches

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
