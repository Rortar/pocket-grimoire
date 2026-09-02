# Render Test Deployment

This repo includes a Render Blueprint in `render.yaml`.

1. Push this branch to GitHub, GitLab, or Bitbucket.
2. In Render, create a new Blueprint instance from the repo.
3. Render will create:
   - a free Docker web service named `pocket-grimoire`
   - a free Postgres database named `pocket-grimoire-db`
4. The image fetches and compiles the current TPI character data during the build.
5. The container runs Doctrine migrations on startup.
6. Use the generated `onrender.com` URL for the Storyteller page and QR draw links.

Notes:

- Free Render web services sleep after idle periods, so the first request can be slow.
- Free Render Postgres databases expire after 30 days. Use this only for testing.
- The Docker Apache config intentionally ignores `public/.htaccess` so Render preview URLs do not get redirected to `www.*`.
