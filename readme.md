# Arena.Api.Core

The `arena.api.core` repository is the essential backend resource to 
all of our frontend projects. Our api is designed using Laravel, and 
our frontend projects utilize a combination of Angular and Ionic.

The purpose of this document is to provide our backend developers with 
the conventions and practices we use. While we do believe in the general 
use of _best practices_, there are some areas where we diverge.

This document should provide you with all the information needed to 
understand and work on our projects while adhering to our coding styles 
and other conventions.

## General Conventions

These are some of the common conventions we use:

- Use "camelCase" even for acronyms such as `Uuid`.
- Prefix variables by type, such as `strExample` for strings.

### Config Settings

We use different environments for all of our apps (develop, staging, master) and 
the same for API. There are some cases when you need to know some vars that depends on
current environment app. We use `arena.php` config to describe all of that variables.
We have specific helper functions that allows you to get correct values from this config file.
- `app_url(APP_NAME)` - returns application url according to current environment.
- `cloud_url(APP_NAME)` - returns CDN of application that according to current env.
- `bucket_name(APP_NAME)` - returns S3 Bucket Name.
- `app_var(APP_NAME, VAR_NAME, IS_VERSIONING)` - returns variable from `arena.php` config. 
set `IS_VERSIONING` variable to `true` if the variable what you need placed in 
`develop`, `staging` or `web` array in config file.

### Documentation

