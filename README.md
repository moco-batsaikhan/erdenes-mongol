Erdenes mongol
=============================
It's a document of Erdenes mongol web system

Development Guide
------------------------

0. $ composer require symfony/security-bundle
1. $ php bin/console make:user
2. $ php bin/console make:migration
3. $ php bin/console doctrine:migrations:migrate
4. $ php bin/console make:auth
5. $ composer require symfonycasts/verify-email-bundle
6. $ php bin/console make:registration-form
7. $ composer require symfony/google-mailer
8. $ php bin/console make:entity

