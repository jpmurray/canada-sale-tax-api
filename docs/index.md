# Canada's sale taxes API

Here's an API to get Canadian sales tax information. Simple as that.

If you see any discrepancies in actual data, missing future rates, or want to contribute historical rates, please open an issue on the GitHub repository with the data and we'll include it in the API.

## Deprecation notice

As we've launched the 3rd iteration of the API, we will be deprecating the older versions of the API in favor of the latest version.

Version 1 of the API will be deprecated on July 1st, 2025.

Version 2 of the API will be deprecated on December 1st, 2025.
You can inspect the header returned for `x-deprecation-notice` in that regard.

## Documentation

### Authentication

Since we've been seeing more and more usages of the API through the years, the fact that we can't contact users - for example in case of maintenance or deprecation - became a hindrance. We've then decided to implement a requirement to authenticate via bearer token, that needs to be obtained after registration to the API.

You then need to send this token in the `Authorization` header when making requests to the API.

```
Authorization: Bearer <token>
```

As of 2025, the token _never_ expires.

### Rate limit

API usage is currently rate limited at 60 tries per minute. The rate limit is subject to change upon API popularity.

We strongly encourage the implementation of a caching strategy on the user end: the sales tax rarely changes, and this helps with server load. Updating this cache once a month should be sufficient.

You can inspect the headers returned with your request to monitor rate limits:

-   `x-ratelimit-limit`: Total attempts permitted in the time period.
-   `x-ratelimit-remaining`: Remaining attempts in the time period.
-   `retry-after`: The number of seconds to wait before making another request after hitting the rate limit.
-   `x-ratelimit-reset`: The timestamp indicating when the rate limit will reset.

### Contributing

You know the drill: report bugs in issues, suggest features in issues, and if you can, submit pull requests!

### Meaning of acronyms

