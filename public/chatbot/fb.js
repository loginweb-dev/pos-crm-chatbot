var app = require('express')();
var MessengerPlatform = require('facebook-bot-messenger');
var server = require('http').Server(app);
var bot = MessengerPlatform.create({
    pageID: '277693723065936',
    appID: '1187176525449439',
    appSecret: '1b45e69cf5e45c401a7c24565cf5c11a',
    validationToken: 'EAAQ3uxMVyN8BAJAxDtx8FJpnAqzcLxRpZCkNMnhMwqyKtt3aruhNMYchR3z2vFf6CnI10lNS9B0KDFwy0H6U6XrlVPYtqsk6DX5UpPZBJHWTAoXtPwv3D6LSycv9NpEuziC9GUZCKot0lgXbLwjU9X0BOFotUX5gBSEJbkf82rmsQRvZCgP7',
    pageToken: 'EAAQ3uxMVyN8BAGsZBSAlPAne1dN3qa31M1dxR1NfQxpI5peZAZBO3kfQ10QyCSLwiLLjh1cZBq5QjcY0tUClo0t7ZC5gByR5qvPtzCujbv4GCm9GQxfrFTHcWjdUvmT8r3o2Xw5AVzbd48T20hh3ZCxtbGAUo8L0vpyIhgbPehr9DLlPo88Afw7Sbetkg9zTQatHeXZCb0dWQZDZD'
  }, server);
app.use(bot.webhook('/webhook'));
bot.on(MessengerPlatform.Events.MESSAGE, function(userId, message) {
  // add code below.
    console.log(userId)
    console.log(message)
});
server.listen(3010, () => {
    console.log('CHATBOT ESTA LISTO EN EL PUERTO: '+process.env.CHATBOT_PORT);
});
