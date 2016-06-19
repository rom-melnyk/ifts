# ifts.if.ua site

# Development and deploy
- `npm run start` to develop. Open the [http://localhost:8080/index.html] in browser to test it.
- `npm run prod` to create the production version in the `deploy/` folder.
  - The deploy destination can be changed in `package.json # config.deployTo {String}`. Don't forget to add it to `.gitignore`!
  - The production version could be tested using any static content server, for instance `instant -p 8080 deploy` (if not installed, run `npm install -g instant-server`).
