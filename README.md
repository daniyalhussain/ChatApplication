# Chat application with PHP and React

This chatapplication is made from scratch, there is no framework involved. It contains an ORM system from scratch. The communcation between the backend and the frontend happens through JSON. There database that is used is SQLITE. Please also read **what can be done better** because there was no time for all of this to implement and I focussed on building from scratch.

### Setup

First install the node packages for react.
```sh
$ cd javascript
$ npm install
$ npm run-script watch
```
 
 after that u can set the token of the user through the url. Like this:
 ```sh
?user=2
```

after this you can start chatting. There is no function to start a chat with someone, but there are already chats made in the /database.db file. These users id have a chat 1 and 2.
### What could be done better
First of all I like to use socket instead of the api calls with interval. This ensures useless request which can give unneccesary load to the server. I also recommend to use a framework like Symfony or Laravel main reason for that is that they already come with robuust code/security. If I would go on with building from scratch i would definitely finish the ORM.  



