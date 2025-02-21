# Canada's sale taxes API

Here's an API to get Canadian sales tax information. Simple as that.

If you see any discrepancies in actual data, missing future rates, or want to contribute historical rates, please open an issue on the GitHub repository with the data and we'll include it in the API.

## Deprecation notice

As we've launched the 3rd iteration of the API, we will be deprecating the older versions of the API in favor of the latest version.

Version 1 of the API will be deprecated on July 1st, 2025.

Version 2 of the API will be deprecated on December 1st, 2025.

## Documentation

### Authentication

Since we've been seeing more and more usages of the API through the years, the fact that we can't contact users - for example in case of maintenance or deprecation - became a hindrance. We've then decided to implement a requirement to authenticate via bearer token, that needs to be obtained after registration to the API.

You then need to send this token in the `Authorization` header when making requests to the API.

```
Authorization: Bearer <token>
```

### Rate limit

API usage is currently rate limited at 60 tries per minute. The rate limit is subject to change upon API popularity.

We strongly encourage the implementation of a caching strategy on the user end: the sales tax rarely changes, and this helps with server load. Updating this cache once a month should be sufficient.

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
-   `province`: a [two-letter Canadian province postal abbreviation](https://en.wikipedia.org/wiki/Canadian_postal_abbreviations_for_provinces_and_territories#List_of_postal_abbreviations);
-   `pst`: a `float` numeric value representing a PST percentage;
-   `source`: a `string` value, containing the source of the information;
-   `start`: the date at which a given rate started (or will start) to be used;
-   `type`: a list, separated by commas, of the types of taxes that are applicable, and used to calculate the 'applicable' attribute;
-   `incoming_changes`: either a `datetime` to point when the next known change is happening or `false` (you can hit the `future` endpoint for more information);
-   `updated_at`: a `datetime` value of the last update the information received;

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
    "start": "2008-01-01 00:00:00",
    "type": "gst",
    "gst": 0.05,
    "applicable": 0.05,
    "source": "Wikipedia (https:\\/\\/en.wikipedia.org\\/wiki\\/Sales_taxes_in_Canada) , accessed May 28 2017",
    "updated_at": "2017-05-28 19:03:28",
    "incoming_changes": false
}
```

##### Get the future GST rate

`/v3/federal/gst/future`

This endpoint will return a `404: There is no known future rate for GST.` if there is no known future value for the GST.

###### Example of successfull response

```json
{
    "start": "2100-01-01 00:00:00",
    "type": "gst",
    "gst": 0.2,
    "applicable": 0.25,
    "source": "We asked the question to a weird looking 8ball.",
    "updated_at": "2017-05-28 19:03:28"
}
```

##### Get the history of known GST rate

`/v3/federal/gst/historical`

###### Example of successfull response

```json
[
    {
        "start": "2008-01-01 00:00:00",
        "type": "gst",
        "gst": 0.05,
        "applicable": 0.05,
        "source": "Wikipedia (https:\\/\\/en.wikipedia.org\\/wiki\\/Sales_taxes_in_Canada) , accessed May 28 2017",
        "updated_at": "2017-05-28 19:03:28"
    },
    {
        "start": "1990-01-01 00:00:00",
        "type": "gst",
        "gst": 0.01,
        "applicable": 0.01,
        "source": "A dusty old book.",
        "updated_at": "2017-05-28 19:03:28"
    }
]
```

#### PST (Provincial tax)

##### Get current PST for a province

`/v3/province/:province`

###### Example of successfull response

```json
{
    "start": "2013-01-01 00:00:00",
    "type": "gst,pst",
    "pst": 0.09975,
    "hst": 0,
    "gst": 0.05,
    "applicable": 0.14975,
    "source": "Wikipedia (https:\\/\\/en.wikipedia.org\\/wiki\\/Sales_taxes_in_Canada) , accessed May 28 2017",
    "updated_at": "2017-05-28 15:30:37",
    "incoming_changes": "2019-07-01 00:00:00"
}
```

##### Get the future PST rate of a province

`/v3/province/:province/future`

This endpoint will return a `404: There is no known future rate for :province.` if there is no known future value for the GST.

###### Example of successfull response

```json
{
    "start": "1995-11-01 00:00:00",
    "type": "pst",
    "pst": 0.1,
    "hst": 0,
    "gst": 0.0,
    "applicable": 0.12,
    "source": "From a secret sovereignist thinktank document.",
    "updated_at": "2017-05-28 15:30:37"
}
```

##### Get the history of known GST rate for a province

`/v3/province/:province/historical`

###### Example of successfull response

```json
[
    {
        "start": "2020-11-01 00:00:00",
        "type": "hst",
        "pst": 0.1,
        "hst": 0.13,
        "gst": 0.03,
        "applicable": 0.13,
        "source": "One of the government's website.",
        "updated_at": "2017-05-28 15:30:37"
    },
    {
        "start": "1995-11-01 00:00:00",
        "type": "pst",
        "pst": 0.1,
        "hst": 0,
        "gst": 0.0,
        "applicable": 0.12,
        "source": "From a secret sovereignist thinktank document.",
        "updated_at": "2017-05-28 15:30:37"
    }
]
```

##### Get current PST for all provinces

`/v3/province/all`

###### Example of successfull response

```json
{
	"ab": {
		"start": "2008-01-01 00:00:00",
		"type": "gst",
		"pst": 0,
		"hst": 0,
		"gst": 0.05,
		"applicable": 0.05,
		"source": "Wikipedia (https:\\/\\/en.wikipedia.org\\/wiki\\/Sales_taxes_in_Canada) , accessed May 28 2017",
		"updated_at": "2017-05-28 18:46:55"
	},
	"bc": {
		"start": "2013-04-01 00:00:00",
		"type": "gst,pst",
		"pst": 0.07,
		"hst": 0,
		"gst": 0.05,
		"applicable": 0.12,
		"source": "Wikipedia (https:\\/\\/en.wikipedia.org\\/wiki\\/Sales_taxes_in_Canada) , accessed May 28 2017",
		"updated_at": "2017-05-28 18:49:00"
	},
	"etc": {"and so on..."}
}
```

## License

The API has been built with the Laravel framework its code is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
