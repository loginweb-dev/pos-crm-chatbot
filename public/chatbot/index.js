const express = require('express');
const axios = require('axios');
const qrcode = require("qrcode-terminal");
const cors = require('cors')
const { Client, MessageMedia, LocalAuth} = require("whatsapp-web.js");

const { io } = require("socket.io-client");
const socket = io("https://socket.appxi.net");

const JSONdb = require('simple-json-db');
const categorias = new JSONdb('json/categorias.json');
const productos = new JSONdb('json/productos.json');
const cupones = new JSONdb('json/cupones.json');
const carts = new JSONdb('json/carts.json');
const pasarelas = new JSONdb('json/pasarelas.json');
const sucursales = new JSONdb('json/sucursales.json');

require('dotenv').config({ path: '../../.env' })

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
	app.listen(process.env.CHATBOT_PORT, () => {
		console.log('CHATBOT ESTA LISTO EN EL PUERTO: '+process.env.CHATBOT_PORT);
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
    await axios.post(process.env.APP_URL+'api/chatbot/save', midata)
    socket.emit("chatbot", msg.from)
    switch (true) {
        case (msg.body === 'hola') || (msg.body === 'HOLA') || (msg.body === 'Hola') || (msg.body === 'Buenas')|| (msg.body === 'buenas') || (msg.body === 'BUENAS') || (msg.body === '0'):
            var list = '*Hola*, soy el 🤖CHATBOT🤖 de la empresa de DESARROLLO EN SOFTWARE: *'+process.env.APP_NAME+'* \n'
            list += '*MENU PRINCIPAL* \n'
            list += '----------------------------------'+' \n'
            list += '*A* .- TODAS LAS CATEGORIAS \n'
            list += '*B* .- TODOS LOS PRODUCTOS \n'
            list += '*C* .- CUPONES \n'
            list += '*D* .- SUCURSALES \n'
            list += '*E* .- BUSCAR UN PRODUCTO \n'
            list += '*F* .- VER MI CARRITO \n'
            list += '----------------------------------'+' \n'
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
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'A') || (msg.body === 'a'):
            var miresponse = await axios(process.env.APP_URL+'api/chatbot/categorias')
            var list = '*TODAS LAS CATEGORIAS* \n'
            list += '----------------------------------'+' \n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*A'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+' - ('+miresponse.data[index].productos.length+')\n'
                categorias.set('A'+miresponse.data[index].id, miresponse.data[index].id);
            }
            list += '----------------------------------'+' \n'
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
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case categorias.has(msg.body.toUpperCase()):
            var miresponse = await axios(process.env.APP_URL+'api/filtros/'+categorias.get(msg.body.toUpperCase()))
            var list = '*PRODUCTOS POR CATEGORIA* \n'
            list += '----------------------------------'+' \n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*B'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+' - *'+miresponse.data[index].precio+' Bs.)*\n'
            }
            list += '*B* .- TODOS LOS PRODUCTOS \n'
            list += '----------------------------------'+' \n'
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
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'B') || (msg.body === 'b'):
            var miresponse = await axios(process.env.APP_URL+'api/chatbot/productos')
            var list = '*TODOS LOS PRODUCTOS* \n'
            list += '--------------------------------------------\n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*B'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+' - ('+miresponse.data[index].precio+' Bs.)\n'
                productos.set('B'+miresponse.data[index].id, miresponse.data[index].id)
            }
            list += '--------------------------------------------\n'
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
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case productos.has(msg.body.toUpperCase()):
                var miresponse = await axios(process.env.APP_URL+'api/pos/producto/'+productos.get(msg.body.toUpperCase()))
                let media = ''
                if (miresponse.data.image) {
                    media = MessageMedia.fromFilePath('../../storage/app/public/'+miresponse.data.image)
                } else {
                    media = MessageMedia.fromFilePath('imgs/default.png');
                }
                var categoria = miresponse.data.categoria ? miresponse.data.categoria.name : 'categoria no registrada'
                var marca = miresponse.data.marca ? miresponse.data.marca.name : 'marca no registrada'
                var list = '*CODIGO* B'+miresponse.data.id+'\n'
                list += '*NOMBRE* .- '+miresponse.data.name+'\n'
                list += '*DETALLE* .- '+miresponse.data.description+'\n'
                list += '*CATEGORIA* .- '+categoria+' \n'
                list += '*MARCA* .- '+marca+' \n'
                list += '*PRECIO* .- '+miresponse.data.precio+' Bs.\n'
                list += '*STOCK* .- '+miresponse.data.stock+'\n'
                list += '--------------------------'+'\n'
                list += '*ADD* .- AÑADIR A CARRITO\n'
                list += '*B* .- TODOS LOS PRODUCTOS\n'
                list += '*0* .- VOLVER A MENU PRINCIPAL'
                var midata2 = {
                    phone: msg.from,
                    message: list
                }
                client.sendMessage(msg.from, media, {caption: list}).then((response) => {
                    if (response.id.fromMe) {console.log("text fue enviado!")
                    }
                })
                await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata2)
                socket.emit("chatbot", msg.from)
                carts.set(msg.from, miresponse.data.id)
                break;
        case (msg.body === 'C') || (msg.body === 'c'):
            var miresponse = await axios(process.env.APP_URL+'api/pos/cupones')
            var list = '*TODOS LOS CUPONES* \n'
            list += '------------------------------------'+'\n'
            for (let index = 0; index < miresponse.data.length; index++) {
                list += '*C'+miresponse.data[index].id+'* .- '+miresponse.data[index].title+'\n'
                cupones.set('C'+miresponse.data[index].id, miresponse.data[index].id)
            }
            list += '------------------------------------'+'\n'
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
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'D') || (msg.body === 'd'):
                var miresponse = await axios(process.env.APP_URL+'api/pos/sucursales')
                var list = '*TODAS NUESTRAS SUCURSALES*\n'
                list += '------------------------------------'+'\n'
                for (let index = 0; index < miresponse.data.length; index++) {
                    list += '*D'+miresponse.data[index].id+'* .- '+miresponse.data[index].name+'\n'
                    sucursales.set('D'+miresponse.data[index].id, miresponse.data[index].id)
                }
                list += '------------------------------------'+'\n'
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
                await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
                socket.emit("chatbot", msg.from)
                break;
        case (msg.body === 'E') || (msg.body === 'e'):
            var list = '*INGRESA UN CRITERIO DE BUSQUEDA* \n'
            list += 'con el siguiente formato: *$mi busqueda o $producto1* ..'
            let media3 = MessageMedia.fromFilePath('imgs/search.gif')
            client.sendMessage(msg.from, media3, {caption: list}).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body.substring(0, 1) === '$'):
            var misearch = msg.body.substring(1, 99)
            var miresponse = await axios.post(process.env.APP_URL+'api/chatbot/search', {misearch: misearch})
            var list = miresponse.data.length+' *Resultados de la busqueda :* "'+misearch+'" \n'
            list += '------------------------------------------ \n'
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
                    list += '*CATEGORIA* .- '+categoria+' \n'
                    list += '*MARCA* .- '+marca+' \n'
                    list += '*PRECIO* .- '+miresponse.data[index].precio+' Bs. \n'
                    list += '*STOCK* .- '+miresponse.data[index].stock+' \n'
                    list += '------------------------------------------ \n'
                }
                list += '*Envia el CODIGO del producto para agregar a tu carrito.*'
                client.sendMessage(msg.from, list).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
            }
            var midata = {
                phone: msg.from,
                message: list
            }
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', midata)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'F') || (msg.body === 'f'):
            var midata = {
                chatbot_id: msg.from
            }
            var miresponse = await axios.post(process.env.APP_URL+'api/chatbot/cart/get', midata)
            if (miresponse.data.length != 0) {
                var list = '🛒*Lista de productos en tu carrito*🛒 \n'
                var total = 0
                list += '------------------------------------------ \n'
                for (let index = 0; index < miresponse.data.length; index++) {
                    list += '*CODIGO* .- B'+miresponse.data[index].product_id+' \n'
                    list += '*NOMBRE* .- '+miresponse.data[index].producto.name+' \n'
                    list += '*DESCRIPCION* .- '+miresponse.data[index].producto.description+' \n'
                    list += '*PRECIO* .- '+miresponse.data[index].producto.precio+' Bs.\n'
                    list += '*CANTIDAD* .- '+miresponse.data[index].cantidad+' \n'
                    list += '------------------------------------------ \n'
                    total += miresponse.data[index].producto.precio * miresponse.data[index].cantidad
                }
                list += '*TOTAL* .- '+total+' Bs. \n'
                list += '------------------------------------------ \n'
                list += '*G* .- Enviar pedido \n'
                list += '------------------------------------------ \n'
                list += '*H* .- Vaciar Carrito \n'
                list += '*0* .- MENU PRINCIPAL \n'
                client.sendMessage(msg.from, list).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                var miout = {
                    phone: msg.from,
                    message: list
                }
                await axios.post(process.env.APP_URL+'api/chatbot/save/out', miout)
                socket.emit("chatbot", msg.from)
            } else {
                client.sendMessage(msg.from, '❌ *Tu carrito esta vacio* ❌ \n *0* .- MENU PRINCIPAL').then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                var miout = {
                    phone: msg.from,
                    message: '❌ *Tu carrito esta vacio* ❌ \n *0* .- MENU PRINCIPAL'
                }
                await axios.post(process.env.APP_URL+'api/chatbot/save/out', miout)
                socket.emit("chatbot", msg.from)
            }
            break;
        case pasarelas.has(msg.body.toUpperCase()):
            var pago_id = msg.body.substring(1, 99)
            var mediag = MessageMedia.fromFilePath('imgs/gracias.gif')
            var midata = {
                chatbot_id: msg.from,
                pago_id: pago_id
            }
            var miventa = await axios.post(process.env.APP_URL+'api/chatbot/venta/save', midata)
            client.sendMessage(msg.from, mediag, {caption: '🕦 *Pedido #'+miventa.data.id+' Enviado* 🕦 \n Se te notificara el proceso de tu pedido, por esta mismo medio. \n 🎉 *GRACIAS POR TU PREFERENCIA* 🎉'}).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', '🕦 *Pedido #'+miventa.data.id+' Enviado* 🕦 \n Se te notificara el proceso de tu pedido, por esta mismo medio. \n 🎉 *GRACIAS POR TU PREFERENCIA* 🎉')
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'G') || (msg.body === 'g'):
            var midata = {
                chatbot_id: msg.from
            }
            var micart = await axios.post(process.env.APP_URL+'api/chatbot/cart/get', midata)
            if (micart.data.length != 0)
            {
                var pagos = await axios(process.env.APP_URL+'api/chatbot/pasarelas/get')
                var list = '*PUEDES PAGAR POR ESTOS METODOS*\n'
                list += '------------------------------------------ \n'
                for (let index = 0; index < pagos.data.length; index++) {
                    list += '*P'+pagos.data[index].id+'* .- '+pagos.data[index].title+'\n'
                    pasarelas.set('P'+pagos.data[index].id, pagos.data[index].id)
                }
                list += '------------------------------------------ \n'
                list += 'Genial ✌ como quieres pagar tu pedido ? envia *c3 o c1* .. para confirmar tu pedido.'
                var miout = {
                    phone: msg.from,
                    message: list
                }
                await axios.post(process.env.APP_URL+'api/chatbot/save/out', miout)
                socket.emit("chatbot", msg.from)
                client.sendMessage(msg.from, list).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
            } else {
                client.sendMessage(msg.from, '❌ *Tu carrito esta vacio* ❌ \n *0* .- MENU PRINCIPAL').then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                var miout = {
                    phone: msg.from,
                    message: '❌ *Tu carrito esta vacio* ❌ \n *0* .- MENU PRINCIPAL'
                }
                await axios.post(process.env.APP_URL+'api/chatbot/save/out', miout)
                socket.emit("chatbot", msg.from)
            }
            break;
        case (msg.body === 'H') || (msg.body === 'h'):
            var midata = {
                chatbot_id: msg.from
            }
           await axios.post(process.env.APP_URL+'api/chatbot/cart/clean', midata)
            client.sendMessage(msg.from, '❌ *Tu carrito esta vacio* ❌ \n *0* .- MENU PRINCIPAL').then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var miout = {
                phone: msg.from,
                message: '❌ *Tu carrito esta vacio* ❌ \n *0* .- MENU PRINCIPAL'
            }
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', miout)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body === 'ADD') || (msg.body === 'add'):
            client.sendMessage(msg.from, 'Genial ✌, Ingresa una cantidad para agragar a tu carrito\ncon el formato: *+1 o +2 ..*').then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
            var miout = {
                phone: msg.from,
                message: 'Genial ✌, Ingresa una cantidad para agragar a tu carrito\ncon el formato: *+1 o +2 ..*'
            }
            await axios.post(process.env.APP_URL+'api/chatbot/save/out', miout)
            socket.emit("chatbot", msg.from)
            break;
        case (msg.body.substring(0, 1) === '+'):
            var cant = msg.body.substring(1, 99)
            var product_id = carts.get(msg.from)
            var product = await axios(process.env.APP_URL+'api/pos/producto/'+product_id)
            var midata = {
                product_id: product.data.id,
                product_name: product.data.name,
                chatbot_id: msg.from,
                precio: product.data.precio,
                cantidad: cant
            }
            await axios.post(process.env.APP_URL+'api/chatbot/cart/add', midata)
            client.sendMessage(msg.from, '🎉 Producto agregado a tu carrito 🎉\n*F* .- VER MI CARRITO').then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })

            await axios.post(process.env.APP_URL+'api/chatbot/save/out', '🎉 Producto agregado a tu carrito 🎉\n*F* .- VER MI CARRITO')
            socket.emit("chatbot", msg.from)
            break;
        default:
            var chatstatus = await axios.post(process.env.APP_URL+'api/chatbot/cliente/control/get', {chatbot_id: msg.from})
            if (chatstatus.data.chatbot_status) {
                // client.sendMessage(msg.from, 'Esta en charla con un HUMANO').then((response) => {
                //     if (response.id.fromMe) {
                //         console.log("text fue enviado!");
                //     }
                // })
            } else {
                var mediadefault = MessageMedia.fromFilePath('imgs/chatbot.png')
                var list = '*Hola*, soy el 🤖CHATBOT🤖 de la tienda en linea: '+process.env.APP_NAME+' \n'
                list += '*MENU PRINCIPAL* \n'
                list += '*A* .- TODAS LAS CATEGORIAS \n'
                list += '*B* .- TODOS LOS PRODUCTOS \n'
                list += '*C* .- CUPONES \n'
                list += '*D* .- SUCURSALES \n'
                list += '*E* .- BUSCAR UN PRODUCTO \n'
                list += '*F* .- VER MI CARRITO \n \n'
                list += '*ENVIA UNA OPCION DEL MENU*'
                client.sendMessage(msg.from, mediadefault, {caption: list}).then((response) => {
                    if (response.id.fromMe) {
                        console.log("text fue enviado!");
                    }
                })
                var midata = {
                    phone: msg.from,
                    message: list
                }
                await axios.post(process.env.APP_URL+'api/chatbot/save/out', list)
                socket.emit("chatbot", msg.from)
            }
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
