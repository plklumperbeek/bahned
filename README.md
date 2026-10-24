# bahned
To search for yourself online and check your digital footprint, use an incognito or private browser window so your personal search history does not alter the results

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
