# Unofficial Cookpad API
## Status
Under Development
## Introductions
A food recipe rest api sourced from <a href="https://cookpad.com" target="_BLANK">Cookpad</a> includes ingredients, instructions, description, image and author profile built with <a href="https://lumen.laravel.com/" target="_BLANK">Laravel Lumens</a>
## Base URL
https://cookpad.reivart.com/api
## Endpoints
| Endpoint                  | Example                                                                                             | Description                                             |
| ------------------------- | --------------------------------------------------------------------------------------------------- | ------------------------------------------------------ |
| `/recipes`                | [`/recipes`](https://cookpad.reivart.com/api/recipes)                                               | get all the latest recipes                             |
| `/recipe/{key}`           | [`/recipe/brokoli-tumis`](https://cookpad.reivart.com/api/recipe/brokoli-tumis)                     | get detail of one recipe                               |
| `/recipes/categories`     | [`/recipes/categories`](https://cookpad.reivart.com/api/recipes/categories)                         | get all recipe categories                               |
| `/recipes/category/{key}` | [`/recipes/category/resep-daging`](https://cookpad.reivart.com/api/recipes/category/resep-daging)   | get all the latest recipes from specific category   |
## Parameters
| Parameter                      | Example                                                                                                             | Description                                                                                 |
| -------------------------------| ------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| `search`                       | [`/recipes?search=ayam`](https://cookpad.reivart.com/api/recipes?search=ayam)                                       | search for recipes by title                                                              |
| `paginate` & `page`            | [`/recipes?paginate=10&page=2`](https://cookpad.reivart.com/api/recipes?paginate=10&page=2)                         | `paginate` is used to limit the amount of recipe data, while `page` is used to move pages   |
| `paginate` & `page` & `search` | [`/recipes?search=tumis&paginate=2&page=3`](https://cookpad.reivart.com/api/recipes?search=tumis&paginate=2&page=3) | `paginate` and `page` can also be applied together with `search`                             |
## License
Licensed under [MIT](https://opensource.org/licenses/MIT).
