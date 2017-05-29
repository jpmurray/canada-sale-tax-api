# Canada's sale taxes API

Here's an API to get canadian sales tax informations. Simple as that.

## Report actual, future or historical data

If you see any discrepancies in actual data, missing future rates or want to contribute historical rates, you can send an email at himself[at]jpmurray[dot]net with the data and we'll include it in the API.

## Documentation

### Rate limit

API usage is curently rate limited at 60 tries per minutes. The rate limit is subject to change upon API popularity.

### Contributing

You know the drill: report bugs in issue, suggest features in issue and if you can, submit pull requests!

### Meaning of accronyms

- GST: Global sales tax;
- PST: Provincial sales tax, regardless of the name a given province gives it (ie.: Quebec's QST is known in the API as a PST);
- HST: Harmonized sales tax;

### Usage

#### Prior version of the API

- API version 1's documentation can be found [here](index-v1.md)

#### Parameters

Where it is needed, the only parameter this API uses is `:province` and the API expects a [two letter canadian province postal abbreviation](https://en.wikipedia.org/wiki/Canadian_postal_abbreviations_for_provinces_and_territories#List_of_postal_abbreviations)

#### Possible attributes returned

The attributes returned by the API are pretty standards all over. While some endpoints will have more or less attributes than another endpoint, it will always be one of the following:

- `applicable`: a `float` numeric value representing the applicable percentage on a price (normally either the value of the GST, GST+PST or HST);
- `gst`: a `float` numeric value representing a GST percentage;
- `hst`: a `float` numeric value representing an HST percentage;
- `province`: a [two letter canadian province postal abbreviation](https://en.wikipedia.org/wiki/Canadian_postal_abbreviations_for_provinces_and_territories#List_of_postal_abbreviations)
- `pst`: a `float` numeric value representing a PST percentage;
- `source`: a `string` value, containing the source of the information;
- `start`: the date at which a given rate started to be used;
- `type`: a list, separated by comma, of the type of taxes that are applicable, and used to calculate the 'applicable' attribute;
- `updated_at`: a `datetime` value of the last update the information received; 

#### URL to poll

URL to poll the API is `http://api.salestaxapi.ca`.

For example, sending a `GET` request to `http://api.salestaxapi.ca/v2/federal/gst` will retreive the currently applicable GST rate.

#### About historical rates

Any endpoint returning the history of a rate returns the values of rates that the API has ever been aware of.

This means that that this API does not strive to know every _past_ rates, but will return any past values that has been seen since it's inception. Any more is just bonus!

#### GST (Federal tax)

##### Get current GST

`/v2/federal/gst`

###### Example of successfull response

```json
{
	"start": "2008-01-01 00:00:00",
	"type": "gst",
	"gst": 0.05,
	"applicable": 0.05,
	"source": "Wikipedia (https:\\/\\/en.wikipedia.org\\/wiki\\/Sales_taxes_in_Canada) , accessed May 28 2017",
	"updated_at": "2017-05-28 19:03:28"
}
```

##### Get the future GST rate

`/v2/federal/gst/future`

This endpoint will return a `404: There is no known future rate for GST.` if there is no known future value for the GST.

###### Example of successfull response

```json
{
	"start": "2100-01-01 00:00:00",
	"type": "gst",
	"gst": 0.20,
	"applicable": 0.25,
	"source": "We asked the question to a weird looking 8ball.",
	"updated_at": "2017-05-28 19:03:28"
}
```

##### Get the history of known GST rate

`/v2/federal/gst/historical`

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

`/v2/province/:province`

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
	"updated_at": "2017-05-28 15:30:37"
}
```

##### Get the future PST rate of a province

`/v2/province/:province/future`

This endpoint will return a `404: There is no known future rate for :province.` if there is no known future value for the GST.

###### Example of successfull response

```json
{
	"start": "1995-11-01 00:00:00",
	"type": "pst",
	"pst": 0.10,
	"hst": 0,
	"gst": 0.00,
	"applicable": 0.12,
	"source": "From a secret sovereignist thinktank document.",
	"updated_at": "2017-05-28 15:30:37"
}
```

##### Get the history of known GST rate for a province

`/v2/province/:province/historical`

###### Example of successfull response

```json
[
	{
		"start": "2020-11-01 00:00:00",
		"type": "hst",
		"pst": 0.10,
		"hst": 0.13,
		"gst": 0.03,
		"applicable": 0.13,
		"source": "One of the government's website.",
		"updated_at": "2017-05-28 15:30:37"
	},
	{
		"start": "1995-11-01 00:00:00",
		"type": "pst",
		"pst": 0.10,
		"hst": 0,
		"gst": 0.00,
		"applicable": 0.12,
		"source": "From a secret sovereignist thinktank document.",
		"updated_at": "2017-05-28 15:30:37"
	}
]
```

##### Get current PST for all provinces

`/v2/province/:province/all`

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

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
