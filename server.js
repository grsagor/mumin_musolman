const express = require("express");
const app = express();

app.get('/', (req, res) => {
    res.send('Server is running.');
});


const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: {origin: "*"}
});

io.on('connection', (socket) => {
    console.log('Connected')
    socket.on('sendChatToServer', (body) => {
        body?.subscripers.forEach(subscriber => {
            socket.broadcast.emit(`sendChatToClient/${subscriber.user_id}`, body);
        });
    });
    socket.on('disconnect', (socket) => {
        console.log('Disconnected.');
    })
})

server.listen(3000, () => {
    console.log('Server is running.');
})