-   GST: Goods and Services Tax;
-   PST: Provincial Sales Tax, regardless of the name a given province gives it (e.g., Quebec's QST is known in the API as a PST);
-   HST: Harmonized Sales Tax;

### Usage

#### Prior versions of the API

-   API version 1's documentation can be found [here](index-v1.md)
-   API version 2's documentation can be found [here](index-v2.md)

#### Parameters

Where it is needed, the only parameter this API uses is `:province` and the API expects a [two-letter Canadian province postal abbreviation](https://en.wikipedia.org/wiki/Canadian_postal_abbreviations_for_provinces_and_territories#List_of_postal_abbreviations)

#### Possible attributes returned

The attributes returned by the API are pretty standard overall. While some endpoints will have more or fewer attributes than another endpoint, it will always be one of the following:

-   `applicable`: a `float` numeric value representing the applicable percentage on a price (normally either the value of the GST, GST+PST, or HST);
-   `gst`: a `float` numeric value representing a GST percentage;
-   `hst`: a `float` numeric value representing an HST percentage;
-   `province`: a [two-letter Canadian province postal abbreviation](https://en.wikipedia.org/wiki/Canadian_postal_abbreviations_for_provinces_and_territories#List_of_postal_abbreviations) or, in case of federal level `fe`;
-   `pst`: a `float` numeric value representing a PST percentage;
-   `source`: a `string` value, containing the source of the information;
-   `start`: the date at which a given rate started (or will start) to be used;
-   `type`: a list, separated by commas, of the types of taxes that are applicable, and used to calculate the 'applicable' attribute;
-   `incoming_changes`: either a `datetime` to point when the next known change is happening or `false` (you can hit the `future` endpoint for more information);
-   `updated_at`: a `datetime` value of the last update the information received;

##### Meta

Endpoints will also return a `meta` object containing the following attributes:

-   `timestamp`: a `string` representing the ISO-8601 formatted datetime of when the response was generated. This can be used to determine if the result is cached (it usually is).
-   `version`: an `integer` representing the current version of the API.
-   `alerts`: an array of messages intended for users. Each message, if any, is in the following format:

```json
{
    "type": "deprecation", // could be info, warning, or deprecation
    "message": "v0 of the API will be deprecated on 01-01-2000", // the message content
    "created_at": "2025-02-26T14:33:02.000000Z" // the date the message was created
}
```

#### URL to poll

URL to poll the API is `https://api.salestaxapi.ca`.

For example, sending a `GET` request to `https://api.salestaxapi.ca/v3/federal/gst` will retrieve the currently applicable GST rate.

#### About historical rates

Any endpoint returning the history of a rate returns the values of rates that the API has ever been aware of.

This means that this API does not strive to know every _past_ rate, but will return any past values that have been seen since its inception. Any more is just a bonus!

#### GST (Federal tax)

##### Get current GST

`/v3/federal/gst`

###### Example of successfull response

```json
{
  "data": {
    "province": "fe",
    "start": "2008-01-01 00:00:00",
    "type": "gst",
    "gst": 0.05,
    "applicable": 0.05,
    "source": "Wikipedia (https://en.wikipedia.org/wiki/Sales_taxes_in_Canada), accessed May 31 2019.",
    "updated_at": "2019-05-31 14:56:48",
    "incoming_changes": false
  },
  "meta": {...}
}
```

##### Get the future GST rate

`/v3/federal/gst/future`

This endpoint will return a `404: There is no known future rate for GST.` if there is no known future value for the GST.

###### Example of successfull response

```json
{
  "data": {
    "province": "fe",
    "start": "2100-01-01 00:00:00",
    "type": "gst",
    "gst": 0.2,
    "applicable": 0.25,
    "source": "We asked the question to a weird looking 8ball.",
    "updated_at": "2017-05-28 19:03:28"
  },
  "meta": {...}
}
```

##### Get the history of known GST rate

`/v3/federal/gst/historical`

###### Example of successfull response

```json
{
  "data": [
    {
      "province": "fe",
      "start": "2008-01-01 00:00:00",
      "type": "gst",
      "gst": 0.05,
      "applicable": 0.05,
      "source": "Wikipedia (https://en.wikipedia.org/wiki/Sales_taxes_in_Canada), accessed May 31 2019.",
      "updated_at": "2019-05-31 14:56:48",
      "incoming_changes": false
    },
    {
      "province": "fe",
      "start": "2006-07-01 00:00:00",
      "type": "gst",
      "gst": 0.06,
      "applicable": 0.06,
      "source": "Canada Open Government dataset: Goods and Services Tax / Harmonized Sales Tax (GST/HST) Rates from 1991 - 2015",
      "updated_at": "2019-06-01 14:04:23",
      "incoming_changes": false
    },
    {...}
  ],
  "meta": {...}
}
```

#### PST (Provincial tax)

##### Get current PST for a province

`/v3/province/:province`

###### Example of successfull response

```json
{
  "data": {
    "province": "ns",
    "start": "2008-01-01 00:00:00",
    "type": "hst",
    "gst": 0.05,
    "pst": 0.1,
    "hst": 0.15,
    "applicable": 0.15,
    "source": "Wikipedia (https://en.wikipedia.org/wiki/Sales_taxes_in_Canada), accessed May 31 2019.",
    "updated_at": "2019-05-31 14:51:09",
    "incoming_changes": "2025-04-01 00:00:00"
  },
  "meta": {...}
}
```

##### Get the future PST rate of a province

`/v3/province/:province/future`

This endpoint will return a `404: There is no known future rate for :province.` if there is no known future value for the GST.

###### Example of successfull response

```json
{
  "data": {
    "province": "ns",
    "start": "2025-04-01 00:00:00",
    "type": "hst",
    "gst": 0.05,
    "pst": 0.09,
    "hst": 0.14,
    "applicable": 0.14,
    "source": "https://news.novascotia.ca/en/2024/10/23/nova-scotias-hst-drop-2025",
    "updated_at": "2025-02-16 19:16:16",
    "incoming_changes": false
  },
  "meta": {...}
}
```

##### Get the history of known GST rate for a province

`/v3/province/:province/historical`

###### Example of successfull response

```json
{
  "data": [
    {
      "province": "qc",
      "start": "2013-01-01 00:00:00",
      "type": "gst,pst",
      "gst": 0.05,
      "pst": 0.09975,
      "applicable": 0.14975,
      "source": "Wikipedia (https://en.wikipedia.org/wiki/Sales_taxes_in_Canada), accessed May 31 2019.",
      "updated_at": "2019-06-01 14:39:07",
      "incoming_changes": false
    },
    {
      "province": "qc",
      "start": "2012-01-01 00:00:00",
      "type": "gst,pst",
      "gst": 0.05,
      "pst": 0.095,
      "applicable": 0.145,
      "source": "Revenue Quebec, on Wayback machine: https://web.archive.org/web/20130515154436/http://www.revenuquebec.ca/en/entreprise/taxes/tvq_tps/historique-taux-tps-tvq.aspx, accessed June 1 2019.",
      "updated_at": "2019-06-01 14:36:30",
      "incoming_changes": false
    },
    {...},
    {...}
  ],
  "meta": {...}
}
```

##### Get current PST for all provinces

`/v3/province/all`

###### Example of successfull response

```json
{
  "data": {
    "ab": {
      "province": "ab",
      "start": "2008-01-01 00:00:00",
      "type": "gst",
      "gst": 0.05,
      "applicable": 0.05,
      "source": "Wikipedia (https://en.wikipedia.org/wiki/Sales_taxes_in_Canada), accessed May 31 2019.",
      "updated_at": "2019-05-31 14:56:53",
      "incoming_changes": false
    },
    "bc": {...},
    "mb": {...},
    "nb": {...},
    "nl": {...},
    "ns": {...},
    "nt": {...},
    "nu": {...},
    "on": {...},
    "pe": {...},
    "qc": {...},
    "sk": {...},
    "yt": {...}
  },
  "meta": {...}
}
```

## License

The API has been built with the Laravel framework its code is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
