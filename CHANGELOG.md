# Changelog

All notable changes to this package are documented in this file. Versions
follow [Semantic Versioning](https://semver.org). New entries are generated from
commit messages by [dry-ci](https://github.com/TallieuTallieu/dry-ci); past
entries may be edited by hand.

## 3.1.0 - 2026-07-09

### Breaking changes

- Requires PHP 8.4 or newer (was `^8.2`) and `tallieutallieu/dry-dbi` `^3.12.1` (was `^3.11.1`); upgrade both before updating

### Other changes

- Add Docker-backed CI and release workflows ([sc-9969](https://app.shortcut.com/tallieu--tallieu/story/9969))
- Run workflows without docker compose
- Add baseline Pest suite
- **.node-version:** Update default node version to 24.18.0
- Add Shortcut project prefix to AGENTS.md

## 3.0.0 - 2026-01-22

### Breaking changes

- Requires PHP `^8.2` and `tallieutallieu/dry-dbi` `^3.11.1`; earlier versions declared no requirements
- Custom components must match the new public, typed abstract signatures: `Filter::apply(FilterableInterface, mixed): void`, `Searcher::apply(SearchableInterface, string): void`, `Sorter::apply(SortableInterface, string = 'ASC'): void`, and on `Paginator` `apply(PaginatableInterface, ?int): void`, `getCurrentPage(): int`, `getDefaultPage(): ?int` and `getPageCount(): int`
- Custom `InputInterface` implementations must declare `get(string $key): mixed`, and custom `BuilderInterface` implementations `setParam(string, string|int|array): void` and `withParam(string, string|int)`
- `FilterableInterface::filter()` and `SortableInterface::sort()` now take a `string $column`, and `EqualsFilter`, `MultiEqualsFilter` and `SimpleSorter` require a string column
- `DataList::getResults()` returns `mixed` instead of `ResultSet`, and `DataList::getPaginator()` returns `?Paginator`

### Fixes

- **sort:** Fix the `ColumnSorter` check that a sort string holds exactly a column and a direction

### Other changes

- Add development tooling: Docker setup with Xdebug, PHPStan level 9, Prettier and Pest
- Add comprehensive type hints and improve code quality

## Earlier history

- **1.0.0** (2019-07-16): First release as `reinvanoyen/dry-datalist`: a `DataList` over a dry-dbi `Repository` with pluggable searcher (`LikeSearcher`), sorters (`SimpleSorter`), filters (`EqualsFilter`, `MultiEqualsFilter`), a paginator (`SimplePaginator`), GET-parameter input and a URL builder
- **1.0.1** (2019-10-10): Add an `optional` option to `SimplePaginator` (1.0.2 points at the same commit)
- **1.0.3** (2019-11-21): Add `DataList::setDefaultSorter()`
- **1.0.4** (2019-12-03): `SimplePaginator::getCurrentPage()` may return null
- **1.0.5** (2020-01-22): Fix filters so they apply whenever their parameter is present, even with an empty value
- **1.0.6** (2020-10-13): Add a repository getter to `DataList`
- **1.0.7** (2023-11-15): Fix a negative offset in `SimplePaginator` that raised "signed integer value is out of range" on MySQL 8+; first release under the `tallieutallieu/dry-datalist` package name
- **1.0.8** (2025-01-29): Add a default sort method to `SimpleSorter`
- **1.0.9** (2025-01-31): Allow array query parameters
- **1.0.10** (2025-02-18): Add `ColumnSorter`, which reads column and direction from one sort string
- **1.0.11** (2025-04-30): `DataList::apply()` defaults to `GetParams` input when none is given

See the git tags before 3.0.0 for the full history.
