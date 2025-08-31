- Each change to code should be added in a concise form into the changelog in readme.txt file.
- After editing files, make sure they follow the coding standards.
- After editing JS or CSS files, always run `yarn build` command.

## Environment

The plugin is running in Docker container with Lando configuration. All composer or environment related stuff should be run through `lando` command.

## Coding standards

- For PHP, we use WordPress Coding Standards, which can be verified using `lando composer phpcs` or fixed using ` lando composer phpcbf`
- For JS, we should adhere to [WordPress Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)
- For CSS , we should adhere to [WordPress Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/)

## Changelog

###  Guiding Principles

- Unreleased version should be groupped in section called `2.6.0`, if there's no changelog for `2.6.0`, just start it and insert the first item.
- Changelogs are for humans, not machines.
- The same types of changes should be grouped.
- There should be an entry for every single version.
- The latest version comes first.

### Types of changes
- `Added` for new features
- `Changed` for changes in existing functionality
- `Deprecated` for soon-to-be removed features
- `Removed` for now removed features
- `Fixed` for any bug fixes
- `Security` in case of vulnerabilities