Currently, our most recent documentation is available at 
[develop.core.api.arena.com/docs](https://develop.core.api.arena.com/docs/). 
The "develop" version is constantly being updated; for the official
production docs, visit [core.api.arena.com/docs](https://core.api.arena.com/docs/). 
We will be updating the api documentation system in the near future.

#### Documenting Endpoints

For documenting we use postman api docs. 
To create new endpoint documenting you need create new request in out collection.
All requests sorting by folders like our routes files.
It will be regular request but with some changes.

In url param you need to use variable instead data.
Example: [https://core.api.arena.com/office/apparel/product/{product}]

And if you have some data that you need send to endpoint we use next schema:
- `KEY` - Variable name that request takes.
- `VALUE` - Simple value (If you have some name in key in value it will be "Name", for boolean 1 or 0 etc.).
- `DESCRIPTION` - First word must be "Required" or "Optional", Second one is variable type and everything else is description.


### Git Conventions
    
#### Branches
In our repositories we have 3 general branches, that are linked to Instances. 
They are:
 - [master](https://core.api.arena.com/) 
 - [staging](https://staging.core.api.arena.com/)
 - [develop](https://develop.core.api.arena.com/)
 
For development, you have to use `develop` branch. Also, you can make new 
branches from `develop` for you usage. We have a few rules for naming branches.
1. All of sub-branches must have one of the 3 prefixes:
     - `feat` - for development of new features;
     - `bugfix` - for providing fixes of the bugs;
     - `hotfix` - for providing hotfixes.

2. Brunch names must have the prefix and Jira's task core. So, the pattern of 
branch name - `PREFIX/TASK-CODE`. E.g - `feat/API-1`.

After merging your branch to `develop` you must remove your branch from the remote repository.
You can do that using this command:
 ```bash
 git push origin -d YOUR_BRANCH_NAME
 ```

#### Commit Messages
We have a few rules for building commit message text.
1. Commit message must have a Jira's task code.
2. Use title case for the message. So, format of commit message is 
`TASKCODE: Your Commit Message.`. E.g `API-1: Some Important Changes`.

#### Pull Requests
When you are sure, that `develop` branch is ready to go to staging stage you have 
to make pull request from `develop` to `staging` branch. A few conventions about Pull Requests:
1. The PR's title must have format `BRANCH_FROM => BRANCH-TO`. So, your PR title will be 
`Develop => Staging`.
2. You have to add some description of the changes, that have to be merged in PR's description block.

#### Github Actions

We use `Github Actions` to automate deployment and build process. You can find them 
in `./.github` directory. Usually you will not have to edit them. But if you need to edit them, 
you have to test new version on `develop` branch, and then make Pull Request to Staging.
You can see building process in real time at this page: [Github Actions](https://github.com/ArenaOps/arena.api.core/actions).   

 
## Authorization Service

At one time you will need to give the access to your endpoint only for one group of users.
For this purpose we have Auth Service. You are able to see it by this path: 
`./app/Services/Auth/Auth.php`. You have a few ways to use this service. But the mostly 
recommended is using `is_authorized()` helper function. Parameters:
1. `$objUser`. Required. `\App\Models\Users\User`. The User Model Instance.
2. `$strGroup`. Required. `string`. The name of auth group, that you are checking for.
3. `$strPermission`. Required. `string`. The name of auth permission, that you are checking for.
4. `$app`. Optional. `string`. If you need to check the application, from request comes, 
you will need to pass the name of this application to this parameter.
5. `$silentException`. Optional. `bool`. Default - `true`. Pass `true` if you want throwing 
exceptions by this function.

The example of usages:
 ```php
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
//...
if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
    return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
}
 ```

You can find the list of Auth Groups in `core_auth_groups` table.

The list of auth permission are placed in `core_auth_permissions` table. 

## Entity Naming Conventions

Laravel has a practice of adding entity names to the end of filenames, 
such as `ExampleController` and `ExampleTrait`. However, these entities 
all exist within base folders that indicate their purpose, such as 
`\app\Http\Controllers` and `\app\Traits`. 

This redundancy makes it unappealing. It is made worse by the fact that 
Laravel does not do this for all entities. Everything from facades and 
listeners and models do not have entity suffixes applied to them.

For these reasons and more, we don't include entity suffixes in filenames.

### File Organization

The Arena Core API is responsible for receiving requests and serving 
responses for all of our frontend projects. As such, there are a myriad 
number of entity files that are shared by these projects or exclusive 
to a specific project.

To accommodate this situation, we create subfolders that represent a 
specific project. For example, if a controller is used by Soundblock, 
it will be stored in `\app\Http\Controllers\Soundblock`.

 - For Merchandising projects, we further segment them by placing them in 
   a "Merch" folder, such as `\app\Http\Controllers\Merch\Apparel`.
   
 - For Office projects, which serve as the central admin of our 
   organization, the folders will appear similar to 
   `\app\Http\Controllers\Office\Merch\Apparel`.
   
  - Finally, we will sometimes use "Core" for files that are shared among 
    all of our projects. And in rare cases, they may simply be stored in 
    the root, such as `\app\Http\Controllers`.

## Database Indexes

While often a painful process, creating proper indexes for our database 
tables is extremely important for optimal performance. If this task is 
neglected, it can have very serious consequences for our projects.

As a general rule, all `id` and `uuid` fields should have an index. These 
should appear as follows:

```php 
$table->unique('row_id', 'uidx_row-id');
$table->unique('row_uuid', 'uidx_row-uuid');

$table->index(['fieldx_id', 'fieldy_id'], 'idx_fieldx-id_fieldy-id');
```

Pay close attention to the index names. They start with `uidx` for unique 
indexes and `idx` for normal indexes. Field names are shared in the index 
name using dashes to replace underscores. We use the underscore to separate 
the index type and other field names.  

Because we use Eloquent, we must append `->toSql()` in our query builder 
chains to see the raw query output. We can then use that information to 
create the optimal indexes for our queries.

### Creating Optimal Indexes

As a general rule, anything that appears after a `WHERE` clause requires an 
index, with the field names in the order they appear. This is also true for 
`GROUP BY` and `ORDER BY` clauses.

Using the above example, it can be assumed that one of our queries has a 
query that looks something like `WHERE fieldx_id = ? AND fieldy_id = ?`. If 
we swapped the fields, the indexes would also need to be swapped. _The order 
of indexes must match the order that fields are used in a query._

If you need help creating optimal indexes, please ask for assistance in 
[#plang-code-sql](https://arenaops.slack.com/archives/C01150TJRMG).

## Testing

We use `feature` and `unit` tests to testing our API. Before committing changes 
to `develop` branch you must run the tests and be sure that all of them was successfully 
passed. You can run them using `php artisan test` command or via PHPStorm phpunit module.
But, firstly you must make `arena_api_test` database in your local MySQL server.

### Writing Tests
 
 For new features that you develop you have to write at least `feature` tests that checks 
 response JSON structure, data in response body, response status code, and the result of SQL 
 insert/update query (if you use them in the new feature). If you are not familiar with 
 Laravel's testing system you can read more [here](https://laravel.com/docs/7.x/http-tests).
 
 There are few things that you need to know: 
 1. Test Classes must have `Test` suffix. Example of class name: `UserProfileTest`.
 2. Test Methods must have `test` prefix. Example of method name: `testSignIn`.
 3. For generating dummy data you should use 
 [Laravel Factories](https://laravel.com/docs/7.x/database-testing#generating-factories)
 4. When you write `unit` test you should change parent class to `Tests\TestCase`.
