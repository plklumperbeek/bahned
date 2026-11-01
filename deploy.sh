#!/usr/bin/env bash
# Deploy the Langomatic translator to Google Cloud Run.
# Usage: ./deploy.sh YOUR_PROJECT_ID [region]
set -euo pipefail

PROJECT_ID="${1:?Usage: ./deploy.sh PROJECT_ID [region]}"
REGION="${2:-europe-west4}"   # Netherlands
SERVICE="langomatic-translate"
SA_NAME="langomatic-run"
SA_EMAIL="${SA_NAME}@${PROJECT_ID}.iam.gserviceaccount.com"

gcloud config set project "$PROJECT_ID"

echo "==> Enabling APIs"
gcloud services enable run.googleapis.com cloudbuild.googleapis.com \
  artifactregistry.googleapis.com translate.googleapis.com

echo "==> Creating service account (skipped if it exists)"
gcloud iam service-accounts describe "$SA_EMAIL" >/dev/null 2>&1 || \
  gcloud iam service-accounts create "$SA_NAME" --display-name "Langomatic Cloud Run"

echo "==> Granting Cloud Translation access"
gcloud projects add-iam-policy-binding "$PROJECT_ID" \
  --member "serviceAccount:${SA_EMAIL}" \
  --role "roles/cloudtranslate.user" --condition=None >/dev/null

echo "==> Building and deploying"
gcloud run deploy "$SERVICE" \
  --source . \
  --region "$REGION" \
  --service-account "$SA_EMAIL" \
  --allow-unauthenticated \
  --memory 256Mi

gcloud run services describe "$SERVICE" --region "$REGION" --format 'value(status.url)'
