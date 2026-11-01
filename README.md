# Langomatic Translator (Google Cloud Run + PHP)

Small PHP app that translates Indonesian sentences to Dutch using the Google Cloud Translation API. It runs in a container on Cloud Run and authenticates with the service account (no API keys in code).

```
langomatic-run/
├── Dockerfile          # php:8.3-apache, listens on Cloud Run's $PORT
├── deploy.sh           # enables APIs, creates service account, deploys
├── public/index.php    # form + translation logic
└── .dockerignore
```

## Deploy

1. Create (or pick) a Google Cloud project with billing enabled.
2. Install and log in to the gcloud CLI: `gcloud auth login`
3. Run:
   ```
   chmod +x deploy.sh
   ./deploy.sh YOUR_PROJECT_ID            # default region: europe-west4 (Netherlands)
   ```
4. The script prints the service URL when it finishes.

## Local test (optional)

```
docker build -t langomatic-translate .
docker run -p 8080:8080 -e GCP_ACCESS_TOKEN=$(gcloud auth print-access-token) langomatic-translate
```
Open http://localhost:8080 and try: `Apa ayah minum teh` → Dutch.

## Notes

- `--allow-unauthenticated` makes the page public. Anyone can use it and Translation API usage is billed to you, so consider removing that flag or adding a login / rate limit before sharing the URL.
- The service account only has `roles/cloudtranslate.user`.
- To use it from langomatic.nl later, point a custom domain at the Cloud Run service (Cloud Run domain mappings) or call it from your main site.
