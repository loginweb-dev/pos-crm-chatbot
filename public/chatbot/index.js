const express = require('express');
const axios = require('axios');
const qrcode = require("qrcode-terminal");
const cors = require('cors')
const { Client, MessageMedia, LocalAuth} = require("whatsapp-web.js");

const { io } = require("socket.io-client");
const socket = io("https://socket.loginweb.dev");

const JSONdb = require('simple-json-db');
const categorias = new JSONdb('json/categorias.json');
const productos = new JSONdb('json/productos.json');


const app = express();
app.use(cors())
app.use(express.json())

const client = new Client({
    authStrategy: new LocalAuth({
        clientId: "client-one"
    }),
    puppeteer: {
        ignoreDefaultArgs: ['--disable-extensions'],
        args: ['--no-sandbox']
    }
});

client.on("qr", (qr) => {
    qrcode.generate(qr, { small: true });
    console.log('Nuevo QR, recuerde que se genera cada 1/2 minuto.')
});

client.on('ready', () => {
	app.listen(3000, () => {
		console.log('CHATBOT ESTA LISTO');
	});
});

client.on("authenticated", () => {
});

client.on("auth_failure", msg => {
    console.error('AUTHENTICATION FAILURE', msg);

})

client.on('message', async msg => {
    console.log('MESSAGE RECEIVED', msg);
    var midata = {
        phone: msg.from,
        message: msg.body
    }
    await axios.post('https://rocha.loginweb.dev/api/chatbot/save', midata)
    socket.emit("chatbot", msg.from)
    switch (true) {
        case (msg.body === 'hola') || (msg.body === 'HOLA') || (msg.body === 'Hola') || (msg.body === 'Buenas')|| (msg.body === 'buenas')|| (msg.body === 'BUENAS'):
            var list = '*MENU PRINCIPAL* \n'
            list += '*A* .- TODAS LAS CATEGORIAS \n',
            list += '*B* .- TODOS LOS PRODUCTOS \n',
            list += '*C* .- CUPONES \n',
            list += '*D* .- SUCURSALES \n',
            list += '*E* .- REALIZAR UN PEDIDO \n',
            list += '*ENVIA UNA OPCION DEL MENU*',
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'A') || (msg.body === 'a'):
            var miresponse = await axios('https://rocha.loginweb.dev/api/pos/categorias_all')
            var list = '*CATEGORIAS* \n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*A'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+'\n'
                categorias.set('A'+miresponse.data[index].id, miresponse.data[index].id);
            }
            list += '*ENVIA UNA OPCION DEL MENU*'
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)

            break;
            //GET CATEGORY
        case categorias.has(msg.body.toUpperCase()):
            var miresponse = await axios('https://rocha.loginweb.dev/api/filtros/'+categorias.get(msg.body.toUpperCase()))
            var list = '*PRODUCTOS POR CATEGORIA* \n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*B'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+'\n'
                productos.set('B'+miresponse.data[index].id, miresponse.data[index].id)
            }
            list += '*ENVIA UNA OPCION DEL MENU*'
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'B') || (msg.body === 'b'):
            var miresponse = await axios('https://rocha.loginweb.dev/api/pos/productos')
            var list = '*PRODUCTOS* \n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*B'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+'\n'
                productos.set('B'+miresponse.data[index].id, miresponse.data[index].id)
            }
            list += '*ENVIA UNA OPCION DEL MENU*'
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case productos.has(msg.body.toUpperCase()):
                var miresponse = await axios('https://rocha.loginweb.dev/api/pos/producto/'+productos.get(msg.body.toUpperCase()))
                var list = '*PRODUCTO #*'+msg.body.toUpperCase()+' \n'
                list += '*NOMBRE* .- '+miresponse.data.name+' \n'
                list += '*PRECIO* .- '+miresponse.data.precio
                client.sendMessage(msg.from, list).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                var midata = {
                    phone: msg.from,
                    message: list
                }
                await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
                socket.emit("chatbot", msg.from)
                break;
        case (msg.body === 'C') || (msg.body === 'c'):
            var miresponse = await axios('https://rocha.loginweb.dev/api/pos/cupones')
            var list = '*CUPONES* \n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += miresponse.data[index].id+'.-'+miresponse.data[index].title+'\n'
            }
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'D') || (msg.body === 'd'):
                var miresponse = await axios('https://rocha.loginweb.dev/api/pos/sucursales')
                var list = '*SUCURSALES* \n'
                for (let index = 0; index < miresponse.data.length; index++) {
                    list += miresponse.data[index].id+'.-'+miresponse.data[index].name+'\n'
                }
                client.sendMessage(msg.from, list).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                var midata = {
                    phone: msg.from,
                    message: list
                }
                await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
                socket.emit("chatbot", msg.from)
                break;
        case (msg.body === 'E') || (msg.body === 'e'):
            var list = '*INGRESA EN LINK* para realizar tu pedido\n'
            list += 'https://rocha.loginweb.dev/page/catalogo'
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://rocha.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        default:
            break;
    }
});
app.get('/', async (req, res) => {
    res.send('CHATBOT');
  });

  app.post('/chat', async (req, res) => {
    // console.log(req.body.phone)
    if (req.body.type == 'text') {
        // console.log(req.body.phone)
        client.sendMessage(req.body.phone, req.body.message).then((response) => {
            if (response.id.fromMe) {
                console.log("text fue enviado!");
            }
        })
    }else if (req.body.type == 'galery') {
        // const media = MessageMedia.fromFilePath(req.query.attachment);
        // client.sendMessage(req.query.phone, media, {caption: req.query.message}).then((response) => {
        //     if (response.id.fromMe) {
        //         console.log("galery fue enviado!");
        //     }
        // });
    }else if (req.body.type == 'pin') {
        client.sendMessage(req.body.phone, req.body.message).then((response) => {
            if (response.id.fromMe) {
                console.log("pin fue enviado!");
            }
        })
    }
    res.send('CHAT');
  });


  client.initialize();
