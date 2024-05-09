const express = require("express");
const app = express();

app.use(express.json());

app.get('/', (req, res) => {
    res.send('Server is running.');
});


const server = require('http').createServer(app);
const io = require('socket.io')(server, { cors: {origin: "*"} });

app.post('/send-message-to-user', (req, res) => {
    const body = req.body;
    console.log(body)
    io.emit(`get-message/${body.channel_id}`, body);
    res.json({ message: 'Get in app.post and send to socket.' });
}); 


server.listen(3000, () => {
    console.log('Server is running.');
})