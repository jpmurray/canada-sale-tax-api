# Canada's sale taxes API

Here's an API to get canadian sales tax informations. Simple as that.

## Documentation

### Rate limit

API usage is curently rate limited at 60 tries per minutes. The rate limit is subject to change upon API popularity.

### Contributing

You know the drill: report bugs in issue, suggest features in issue and if you can, submit pull requests!

### Meaning of accronyms

- GST: Global sales tax;
- PST: Provincial sales tax;
- HST: Harmonized sales tax;

### Usage

#### Parameters

The only parameter curently supported is `:prov` which is a [two letter canadian province postal abbreviation](https://en.wikipedia.org/wiki/Canadian_postal_abbreviations_for_provinces_and_territories#List_of_postal_abbreviations)

#### URL to poll

URL to poll the API is `https://api.canadasalestaxapi.ca`.

#### Get current GST

`/v1/fed/gst`

##### Example response

```
{
	"rate":0.05,
	"last_modified":"2016-10-01"
}
```
#### Get current HST for a province

`/v1/fed/hst/:prov`

##### Example response
Will return a rate of `null` if there is no applicable HST for a province.

```
{
	"rate":0.15,
	"last_modified":"2016-10-01"
}
```

#### Get current HST for all provinces

`/v1/fed/hst/all`

##### Example response
Will return a rate of `null` if there is no applicable HST for a province.

```
{
	"ab":{"rate":null,"last_modified":"2016-10-01"},
	"bc":{"rate":null,"last_modified":"2016-10-01"},
	"mb":{"rate":null,"last_modified":"2016-10-01"},
	"nb":{"rate":0.15,"last_modified":"2016-10-01"},
	"nl":{"rate":0.15,"last_modified":"2016-10-01"},
	"nt":{"rate":null,"last_modified":"2016-10-01"},
	"ns":{"rate":0.15,"last_modified":"2016-10-01"},
	"nu":{"rate":null,"last_modified":"2016-10-01"},
	"on":{"rate":0.13,"last_modified":"2016-10-01"},
	"pe":{"rate":0.15,"last_modified":"2016-10-01"},
	"qc":{"rate":null,"last_modified":"2016-10-01"},
	"sk":{"rate":null,"last_modified":"2016-10-01"},
	"yt":{"rate":null,"last_modified":"2016-10-01"}
}
```

#### Get current PST for a province

`/v1/prov/pst/:prov`

##### Example response
Will return a rate of `null` if there is no applicable HST for a province.

```
{
	"rate":0.10,
	"last_modified":"2016-10-01"
}
```

#### Get current PST for all provinces

`/v1/prov/pst/all`

##### Example response
Will return a rate of `null` if there is no applicable HST for a province.

```
{
	"ab":{"rate":null,"last_modified":"2016-10-01"},
	"bc":{"rate":0.07,"last_modified":"2016-10-01"},
	"mb":{"rate":0.08,"last_modified":"2016-10-01"},
	"nb":{"rate":0.1,"last_modified":"2016-10-01"},
	"nl":{"rate":0.1,"last_modified":"2016-10-01"},
	"nt":{"rate":null,"last_modified":"2016-10-01"},
	"ns":{"rate":0.1,"last_modified":"2016-10-01"},
	"nu":{"rate":null,"last_modified":"2016-10-01"},
	"on":{"rate":0.08,"last_modified":"2016-10-01"},
	"pe":{"rate":0.09,"last_modified":"2016-10-01"},
	"qc":{"rate":0.9975,"last_modified":"2016-10-01"},
	"sk":{"rate":0.05,"last_modified":"2016-10-01"},
	"yt":{"rate":null,"last_modified":"2016-10-01"}
}
```

#### Get the total applicable tax for a province

`/v1/total/:prov`

##### Example response

```
{
	"rate":0.14975,
	"type":"GST+PST",
	"last_modified":"2016-10-01"
}
```

#### Get the total applicable tax for all province

`/v1/total/all`

##### Example response

```
{
	"ab":{"rate":0.05,"type":"GST","last_modified":"2016-10-01"},
	"bc":{"rate":0.12,"type":"GST+PST","last_modified":"2016-10-01"},
	"mb":{"rate":0.13,"type":"GST+PST","last_modified":"2016-10-01"},
	"nb":{"rate":0.15,"type":"HST","last_modified":"2016-10-01"},
	"nl":{"rate":0.15,"type":"HST","last_modified":"2016-10-01"},
	"nt":{"rate":0.05,"type":"GST","last_modified":"2016-10-01"},
	"ns":{"rate":0.15,"type":"HST","last_modified":"2016-10-01"},
	"nu":{"rate":0.05,"type":null,"last_modified":"2016-10-01"},
	"on":{"rate":0.13,"type":"HST","last_modified":"2016-10-01"},
	"pe":{"rate":0.14,"type":"HST","last_modified":"2016-10-01"},
	"qc":{"rate":0.14975,"type":"GST+PST","last_modified":"2016-10-01"},
	"sk":{"rate":0.1,"type":"GST+PST","last_modified":"2016-10-01"},
	"yt":{"rate":0.05,"type":"GST","last_modified":"2016-10-01"}
}
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
