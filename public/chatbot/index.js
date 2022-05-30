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
const searchs = new JSONdb('json/searchs.json');

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
    await axios.post('https://pos.loginweb.dev/api/chatbot/save', midata)
    socket.emit("chatbot", msg.from)
    switch (true) {
        case (msg.body === 'hola') || (msg.body === 'HOLA') || (msg.body === 'Hola') || (msg.body === 'Buenas')|| (msg.body === 'buenas')|| (msg.body === 'BUENAS'):
            var list = '*MENU PRINCIPAL* \n'
            list += '*A* .- TODAS LAS CATEGORIAS \n',
            list += '*B* .- TODOS LOS PRODUCTOS \n',
            list += '*C* .- CUPONES \n',
            list += '*D* .- SUCURSALES \n',
            list += '*E* .- REALIZAR UN PEDIDO \n',
            list += '*F* .- BUSCAR PRODUCTO \n',
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
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'A') || (msg.body === 'a'):
            var miresponse = await axios('https://pos.loginweb.dev/api/pos/categorias_all')
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
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)

            break;
            //GET CATEGORY
        case categorias.has(msg.body.toUpperCase()):
            var miresponse = await axios('https://pos.loginweb.dev/api/filtros/'+categorias.get(msg.body.toUpperCase()))
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
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'B') || (msg.body === 'b'):
            var miresponse = await axios('https://pos.loginweb.dev/api/pos/productos')
            var list = '*PRODUCTOS* \n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*B'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+'\n'
                productos.set('B'+miresponse.data[index].id, miresponse.data[index].id)
                searchs.set(miresponse.data[index].name, miresponse.data[index].id)
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
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case productos.has(msg.body.toUpperCase()):
                var miresponse = await axios('https://pos.loginweb.dev/api/pos/producto/'+productos.get(msg.body.toUpperCase()))
                const media = MessageMedia.fromFilePath('imgs/default.png');
                var list = '*CODIGO* B'+miresponse.data.id+' \n'
                list += '*NOMBRE* .- '+miresponse.data.name+' \n'
                list += '*PRECIO* .- '+miresponse.data.precio+' \n'
                list += '*STOCK* .- '+miresponse.data.stock
                client.sendMessage(msg.from, media, {caption: list}).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                var midata = {
                    phone: msg.from,
                    message: list
                }
                await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
                socket.emit("chatbot", msg.from)
                break;
        case (msg.body === 'C') || (msg.body === 'c'):
            var miresponse = await axios('https://pos.loginweb.dev/api/pos/cupones')
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
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'D') || (msg.body === 'd'):
                var miresponse = await axios('https://pos.loginweb.dev/api/pos/sucursales')
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
                await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
                socket.emit("chatbot", msg.from)
                break;
        case (msg.body === 'E') || (msg.body === 'e'):
            var list = '*INGRESA EN EL SGTE LINK* para realizar tu pedido.* \n'
            list += 'https://pos.loginweb.dev/page/catalogo'
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;

        case (msg.body === 'F') || (msg.body === 'f'):
            var list = '*INGRESA UN CRITERIO DE BUSQUEDA* \n'
            list += 'con el siguiente formato S-criterio'
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body.substring(0, 2) === 's-') || (msg.body.substring(0, 2) === 'S-'):
            var misearch = msg.body.substring(2, 99)
            var miresponse = await axios.post('https://pos.loginweb.dev/api/chatbot/search', {misearch: misearch})
            var list = ''
            if (miresponse.data.length === 0) {
                list += 'No se encontraron coincidencias, prueba con otro criterio de busqueda.'
                client.sendMessage(msg.from, list).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
            } else {
                for (let index = 0; index < miresponse.data.length; index++) {
                    list += '*CODIGO* .- B'+miresponse.data[index].id+' \n'
                    list += '*NOMBRE* .- '+miresponse.data[index].name+' \n'
                    list += '*DETALE* .- '+miresponse.data[index].description+' \n'
                    list += '*PRECIO* .- '+miresponse.data[index].precio+' \n'
                    list += '*STOCK* .- '+miresponse.data[index].stock+' \n'
                    list += '------------------------------------------ \n'
                }
                client.sendMessage(msg.from, list).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                client.sendMessage(msg.from, '*'+miresponse.data.length+' productos encontrados, envia el codigo para ver mas informacion.*').then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
            }
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post('https://pos.loginweb.dev/api/chatbot/save/out', midata)
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
