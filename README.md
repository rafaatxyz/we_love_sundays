# We Love Sundays

> Calculate sundays between two give dates

Provided endpoint:

> [POST] /api/v1/count-sundays

## Validations

- Provide validation that ensures that the dates are least two years apart but no more than
five
- The start date cannot be a Sunday
- The start date cannot be greater than the end date
- The number of Sundays between the two dates (including the days selected) excluding any Sunday that falls on or after the 28th of the month.

## Controller Logic

https://github.com/rafaatxyz/we_love_sundays/blob/master/app/Http/Controllers/SundayController.php

## Sample CURL request

```bash
curl -XPOST -H "Content-type: application/json" -d '{
  "start_date": "2021-01-30",
  "end_date": "2024-03-31"
}' 'http://localhost:8000/api/v1/count-sundays'
```

## Development

1. Clone project
2. Composer install
3. Artisan migrate
4. Artisan serve