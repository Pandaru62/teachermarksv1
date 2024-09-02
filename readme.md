## Teachermarks v1

L'application a été déployée dans le cadre de ma formation Studi Graduate Développeur Flutter. 
/ This app was designed for a Graduate in Web Dev.
## Author / Auteur

- Loris Buchelet - [@Pandaru62](https://github.com/Pandaru62/studi-arcadia)


## Run Locally / En local

Clone the project / Cloner le projet

```bash
  git clone https://github.com/Pandaru62/teachermarksv1.git
```

Go to the project directory / Aller dans le dossier du projet

```bash
  cd my-project
```

Make sure composer is installed, if not go to terminal and type : / Assurez-vous que composer soit intallé, sinon tapez sur le terminal :

```
composer update
composer install
```

If you get an error, check your php.ini file and make sure both lines are present or uncommented
/ En cas d'erreur vérifiez le fichier php.ini et vérifiez si les lignes ci-dessous sont présentes ou non commentées.

> extension=mysqli

Install dependencies / Installer les dépendances

Make sure Node.js is installed, if not go to https://nodejs.org

```bash
  npm install
```

Start the server / Démarrer le serveur

```bash
  npm run 
```


## Environment Variables

To run this project locally, you need to create a .env file at the root of your folder and add the following environment variables.

### Required env variables

APP_ENV=
APP_SECRET=
DATABASE_URL=

## Deploy to Heroku

