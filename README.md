# bahned
To search for yourself online and check your digital footprint, use an incognito or private browser window so your personal search history does not alter the results
--dev  ipv --no-dev

gcloud config set project service-bahned //[PROJECT_ID]` to change to a different project.

gcloud run deploy service-bahned \
    --source . \
    --region= europe-west1 \
    --allow-unauthenticated



# 1. Build your local image
docker build -t pieterklumperbeek .

# 2. Tag the image for Artifact Registry
docker tag pieterklumperbeek europe-west4-docker.pkg.dev/genuine-hold-127212/cloud-run-source-deploy/pieterklumperbeek:latest

# 3. Configure Docker authentication for Artifact Registry (if not already done)
gcloud auth configure-docker europe-west4-docker.pkg.dev

# 4. Push the image
docker push europe-west4-docker.pkg.dev/genuine-hold-127212/cloud-run-source-deploy/pieterklumperbeek:latest



   gcloud run services update service-bahned \
       --region=europe-west1 \
       --ingress=internal-and-cloud-load-balancing
updated



php -S localhost:8080 index.php
Open http://localhost:8080 in your browser.

gcloud run services proxy SERVICE --project service-bahned //PROJECT-ID


You can also test private services without the proxy by using a tool like curl, passing an auth token in the Authorization header:

curl -H "Authorization: Bearer $(gcloud auth print-identity-token)" SERVICE_URL


# Option A: Reset the trigger to use the default Cloud Build service account
gcloud builds triggers update rmgpgab-service-bahned-europe-west1-plklumperbeek-bahned--mafhd \
    --region=global \
    --service-account=""
A genomen foutmelding


# Option B: Run a manual build to verify your application code builds and deploys:
gcloud builds submit --config=cloudbuild.yaml


gcloud run services update service-bahned \
    --region=europe-west1 \
    --min-instances=0
Ik had hem 1 gegeven maar dan blijft hij het gebruiken dus cost omhoog

Installed github apps
google cloud build 
cloudbuild-bahned
plklumperbeek-bahned

IAM & Admin -> IAM -> genuine-hold-127212
permission table
last analysed 10-24-26
SLO service level objective max 500
select SLI goal 90% -> SLO api


# bahnl


A minimal PHP web app for Google Cloud App Engine Standard. It serves a simple home page at / and a JSON health check at /healthz.

Run locally
Requires PHP 8.5 or later.

php -S localhost:8080 index.php
Open http://localhost:8080 in your browser.

Test
php test.php
Deploy
Install and authenticate the Google Cloud CLI, select a Google Cloud project, then create its App Engine application in a supported region (only needed once):

gcloud config set project bahnl


gcloud compute regions list
## 
The command lists all available regions and provides information such as quotas and the status of the region itself.
 
gcloud auth login

er volgt:   https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=32555940559.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%3A8085%2F&scope=openid+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcloud-platform+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fappengine.admin+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fsqlservice.login+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcompute+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Faccounts.reauth&state=NNd8nHPUS0KjXYkPNTX87p7h3RxtIW&access_type=offline&code_challenge=UpiS05ye67E1X97qKewdepzgN8QtIppAMI036FwyKsA&code_challenge_method=S256


You are now logged in as [pieterklumperbeek@gmail.com].
Your current project is [bahnl].  You can change this setting by running:
  $ gcloud config set project PROJECT_ID




gcloud app create --region=Europe-west1
gcloud app deploy
Open the deployed application with:

gcloud app browse

gcloud projects describe bahnl-510213  //<PROJECT_ID>
nog niet gelukt
een staat in europe-west1, de ander in europ-west4
opvragen oa regio

gcloud compute project-info describe --project bahnl-510213 //PROJECT_ID

gcloud projects delete bahnl-510213  // <PROJECT_ID>


github intergratie? 


was nog oude app engine naar cloud run


gcloud run deploy php-translator \
    --source . \
    --region europe-west4 \
    --allow-unauthenticated \
    --set-env-vars GOOGLE_CLOUD_PROJECT=bahnl-510213






```
