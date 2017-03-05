# JSON-EXPR

JSON-EXPR (working title) is experimental library to build complex search criteria in MongoDB style e.g. 

```
{
	"$and": [
		{
			"$or": [
				{
					"foo": {
						"$eq": "A"
					}
				},							
				{
					"foo": {
						"$eq": "B"
					}
				}
			]

		},
		{
			"bar": {
				"$gt": 100
			}
		}
	]
}
```
## Requirements

* PHP >= 7.0

## Usage examples

* RESTful search/filtering



