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

The only parameter curently supported is `:prov` which is either a [two letter canadian province postal abbreviation](https://en.wikipedia.org/wiki/Canadian_postal_abbreviations_for_provinces_and_territories#List_of_postal_abbreviations) or `all` to retreive all possible information.

#### Get current GST

`/api/v1/fed/gst`

#### Get current HST for a province

`/api/v1/fed/hst/:prov`

#### Get current PST for a province

`/api/v1/prov/pst/:prov`

#### Get total applicable tax for a province

`/api/v1/total/:prov`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
