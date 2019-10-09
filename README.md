# SelfContainedAPI

This one simple PHP source file implements three sub-systems often deployed in separate PHP frameworks that can occuply hundreds (even thousands) of files. This simplicity enables making an easier inventory of vulnerabilities. Since this code does not call any external code, you need only the minimum to preserve the simplicity.

1. A pop-up javascript modal dialog that can present the column-value of a table record for editing, save it to the database (via an API call to this same page), and update the DOM with the edited value.

2. An API that can respond to calls to get and put data to the desired table, record and column.

3. A traditional PHP-generated multi-record table that can present columns for editing and a PHP handler that can respond to form saves and write SQL data.

A database simulator is employed to remove the complexities of dealing with SQL.

## Deployment to Your Website

First, just put this code into a PHP file and execute it. It should run and enable you to update fields via the Save button and the popup editor. When ready to deploy do these:

1. Paste the script before the ending body tag.

2. Remove the record keys initialization and database simulator code.

3. Replace calls to the database simulator with calls to your database writing code.

4. More to come...
