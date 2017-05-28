# Changelog

Trying as hard as I can to stick to semantic versionning.

## 3.2.0 (2017-05-28)
- Now caching response for 24h and invalidate cache on store or update or a rate.

## 3.1.0 (2017-05-28)
- Upgraded to Laravel 5.4
- Passage to database based rates

## 3.0.2 (2017-02-01)
- Changes effective PEI tax rate, as pointed out by @robert-waggott in #4.

## 3.0.1 (2016-10-25)
- Fixes a stupid code 18.

## 3.0.0 (2016-10-25)
- If an entity doesn't exists, it will either returns 404 or won't exists in array if requesting `all`;
- Routes now uses "provinces" and "federal" rather than "prov" and "fed".

## 2.0.1 (2016-10-25)
- Fixed documentation;
- Changed default Laravel homepage to customize it lightly.

## 2.0.0 (2016-10-25)
- Added documentation;
- Removed the need to `/api` in the routes so I can better operate from the subdomain.

## 1.0.0 (2016-10-24)
### Added
- First API routes are out in the wild.
