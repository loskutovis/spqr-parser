This is a green core service repository
=

Green core service is a service, which stores the dynamic data, labeled as green on a business scheme. 
It is the data, which will be pulled by the search and lighthose service, in order to make the matches.

This system is dockerized, so you should follow those steps to make it work locally:

- Add rcx-green.l alias for 127.0.0.1 to your /etc/hosts
- Execute ```composer install``` in the app folder
- Rename .env.dist to .env in app folder
- Execute ```docker-compose up``` in the root folder 
- go to http://rcx-green.l in your browser and see the welcome message