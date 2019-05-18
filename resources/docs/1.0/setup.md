# Application Setup 

---

- [Get Started](#get-started)
- [Backend](#backend)
- [Frontend](#frontend)

<a name="get-started"></a>
## Get Started
- Clone the repo :
```bash
git clone git@github.com:ansezz/laravel-vuejs.com.git
```

<a name="backend"></a>

## BackEnd
### Build Setup
- Configuration file
```bash
cp .env.example .env
```

- Install dependencies
```bash
composer install :
```
- Migrate database :
```bash
php artisan migrate
```

- Seed demo data :
```bash
php artisan db:seed
```
Or Import existing Wordpress articles. First export you article, follow this [tutorial](https://en.support.wordpress.com/export/).

You will get an `XML` file, after that run this command : 
```bash
php artisan wp:import /path/to/your/xml/file.xml
```
You will get all articles with images, tags and categories

- Run the commands necessary to prepare Passport for use : 
```bash
php artisan passport:install
```

#### Docs

- For detailed explanation on how things work, checkout the [Laravel docs](https://github.com/laravel/laravel).

<a name="frontend"></a>

## Frontend
- Front project using VueJs Nuxt inside `front` folder
```bash
cd front 
```
- Configuration file
```bash
cp .env.example .env
```

### Build Setup
```bash
# install dependencies
$ npm install # Or yarn install

# serve with hot reload at localhost:3000
$ npm run dev

# build for production and launch server
$ npm run build
$ npm start

```

#### Docs

- For detailed explanation on how things work, checkout the [Nuxt.js docs](https://github.com/nuxt/nuxt.js).
